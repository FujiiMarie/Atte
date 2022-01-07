<x-app-layout>
    
    <x-slot name="slot">
        <div class="py-12">
            <div class="flex justify-center text-xl font-bold pb-12">
                ここに日付つける
            </div>
            <table class="w-11/12 mx-auto">
                @csrf
                <tr class="border-t border-gray-400 h-16">
                    <th>名前</th>
                    <th>勤務開始</th>
                    <th>勤務終了</th>
                    <th>休憩時間</th>
                    <th>勤務時間</th>
                </tr>
                <tr class="border-t border-gray-400 h-16">
                    <td>名前のデータ</td>
                    <td>勤務開始のデータ</td>
                    <td>勤務終了のデータ</td>
                    <td>休憩時間のデータ</td>
                    <td>勤務時間のデータ</td>
                </tr>
            </table>
            <div class="flex justify-center text-xl font-bold pt-12">
                ここにページネーション入れる
            </div>
        </div>
    </x-slot>

</x-app-layout>