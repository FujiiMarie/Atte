<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between h-12">
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
        <table class="w-screen my-5">
            @csrf
            <tr>
                <th>名前</th>
                <th>勤務開始</th>
                <th>勤務終了</th>
                <th>休憩時間</th>
                <th>勤務時間</th>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </x-slot>

    <x-slot name="footer">
      <small class="flex justify-center font-bold">Atte, inc.</small>
    </x-slot>
</x-app-layout>