<x-app-layout>

    <x-slot name="slot">
        <div class="py-12">
            <div class="flex flex-no-wrap justify-center gap-x-10">
                <form action="/attendancedatelist" method="post">
                    @csrf
                    <!-- 見えないinputタグで$display_dateを渡す -->
                    <input type="hidden" name="display_date" value="{{ $display_date }}">
                    <button type="submit" name="select_day" value="back" class="bg-white px-3 text-xl font-bold text-blue-600 border border-blue-600">
                        <
                    </button>
                </form>
                <div class="text-xl font-bold pb-12">
                    {{ $display_date }}
                </div>
                <form action="/attendancedatelist" method="post">
                    @csrf
                    <!-- 見えないinputタグで$display_dateを渡す -->
                    <input type="hidden" name="display_date" value="{{ $display_date }}">
                    <button type="submit" name="select_day" value="next" class="bg-white px-3 text-xl font-bold text-blue-600 border border-blue-600">
                        >
                    </button>
                </form>
            </div>

            <table class="w-11/12 mx-auto">
                <tr class="border-t border-gray-400 h-16 text-left">
                    <th class="sm:w-1/5 sm:pl-8 sm:text-base w-1/12 pl-3 text-xs">名前</th>
                    <th class="sm:w-1/5 sm:pl-8 sm:text-base w-1/12 pl-3 text-xs">勤務開始</th>
                    <th class="sm:w-1/5 sm:pl-8 sm:text-base w-1/12 pl-3 text-xs">勤務終了</th>
                    <th class="sm:w-1/5 sm:pl-8 sm:text-base w-1/12 pl-3 text-xs">休憩時間</th>
                    <th class="sm:w-1/5 sm:pl-8 sm:text-base w-1/12 pl-3 text-xs">勤務時間</th>
                </tr>
                @foreach ($attendance_list as $attendance)
                <tr class="border-t border-gray-400 h-16">
                    <td class="sm:w-1/5 sm:pl-8 sm:text-base w-1/12 pl-3 text-xs">{{$attendance->name}}</td>
                    <td class="sm:w-1/5 sm:pl-8 sm:text-base w-1/12 pl-3 text-xs">{{$attendance->start_time}}</td>
                    <td class="sm:w-1/5 sm:pl-8 sm:text-base w-1/12 pl-3 text-xs">{{$attendance->end_time}}</td>
                    <td class="sm:w-1/5 sm:pl-8 sm:text-base w-1/12 pl-3 text-xs">{{$attendance->rest_sum}}</td>
                    <td class="sm:w-1/5 sm:pl-8 sm:text-base w-1/12 pl-3 text-xs">{{$attendance->total_work_time}}</td>
                </tr>
                @endforeach
            </table>

            <div class="flex justify-center text-xl font-bold pt-12">
                {{ $attendance_list->links() }}
            </div>

        </div>
    </x-slot>

</x-app-layout>