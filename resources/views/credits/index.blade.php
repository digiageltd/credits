@extends('layouts.app')

@section('body')
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-2xl font-semibold leading-6 text-gray-900">{{ trans('credits.title.index') }}</h1>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <a href="{{ route('payment.index') }}"
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
                            {{ session('success') }}
                        </div>
                    @elseif(session('error'))
                        <div class="m-4 p-4 bg-red-400 text-white border rounded-2xl" id="errorMessage">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                    {{ trans('credits.table.borrower.name') }}
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    {{ trans('credits.table.credit.amount') }}
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    {{ trans('credits.table.installment') }}
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    {{ trans('credits.table.term') }}
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    {{ trans('credits.table.credit.status') }}
                                </th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($credits as $credit)
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                        {{ $credit->borrower->name }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ sprintf("%02.2f", $credit->human_amount) }}
                                        bgn
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ sprintf("%02.2f", $credit->installment_amount) }}
                                        bgn
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        {{ $credit->term }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm">
                                        @if($credit->status)
                                            <span
                                                class="p-2 bg-lime-300 rounded-md">{{ trans('credits.table.credit.status.closed') }}</span>
                                        @else
                                            <span
                                                class="p-2 bg-blue-300 rounded-md">{{ trans('credits.table.credit.status.active') }}</span>
                                        @endif
                                    </td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                        <a href="{{ route('credits.show', ['credit' => $credit]) }}"
                                           class="lock rounded-md bg-yellow-400 border border-gray-700 transition ease-in-out delay-150 px-3 py-2 text-center text-sm font-semibold text-gray-700 shadow-sm hover:bg-black hover:text-white duration-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2">Show</a>
                                        @if(!$credit->status)
                                            <a href="{{ route('payment.index', ['credit' => $credit]) }}"
                                               class="lock rounded-md bg-yellow-400 border border-gray-700 transition ease-in-out delay-150 px-3 py-2 text-center text-sm font-semibold text-gray-700 shadow-sm hover:bg-black hover:text-white duration-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2">{{ trans('credits.button.make.payment') }}</a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="pl-6 py-4"><h4>{{ trans('credits.table.no.credits') }}</h4>
                                    </td>
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

