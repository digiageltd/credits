@extends('layouts.app')

@section('body')
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-2xl font-semibold leading-6 text-gray-900">{{ trans('credits.title.maximum.amount.exceeded') }}</h1>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <a href="{{ route('credits.create') }}"
                   class="block rounded-md bg-yellow-400 border border-gray-700 transition ease-in-out delay-150 px-3 py-2 text-center text-sm font-semibold text-gray-700 shadow-sm hover:bg-black hover:text-white hover:-translate-y-1 duration-300 hover:scale-110 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    {{ trans('credits.button.create.credit') }}
                </a>
            </div>
        </div>
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div
                        class="bg-white overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                        <div class="bg-gray-50 p-4 border-b">
                            <h2 class="text-base font-semibold leading-7 text-gray-900">{{ $borrower->name ?? '' }}</h2>
                        </div>
                        <div class="p-4">
                            <span
                                class="block">{{ trans('credits.page.mae.total') }}: <strong>{{ sprintf("%02.2f", $borrower->human_active_credits_total_amount) }}</strong> bgn</span>
                            @if($remainingAmount > 0)
                                <span
                                    class="block">{!! trans('credits.page.mae.max.possible', ['amount' => sprintf("%02.2f", $remainingAmount)]) !!} </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

