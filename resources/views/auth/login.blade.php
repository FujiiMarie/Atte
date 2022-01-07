<x-guest-layout>

    <x-auth-card>
        <div class="text-2xl font-bold text-center">
            ログイン
        </div>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <x-input
                id="email"
                class="block my-6 w-full placeholder-gray-400" 
                type="email"
                name="email"
                :value="old('email')"
                placeholder="メールアドレス"
                required autofocus
            />

            <!-- Password -->
            <x-input
                id="password"
                class="block my-6 w-full placeholder-gray-400"
                type="password"
                name="password"
                placeholder="パスワード"
                required autocomplete="current-password"
            />
            
            <!-- Remember Me -->
            <!-- <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('パスワードを保持する') }}</span>
                </label>
            </div> -->

            <div class="flex items-center justify-center mt-4">
            <!--@if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                    {{ __('パスワードをお忘れの方はこちら') }}
                </a>
            @endif -->
            <x-button class="text-base">
                {{ __('ログイン') }}
            </x-button>
            </div>

            <div class="text-center text-sm font-bold mt-6 text-gray-400">
                アカウントをお持ちでない方はこちらから
            </div>
            
            <a class="flex justify-center text-sm font-bold text-blue-700 hover:text-purple-700" href="{{ route('register') }}">
                {{ __('会員登録') }}
            </a>

        </form>
    </x-auth-card>
    
</x-guest-layout>