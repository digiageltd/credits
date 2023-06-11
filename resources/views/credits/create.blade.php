@extends('layouts.app')

@section('body')
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-2xl font-semibold leading-6 text-gray-900">{{ trans('credits.title.create') }}</h1>
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
                    @if(session('success'))
                        <div class="m-4 p-4 bg-lime-400 border rounded-2xl" id="successMessage">
                            {{ session('success') }}
                        </div>
                    @elseif(session('error'))
                        <div class="m-4 p-4 bg-red-400 text-white border rounded-2xl" id="errorMessage">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div
                        class="bg-white overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                        <div class="bg-gray-50 p-4">
                            <h2 class="text-base font-semibold leading-7 text-gray-900">{{ trans('credits.page.create.personal.information') }}</h2>
                        </div>
                        <form method="POST" action="{{ route('credits.store') }}" class="px-4 py-4 ">
                            @csrf
                            <div class="w-1/2 space-y-12">
                                <div class="pb-12">

                                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                        <div class="sm:col-span-3">
                                            <label for="first_name"
                                                   class="block text-sm font-medium leading-6 text-gray-900">{{ trans('credits.form.create.label.first.name') }}</label>
                                            <div class="mt-2">
                                                <input type="text" name="first_name" value="{{ old('first_name') }}"
                                                       class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                @error('first_name')
                                                <div class="text-red-500">{{ $message }}</div> @enderror
                                            </div>
                                        </div>

                                        <div class="sm:col-span-3">
                                            <label for="last_name"
                                                   class="block text-sm font-medium leading-6 text-gray-900">{{ trans('credits.form.create.label.last.name') }}</label>
                                            <div class="mt-2">
                                                <input type="text" name="last_name"
                                                       class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                @error('last_name')
                                                <div class="text-red-500">{{ $message }}</div> @enderror
                                            </div>
                                        </div>

                                        <div class="sm:col-span-3">
                                            <label for="amount"
                                                   class="block text-sm font-medium leading-6 text-gray-900">{{ trans('credits.form.create.label.amount') }}</label>
                                            <div class="mt-2">
                                                <input type="text" name="amount" id="amount"
                                                       placeholder="{{ trans('credits.form.create.placeholder.amount') }}"
                                                       class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                @error('amount')
                                                <div class="text-red-500">{{ $message }}</div> @enderror
                                            </div>
                                        </div>

                                        <div class="sm:col-span-3">
                                            <label for="term"
                                                   class="block text-sm font-medium leading-6 text-gray-900">{{ trans('credits.form.create.label.term') }}</label>
                                            <div class="mt-2">
                                                <select name="term"
                                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                                    @for($i = 1; $i < 13; $i++)
                                                        <option value="{{$i}}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                                @error('term')
                                                <div class="text-red-500">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 flex items-center justify-start gap-x-6">
                                <button type="submit"
                                        class="block rounded-md bg-yellow-400 border border-gray-700 transition ease-in-out delay-150 px-3 py-2 text-center text-sm font-semibold text-gray-700 shadow-sm hover:bg-black hover:text-white hover:-translate-y-1 duration-300 hover:scale-110 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    {{ trans('credits.button.store.credit') }}
                                </button>
                                <a href="{{ url()->previous() }}"
                                   class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        const amountField = document.getElementById('amount');

        amountField.addEventListener('input', function (event) {
            const inputValue = event.target.value;

            // Remove any non-digit or non-dot characters from the input
            const cleanedValue = inputValue.replace(/[^0-9.]/g, '');

            // Check if the cleaned value matches the desired format
            const isValidFormat = /^-?\d*\.?\d*$/.test(cleanedValue);

            // Update the input field value with the cleaned value or reset if it doesn't match the desired format
            if (isValidFormat) {
                event.target.value = cleanedValue;
            } else {
                event.target.value = '';
            }
        });
    </script>
@endpush
