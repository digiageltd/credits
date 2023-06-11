<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreditStoreRequest;
use App\Models\Borrower;
use App\Models\Credit;
use App\Models\Installment;
use App\Services\CreditsService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Log;

class CreditsController extends Controller
{
    /**
     * @return Renderable
     */
    public function index(): Renderable
    {
        return view('credits.index')->with('credits', Credit::all());
    }

    /**
     * @return Renderable
     */
    public function create(): Renderable
    {
        return view('credits.create');
    }

    /**
     * @param CreditStoreRequest $request
     * @return RedirectResponse|Renderable
     */
    public function store(CreditStoreRequest $request): RedirectResponse|Renderable
    {
        DB::beginTransaction();

        try {
            $creditService = new CreditsService();

            $borrower = Borrower::firstOrCreate([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
            ]);

            /*
             * Since we are a bank we should not work with floats but with integers because we can lose money in rounding
             */

            // Converting to integer
            $creditAmountInteger = $creditService->convertToInt($request->amount);

            // Check if the maximum amount of active credits exceeds the .env - MAX_CREDIT_AMOUNT_PER_USER
            if (!$creditService->checkLimits($borrower->active_credits_total_amount)
                || !$creditService->checkLimits(($borrower->active_credits_total_amount + $creditAmountInteger))) {
                return $this->maximumReached($borrower, $creditService->checkRemaining($borrower->active_credits_total_amount)); // Call special page or more information
            }


            // Generating payment schedule
            $generatePaymentSchedule = $creditService->generateInstallmentSchedule($creditAmountInteger, $request->term);

            /*
             * To get the installment_amount we will check if there are more than 1 month in the schedule.
             * If there are more than 1 we will get the second amount,
             * because the first one can be higher due to the added remainder.
             */

            // Update installment amounts based on payment schedule
            $installmentAmount = $generatePaymentSchedule[0]['amount']; // Set the first installment amount

            // If there are more than 1 month, set the second installment amount
            if ($request->term > 1) {
                $installmentAmount = $generatePaymentSchedule[1]['amount'];
            }

            $credit = Credit::create([
                'borrower_id' => $borrower->id,
                'amount' => $creditAmountInteger,
                'installment_amount' => $installmentAmount,
                'term' => $request->term,
                'status' => 0
            ]);

            // Add the "credit_id" key-value pair to each internal array
            $installments = array_map(function ($installment) use ($credit) {
                $installment['credit_id'] = $credit->id; // Setting the credit_id value
                return $installment;
            }, $generatePaymentSchedule);

            Installment::insert($installments);

            DB::commit();
            return redirect()->route('credits.index')->with('success', trans('credits.notification.credit.created.successfully'));
        } catch (Exception $e) {
            Log::error('There was a problem creating credit!' . PHP_EOL . $e->getMessage());

            DB::rollBack();
            return redirect()->back()->withInput()->with('error', trans('credits.notification.credit.created.failed'));
        }
    }

    /**
     * @param Credit $credit
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function show(Credit $credit)
    {
        return view('credits.show')->with('credit', $credit);
    }


    /**
     * @param $borrower
     * @param $remainingAmount
     * @return Renderable
     */
    public function maximumReached($borrower, $remainingAmount): Renderable
    {
        return view('credits.maximum_reached')->with([
            'borrower' => $borrower,
            'remainingAmount' => $remainingAmount
        ]);
    }
}
