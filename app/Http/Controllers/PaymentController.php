<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentStoreRequest;
use App\Models\Credit;
use App\Models\Installment;
use App\Models\Payment;
use App\Services\CreditsService;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Log;
use Session;

class PaymentController extends Controller
{
    public function index(?Credit $credit = null): Renderable
    {
        return view('payments.index')->with([
            'credits' => Credit::where('status', 0)->get(),
            'selectedCredit' => $credit
        ]);
    }

    public function makePayment(PaymentStoreRequest $request)
    {
        DB::beginTransaction();

        try {
            $creditService = new CreditsService();

            // Make amount integer
            $amount = $creditService->convertToInt($request->amount);

            // Get Credit if Exists and is active
            $credit = Credit::where('status', 0)->findOrFail($request->credit);

            // Get Installments that are not paid
            $installments = $credit->installments()->where('paid', 0)->get();

            $remainingAmount = $amount;
            $paymentInstallments = [];

            foreach ($installments as $installment) {
                $installmentAmount = $installment->amount;

                if ($remainingAmount >= $installmentAmount) {
                    $remainingAmount -= $installmentAmount;
                    $paymentInstallments[] = $installment->id;
                } else {
                    break;
                }
            }

            if ($paymentInstallments) {
                Installment::whereIn('id', $paymentInstallments)->update(['paid' => 1]);
            }

            $notificationMessage = '';

            if ($remainingAmount > 0) {
                if ($remainingAmount >= $credit->remaining_balance) {
                    // The remaining amount pays off all installments and has a remainder
                    $notificationMessage = trans('credits.notification.payment.reminder', ['remaining' => sprintf("%02.2f", $creditService->convertToFloat($remainingAmount))]);
                    $amount = ($amount - $remainingAmount);

                    // Update credit status to 1 - closed
                    $credit->update(['status' => 1]);
                } else {
                    // Find the next unpaid installment with the nearest date
                    $nextInstallment = Installment::where(['paid'=> 0, 'credit_id'=>$credit->id])
                        ->orderByRaw('ABS(DATEDIFF(payment_date, CURDATE()))')
                        ->first();

                    if ($nextInstallment) {
                        // Subtract the remaining amount from the next installment
                        $newAmount = $nextInstallment->amount - $remainingAmount;

                        // Update the next installment with the new amount
                        $nextInstallment->update(['amount' => $newAmount]);

                        $notificationMessage = trans('credits.notification.amount.subtracted', ['amount' => sprintf("%02.2f", $creditService->convertToFloat($remainingAmount)) , 'date' => Carbon::parse($nextInstallment->payment_date)->format('d.m.Y')]);
                    }
                }
            }

            // Create a new payment record
            Payment::create([
                'credit_id' => $credit->id,
                'amount' => $amount
            ]);

            DB::commit();

            return redirect()->route('credits.show', ['credit' => $credit])->with('success', trans('credits.notification.payment.successful') . PHP_EOL . $notificationMessage);
        } catch (Exception $e) {
            Log::error('There was a problem processing the payment: ' . $e->getMessage());

            DB::rollBack();
            return redirect()->back()->with('error', trans('credits.notification.payment.failed'));
        }

    }

    public function makeInstallmentPayment(Installment $installment)
    {
        DB::beginTransaction();

        try {
            // Check if the previous installment is paid
            $previousInstallment = $installment->credit->installments()
                ->where('payment_date', '<', $installment->payment_date)
                ->orderBy('payment_date', 'desc')
                ->first();

            if ($previousInstallment && !$previousInstallment->paid) {
                // Previous installment is not paid, redirect with an error message
                return redirect()->back()->with('error', trans('credits.notification.previous.not.payed'));
            }

            Installment::where('id', $installment->id)->update(['paid' => 1]);

            // Check if there are any remain unpaid installments for the credit
            $remainingInstallments = $installment->credit->installments()->where('paid', 0)->count();

            // If no remaining installments, update the credit status to 1 (closed)
            if ($remainingInstallments === 0) {
                $installment->credit->update(['status' => 1]);
            }


            Payment::create([
                'credit_id' => $installment->credit->id,
                'amount' => $installment->amount
            ]);

            DB::commit();
            return redirect()->back()->with('success', trans('credits.notification.payment.successful'));
        } catch (Exception $e) {
            Log::error('There was a problem processing the payment: ' . $e->getMessage());

            DB::rollBack();
            return redirect()->back()->with('error', trans('credits.notification.payment.failed'));
        }

    }
}
