@extends('layouts.default')<!-- 疑問：Tailwind CSSしか反映されてない様子。 -->

@section('title', 'Atte')

@include('layouts.header')<!-- 疑問：CSSホーム　日付一覧　ログアウトを表示しないようにしたい。 -->

@section('content')
<x-guest-layout>
    <x-auth-card>
        <div class="text-2xl font-bold text-center">
            会員登録
        </div>
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <x-input
                id="name"
                class="block my-6 w-full placeholder-gray-400"
                type="text"
                name="name"
                :value="old('name')"
                placeholder="名前"
                required autofocus
            />

            <!-- Email Address -->
            <x-input
                id="email"
                class="block my-6 w-full placeholder-gray-400"
                type="email"
                name="email"
                :value="old('email')"
                placeholder="メールアドレス"
                required
            />

            <!-- Password -->
            <x-input
                id="password"
                class="block my-6 w-full placeholder-gray-400"
                type="password"
                name="password"
                placeholder="パスワード"
                required autocomplete="new-password"
            />

            <!-- Confirm Password -->
            <x-input
                id="password_confirmation"
                class="block my-6 w-full placeholder-gray-400"
                type="password"
                name="password_confirmation"
                placeholder="確認用パスワード"
                required
            />

            <x-button class="text-base">
                {{ __('会員登録') }}
            </x-button>

            <div class="text-center text-sm font-bold mt-6 text-gray-400">
                アカウントをお持ちの方はこちらから
            </div>

            <a class="flex justify-center text-sm font-bold text-blue-700 hover:text-purple-700" href="{{ route('login') }}">
                {{ __('ログイン') }}
            </a>
            
        </form>
    </x-auth-card>
</x-guest-layout>
@endsection
@include('layouts.footer')