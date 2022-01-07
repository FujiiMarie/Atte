<!DOCTYPE html>
<html lang="ja">
    
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>

    <body class="font-sans antialiased bg-gray-100">

        <!-- Page Heading -->
        <header class="bg-white mx-auto p-6 flex items-center text-4xl font-semibold">
            <a href="{{ route('dashboard') }}">
                Atte
            </a>
        </header>

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        <!-- Page footer -->
        <footer>
            <small class="bg-white mx-auto p-3 sm:px-6 lg:px-8 flex justify-center font-bold">
                Atte, inc.
            </small>
        </footer>
    </body>
</html>
