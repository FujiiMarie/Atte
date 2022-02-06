<x-app-layout>

    <x-slot name="slot">
        <div class="py-12">
            <div class="flex flex-no-wrap justify-center gap-x-10">
                <form action="/attendancedatelist" method="post">
                    @csrf
                    <button type="submit" name="select_day" value="back" class="bg-white px-3 text-xl font-bold text-blue-600 border border-blue-600">
                        <
                    </button>
                </form>
                <div class="text-xl font-bold pb-12">
                    {{ $display_date }}
                </div>
                <form action="/attendancedatelist" method="post">
                    @csrf
                    <button type="submit" name="select_day" value="next" class="bg-white px-3 text-xl font-bold text-blue-600 border border-blue-600">
                        >
                    </button>
                </form>
            </div>

            <table class="w-11/12 mx-auto">
                <tr class="border-t border-gray-400 h-16">
                    <th>名前</th>
                    <th>勤務開始</th>
                    <th>勤務終了</th>
                    <th>休憩時間</th>
                    <th>勤務時間</th>
                </tr>
                @foreach ($attendance_list as $attendance)
                <tr class="border-t border-gray-400 h-16 mx-1">
                    <td class="w-1/12">{{$attendance->name}}</td>
                    <td class="w-1/12">{{$attendance->start_time}}</td>
                    <td class="w-1/12">{{$attendance->end_time}}</td>
                    <td class="w-1/12">{{$attendance->rest_sum}}</td>
                    <td class="w-1/12">{{$attendance->total_work_time}}</td>
                </tr>
                @endforeach
            </table>

            <div class="flex justify-center text-xl font-bold pt-12">
                {{ $attendance_list->links() }}
            </div>

        </div>
    </x-slot>

</x-app-layout>