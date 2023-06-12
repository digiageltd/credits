@extends('layouts.app')

@section('body')
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-2xl font-semibold leading-6 text-gray-900">{{ trans('credits.title.show', ['credit' => $credit->code]) }}</h1>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <a href="{{ route('payment.index', ['credit' => $credit]) }}"
                   class="inline-block rounded-md bg-yellow-400 border border-gray-700 transition ease-in-out delay-150 px-3 py-2 text-center text-sm font-semibold text-gray-700 shadow-sm hover:bg-black hover:text-white hover:-translate-y-1 duration-300 hover:scale-110 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    {{ trans('credits.button.make.global.payment') }}
                </a>
                <a href="{{ route('credits.create') }}"
                   class="inline-block rounded-md bg-yellow-400 border border-gray-700 transition ease-in-out delay-150 px-3 py-2 text-center text-sm font-semibold text-gray-700 shadow-sm hover:bg-black hover:text-white hover:-translate-y-1 duration-300 hover:scale-110 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    {{ trans('credits.button.create.credit') }}
                </a>
            </div>
        </div>
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    @if(session('success'))
                        <div class="m-4 p-4 bg-lime-400 border rounded-2xl" id="successMessage">
                            {!! session('success')  !!}
                        </div>
                    @elseif(session('error'))
                        <div class="m-4 p-4 bg-red-400 text-white border rounded-2xl" id="errorMessage">
                            {!!  session('error')  !!}
                        </div>
                    @endif
                    <div class="py-5">
                        <span
                            class="font-bold">{{ trans('credits.page.show.credit.borrower') }}:</span> {{ $credit->borrower->name ?? '' }}
                        <span
                            class="font-bold pl-4">{{ trans('credits.page.show.credit.amount') }}:</span> {{ sprintf("%02.2f", $credit->human_amount) }}
                        {{ trans('credits.currency') }}
                        <span
                            class="font-bold pl-4">{{ trans('credits.page.show.credit.term') }}:</span>{{ trans_choice('credits.general.month', $credit->term, ['value' => $credit->term]) }}
                        <span
                            class="font-bold pl-4">{{ trans('credits.page.show.credit.remaining') }}:</span> {{ $credit->human_remaining_balance }}
                        {{ trans('credits.currency') }}
                        <span class="font-bold pl-4">{{ trans('credits.page.show.credit.status') }}:</span>
                        @if($credit->status)
                            <span
                                class="p-2 bg-lime-300 rounded-md">{{ trans('credits.table.credit.status.closed') }}</span>
                        @else
                            <span
                                class="p-2 bg-blue-300 rounded-md">{{ trans('credits.table.credit.status.active') }}</span>
                        @endif
                    </div>
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    {{ trans('credits.table.credit.amount') }}
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    {{ trans('credits.table.payment.date') }}
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    {{ trans('credits.table.payment.status') }}
                                </th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                    <span class="sr-only">{{ trans('credits.button.make.payment') }}</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($credit->installments as $installment)
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                        {{ sprintf("%02.2f", $installment->human_amount) }} {{ trans('credits.currency') }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($installment->payment_date)->format('d.m.Y') }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm">
                                        @if($installment->paid)
                                            <svg class="flex-shrink-0 w-6 h-6 text-lime-600 transition duration-75"
                                                 fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 24 24">
                                                <path
                                                    d="M19 3H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2h14c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2zm-7.933 13.481-3.774-3.774 1.414-1.414 2.226 2.226 4.299-5.159 1.537 1.28-5.702 6.841z"></path>
                                            </svg>
                                        @else
                                            <svg class="flex-shrink-0 w-6 h-6 text-red-500 transition duration-75"
                                                 fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 24 24">
                                                <path
                                                    d="M21 5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5zm-4.793 9.793-1.414 1.414L12 13.414l-2.793 2.793-1.414-1.414L10.586 12 7.793 9.207l1.414-1.414L12 10.586l2.793-2.793 1.414 1.414L13.414 12l2.793 2.793z"></path>
                                            </svg>
                                        @endif
                                    </td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                        @if(!$installment->paid)
                                            <a href="{{ route('payment.make-installment-payment', ['installment' => $installment]) }}"
                                               class="lock rounded-md bg-yellow-400 border border-gray-700 transition ease-in-out delay-150 px-3 py-2 text-center text-sm font-semibold text-gray-700 shadow-sm hover:bg-black hover:text-white duration-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2">{{ trans('credits.button.make.payment') }}</a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="pl-6 py-4"><h4>{{ trans('credits.table.no.credits') }}</h4></td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="py-6">
                        <h1 class="font-bold text-2xl">{{ trans('credits.page.show.payments') }}</h1>
                    </div>
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        {{ trans('credits.table.payment.amount') }}
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        {{ trans('credits.table.payment.date') }}
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse($credit->payments as $payment)
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                            {{ sprintf("%02.2f", $payment->human_amount) }} {{ trans('credits.currency') }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($payment->created_at)->format('d.m.Y') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="pl-6 py-4"><h4>{{ trans('credits.table.no.payments.made') }}</h4></td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection

