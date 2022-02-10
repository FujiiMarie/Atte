<x-app-layout>

    <x-slot name="slot">
        <div class="flex justify-center sm:text-xl font-bold text-base pt-12">
            {{ Auth::user()->name }}さんお疲れ様です！
        </div>
        <div class="flex justify-center text-red-500 font-bold pt-6 pb-8">
            {{ session('result') }}
        </div>
        <div class="flex justify-center flex-wrap md:space-x-12 md:pb-12">
            <form action="/start_attendance" method="POST">
                @csrf
                <button type="submit" class="md:px-32 md:py-16 md:text-xl lg:px-48 lg:py-20 bg-white font-bold text-base px-20 py-10 mb-5  disabled:cursor-not-allowed disabled:opacity-50"<?php if($btn_display['btn_start_attendance'] == false){ ?> disabled <?php } ?>>
                    勤務開始
                </button>
            </form>
            <form action="/end_attendance" method="POST">
                @csrf
                <button type="submit" class="md:px-32 md:py-16 md:text-xl lg:px-48 lg:py-20 bg-white font-bold text-base px-20 py-10 mb-5 disabled:cursor-not-allowed disabled:opacity-50" <?php if($btn_display['btn_end_attendance'] == false){ ?> disabled <?php } ?>>
                    勤務終了
                </button>
            </form>
        </div>
        <div class="flex justify-center flex-wrap md:space-x-12 md:pb-12">
            <form action="/start_rest" method="POST">
                @csrf
                <button type="submit" class="md:px-32 md:py-16 md:text-xl lg:px-48 lg:py-20 bg-white font-bold text-base px-20 py-10 mb-5 disabled:cursor-not-allowed disabled:opacity-50" <?php if($btn_display['btn_start_rest'] == false){ ?> disabled <?php } ?>>
                    休憩開始
                </button>
            </form>
            <form action="/end_rest" method="POST">
                @csrf
                <button type="submit" class="md:px-32 md:py-16 md:text-xl lg:px-48 lg:py-20 bg-white font-bold text-base px-20 py-10 mb-5 disabled:cursor-not-allowed disabled:opacity-50" <?php if($btn_display['btn_end_rest'] == false){ ?> disabled <?php } ?>>
                    休憩終了
                </button>
            </form>
        </div>    
        
    </x-slot>

</x-app-layout>