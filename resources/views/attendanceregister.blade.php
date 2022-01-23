<x-app-layout>

    <x-slot name="slot">
        <div class="flex justify-center text-xl font-bold py-12">
            {{ Auth::user()->name }}さんお疲れ様です！
        </div>

        <form action="/" method="POST" class="flex flex-wrap justify-center pb-12 text-center">
            @csrf
            <button type="submit" class="w-2/5 mr-5 py-20 bg-white text-xl font-bold disabled:cursor-not-allowed disabled:opacity-50"<?php if("btn_display['btn_start_attendance']" == false){ ?> disabled <?php } ?>>
                勤務開始
            </button>
            <button type="submit" class="w-2/5 ml-5 py-20 bg-white text-xl font-bold disabled:cursor-not-allowed disabled:opacity-50" <?php if("btn_display['btn_end_attendance']" == false){ ?> disabled <?php } ?>>
                勤務終了
            </button>
            <button type="submit" class="w-2/5 mr-5 my-10 py-20 bg-white text-xl font-bold disabled:cursor-not-allowed disabled:opacity-50" <?php if("btn_display['btn_start_rest']" == false){ ?> disabled <?php } ?>>
                休憩開始
            </button>
            <button type="submit" class="w-2/5 ml-5 my-10 py-20 bg-white text-xl font-bold disabled:cursor-not-allowed disabled:opacity-50" <?php if("btn_display['btn_start_rest']" == false){ ?> disabled <?php } ?>>
                休憩終了
            </button>
        </form>     
        
    </x-slot>

</x-app-layout>