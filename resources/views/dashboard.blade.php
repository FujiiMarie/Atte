<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between">
            <div class="flex items-center text-4xl font-semibold">
                <a href="{{ route('dashboard') }}">
                    Atte
                </a>
            </div>
            <div class="space-x-8 ml-10 flex">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('ホーム') }}
                </x-nav-link>
                <x-nav-link :href="route('attendancedatelist')" :active="request()->routeIs('dashboard')">
                    {{ __('日付一覧') }}
                </x-nav-link>
                <x-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <input type="submit" value="ログアウト">
                    </form>
                </x-nav-link>
            </div>
        </div>
    </x-slot>

    <x-slot name="slot">
        <div class="flex justify-center text-xl font-bold py-12">
            {{ Auth::user()->name }}さんお疲れ様です！
        </div>

        <div class="pb-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="text-xl font-bold text-center space-y-10">
                    <div class="flex flex-wrap justify-center space-x-10"> 
                        <div class="py-20 px-48 bg-white">
                            勤務開始
                        </div>
                        <div class="py-20 px-48 bg-white">
                            勤務終了
                        </div>
                    </div>
                    <div class="flex flex-wrap justify-center space-x-10"> 
                        <div class="py-20 px-48 bg-white">
                            休憩開始
                        </div>
                        <div class="py-20 px-48 bg-white">
                            休憩終了
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="footer">
        <small class="flex justify-center font-bold">
            Atte, inc.
        </small>
    </x-slot>

</x-app-layout>