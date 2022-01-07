<x-app-layout>

    <x-slot name="slot">
        <div class="flex justify-center text-xl font-bold py-12">
            {{ Auth::user()->name }}さんお疲れ様です！
        </div>

        <div class="pb-12">
            <div class="mx-auto">
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

</x-app-layout>