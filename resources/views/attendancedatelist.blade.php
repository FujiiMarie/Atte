<x-app-layout>
    
    <x-slot name="slot">
        <div class="py-12">
            @foreach ($work_days as $work_day)
            <div class="flex justify-center text-xl font-bold pb-12">
                {{$work_day->work_day}}
            </div>
            @endforeach
            <table class="w-11/12 mx-auto">
                <tr class="border-t border-gray-400 h-16">
                    <th>名前</th>
                    <th>勤務開始</th>
                    <th>勤務終了</th>
                    <th>休憩時間</th>
                    <th>勤務時間</th>
                </tr>
                @foreach ($items as $item)
                <tr class="border-t border-gray-400 h-16 mx-1">
                    <td class="w-1/12">{{$item->user_id}}</td>
                    <td class="w-1/12">{{$item->start_time}}</td>
                    <td class="w-1/12">{{$item->end_time}}</td>
                    <td class="w-1/12">休憩時間のデータ</td>
                    <td class="w-1/12">勤務時間のデータ</td>
                </tr>
                @endforeach
            </table>
            <div class="flex justify-center text-xl font-bold pt-12">
                ここにページネーション入れる
            </div>
        </div>
    </x-slot>

</x-app-layout>