<x-app-layout>

    <x-slot name="slot">
        <div class="flex justify-center text-xl font-bold py-12">
            {{ Auth::user()->name }}さんお疲れ様です！
        </div>

        <form action="/attendancedatelist" method="POST" class="flex flex-wrap justify-center pb-12 text-center">
            @csrf
            {{ $btn_start_time }}
            <button class="w-2/5 mr-5 py-20 bg-white text-xl font-bold cursor-not-allowed disabled:opacity-50" disabled type="submit">
                勤務開始
            </button>
            <button class="w-2/5 ml-5 py-20 bg-white text-xl font-bold" type="submit">
                勤務終了
            </button>
            <button class="w-2/5 mr-5 my-10 py-20 bg-white text-xl font-bold" type="submit">
                休憩開始
            </button>
            <button class="w-2/5 ml-5 my-10 py-20 bg-white text-xl font-bold" type="submit">
                休憩終了
            </button>
        </form>     
        
    </x-slot>

</x-app-layout>