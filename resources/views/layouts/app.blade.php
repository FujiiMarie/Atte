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

    <body class="font-sans antialiased">

        <!-- Page Heading -->
        <header class="bg-white mx-auto p-6 flex justify-between">
            <div class="flex items-center text-4xl font-semibold">
                <a href="{{ route('dashboard') }}">
                    Atte
                </a>
            </div>
            <div class="space-x-8 ml-10 flex">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('ホーム') }}
                </x-nav-link>
                <x-nav-link :href="route('attendancedatelist')" :active="request()->routeIs('attendancedatelist')">
                    {{ __('日付一覧') }}
                </x-nav-link>
                <x-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <input type="submit" value="ログアウト">
                    </form>
                </x-nav-link>
            </div>
        </header>

        <!-- Page Content -->
        <main class="bg-gray-100">
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
