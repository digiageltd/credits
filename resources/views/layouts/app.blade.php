<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ trans('general.site.name') }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-slate-100">

<div class="container mx-auto">
    <div class="py-20 text-center">
        <h1 class="text-5xl font-bold underline">
            <a href="{{ route('credits.index') }}">{{ trans('general.site.name') }}</a>
        </h1>
    </div>

    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg">
        @yield('body')
    </div>
</div>
@stack('scripts')
<script>
    // Hide success message after 5 seconds
    var successMessage = document.getElementById('successMessage');
    if (successMessage) {
        setTimeout(function() {
            successMessage.style.display = 'none';
        }, 5000);
    }

    // Hide error message after 5 seconds
    var errorMessage = document.getElementById('errorMessage');
    if (errorMessage) {
        setTimeout(function() {
            errorMessage.style.display = 'none';
        }, 5000);
    }
</script>
</body>
</html>
