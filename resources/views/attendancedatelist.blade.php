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
                <tr class="border-t border-gray-400 h-16 text-left">
                    <th class="w-1/5 pl-8">名前</th>
                    <th class="w-1/5 pl-8">勤務開始</th>
                    <th class="w-1/5 pl-8">勤務終了</th>
                    <th class="w-1/5 pl-8">休憩時間</th>
                    <th class="w-1/5 pl-8">勤務時間</th>
                </tr>
                @foreach ($attendance_list as $attendance)
                <tr class="border-t border-gray-400 h-16">
                    <td class="pl-8">{{$attendance->name}}</td>
                    <td class="pl-8">{{$attendance->start_time}}</td>
                    <td class="pl-8">{{$attendance->end_time}}</td>
                    <td class="pl-8">{{$attendance->rest_sum}}</td>
                    <td class="pl-8">{{$attendance->total_work_time}}</td>
                </tr>
                @endforeach
            </table>

            <div class="flex justify-center text-xl font-bold pt-12">
                {{ $attendance_list->links() }}
            </div>

        </div>
    </x-slot>

</x-app-layout>