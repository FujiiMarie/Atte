<x-app-layout>

    <x-slot name="slot">
        <div class="flex justify-center text-xl font-bold pt-12">
            {{ Auth::user()->name }}さんお疲れ様です！
        </div>
        <div class="flex justify-center text-red-500 font-bold pt-6 pb-8">
            {{ session('result') }}
        </div>
        <div class="flex justify-center flex-wrap pb-12 space-x-12">
            <form action="/start_attendance" method="POST">
                @csrf
                <button type="submit" class="px-48 py-20 bg-white text-xl font-bold disabled:cursor-not-allowed disabled:opacity-50"<?php if($btn_display['btn_start_attendance'] == false){ ?> disabled <?php } ?>>
                    勤務開始
                </button>
            </form>
            <form action="/end_attendance" method="POST">
                @csrf
                <button type="submit" class="px-48 py-20 bg-white text-xl font-bold disabled:cursor-not-allowed disabled:opacity-50" <?php if($btn_display['btn_end_attendance'] == false){ ?> disabled <?php } ?>>
                    勤務終了
                </button>
            </form>
        </div>
        <div class="flex justify-center flex-wrap pb-12 space-x-12">
            <form action="/start_rest" method="POST">
                @csrf
                <button type="submit" class="px-48 py-20 bg-white text-xl font-bold disabled:cursor-not-allowed disabled:opacity-50" <?php if($btn_display['btn_start_rest'] == false){ ?> disabled <?php } ?>>
                    休憩開始
                </button>
            </form>
            <form action="/end_rest" method="POST">
                @csrf
                <button type="submit" class="px-48 py-20 bg-white text-xl font-bold disabled:cursor-not-allowed disabled:opacity-50" <?php if($btn_display['btn_end_rest'] == false){ ?> disabled <?php } ?>>
                    休憩終了
                </button>
            </form>
        </div>    
        
    </x-slot>

</x-app-layout>