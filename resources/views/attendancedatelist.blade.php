<x-app-layout>
    
    <x-slot name="slot">
        <div class="py-12">
            @foreach ($items as $item)
            <div class="flex justify-center text-xl font-bold pb-12">
                {{$item->work_day}}
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
                <tr class="border-t border-gray-400 h-16">
                    <td>{{$item->user_id}}</td>
                    <td>{{$item->start_time}}</td>
                    <td>{{$item->end_time}}</td>
                    <td>休憩時間のデータ</td>
                    <td>勤務時間のデータ</td>
                </tr>
                @endforeach
            </table>
            <div class="flex justify-center text-xl font-bold pt-12">
                ここにページネーション入れる
            </div>
        </div>
    </x-slot>

</x-app-layout>