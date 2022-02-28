<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Rest;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;

class AttendanceController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $btn_start_attendance = false;//falseの時ボタンを押せる
        $btn_end_attendance = false;
        $btn_start_rest = false;
        $btn_end_rest = false;

        $user_id = Auth::id();
        $today = Carbon::today()->format('Y-m-d');
        $now = Carbon::now()->format('H:i:s');
        $attendance = Attendance::where('user_id', $user_id)->where('work_day', $today)->first();

        if($attendance != null){//勤務データがある場合

            if($attendance['end_time'] != '00:00:00'){//終了時間が入っている場合：全てのボタンが押せない

            }else{//終了時間が入っていない場合=終了時間が'00:00:00'の場合

                $rest = Rest::where('user_id', $user_id)->where('work_day', $today)->orderBy('start_rest', 'desc')->first();

                if($rest != null){//休憩中データがある場合

                    if($rest['end_rest'] != '00:00:00'){//休憩終了時間が入っている場合：勤務終了と休憩開始ボタンを押せる
                        $btn_end_attendance = true;
                        $btn_start_rest = true;
                    }else{//休憩終了時間が入っていない場合：休憩終了ボタンを押せる
                        $btn_end_rest = true;
                    }
                }else{//休憩中データがない場合(休憩していない)：勤務終了と休憩開始ボタンが押せる 
                    $btn_end_attendance = true;
                    $btn_start_rest = true;
                }            
            }
        }else{//勤務データがない場合：勤務開始ボタンのみ押せる
            $btn_start_attendance = true;
        }
            
        $btn_display = [
        'btn_start_attendance' => $btn_start_attendance,
        'btn_end_attendance' => $btn_end_attendance,
        'btn_start_rest' => $btn_start_rest,
        'btn_end_rest' => $btn_end_rest,
        ];

        return view('attendanceregister',
            ['btn_display' => $btn_display],
            ['btn_start_attendance' => $btn_start_attendance],
            ['btn_end_attendance' => $btn_end_attendance],
            ['btn_start_rest' => $btn_start_rest],
            ['btn_end_rest' => $btn_end_rest]
        );
    }

    public function start_attendance(Request $request){//勤務開始
        $user_id = Auth::id();
        $today = Carbon::today()->format('Y-m-d');
        $start_time = Attendance::where('user_id', $user_id)->where('work_day', $today)->value('start_time');

        if($start_time == null){
            Attendance::create([
                'user_id' => Auth::id(),
                'work_day' => Carbon::today()->format('Y-m-d'),
                'start_time' => Carbon::now()->format('H:i:s')
            ]);
            return redirect('/')->with('result', '勤務開始を記録しました');
        }else{
            return redirect('/')->with('result', '既に勤務開始済みです');
        }
    }

    public function start_rest(Request $request){//休憩開始
        $user_id = Auth::id();
        $today = Carbon::today()->format('Y-m-d');
        $start_rest = Rest::where('user_id', $user_id)->where('work_day', $today)->value('start_rest');
        $end_rest = Rest::where('user_id', $user_id)->where('work_day', $today)->value('end_rest');

        if($start_rest == null || $end_rest != null){//休憩開始がないか、もしくは休憩終了があるか
            Rest::create([  
                'user_id' => Auth::id(),
                'work_day' => Carbon::today()->format('Y-m-d'),
                'start_rest' => Carbon::now()->format('H:i:s'),
            ]);
            return redirect('/')->with('result', '休憩開始を記録しました');
        }else{
            return redirect('/')->with('result', '既に休憩開始済みです');
        }
    }

    public function end_rest(Request $request){//休憩終了
        $user_id = Auth::id();
        $today = Carbon::today()->format('Y-m-d');        
        $rest_val = Rest::where('user_id', $user_id)->where('work_day', $today)->where('end_rest', 0)->first();

        if($rest_val == null){

            return redirect('/')->with('result', '休憩中ではありません');

        }else{
            $start_rest = new Carbon($rest_val->work_day.' '.$rest_val->start_rest);
            $end_rest = Carbon::now()->format('H:i:s');
            $total_rest_time = $start_rest->diffInSeconds($end_rest);

            Rest::where('user_id', $user_id)->where('work_day', $today)->where('end_rest', 0)->update([
                'user_id' => Auth::id(),
                'end_rest' => Carbon::now()->format('H:i:s'),
                'rest_time' => $total_rest_time
            ]);

            return redirect('/')->with('result', '休憩終了を記録しました');            
        }
    }

    public function end_attendance(Request $request){
        $user_id = Auth::id();
        $today = Carbon::today()->format('Y-m-d');
        $attendance_val = Attendance::where('user_id', $user_id)->where('work_day', $today)->where('end_time', 0)->first();

        if($attendance_val == null){

            return redirect('/')->with('result', '既に勤務終了済みです');

        }else{
            $start_time = new Carbon($attendance_val->work_day.' '.$attendance_val->start_time);
            $end_time = Carbon::now()->format('H:i:s');
            $total_work_time = $start_time->diffInSeconds($end_time);

            Log::alert('$total_work_timeの出力調査', ['$total_work_time' => $total_work_time]);

            Attendance::where('user_id', $user_id)->where('work_day', $today)->where('end_time', 0)->update([
                'user_id' => Auth::id(),
                'end_time' => Carbon::now()->format('H:i:s'),
                'total_work_time' => $total_work_time
            ]);

            return redirect('/')->with('result', '勤務終了を記録しました');
        }
    }
    
    public function datelist(Request $request)
    {
        $display_date = $request['display_date'];

        if($display_date == null){
            $display_date = Carbon::today()->format('Y-m-d');
            Log::alert('$display_dateの出力調査', ['$display_date' => $display_date]);
        }

        $attendance_list = Attendance::select([
            'users.id as id',
            'attendances.user_id as user_id',
            'users.name as name',
            'attendances.start_time as start_time',
            'attendances.end_time as end_time',
            'attendances.total_work_time as total_work_time',
        ])
            ->from('users')
            ->join('attendances', function($join){
                $join->on('users.id', '=', 'attendances.user_id');
            })
            ->where('attendances.work_day',$display_date)
            ->orderBy('attendances.created_at', 'desc')
            ->paginate(2);
            $attendance_list->appends(compact('display_date'));
            
            Log::alert('$attendance_listの出力調査', ['$attendance_list' => $attendance_list]);

        foreach($attendance_list as $attendance_data){
            $user_id = $attendance_data['user_id'];
            $rests_list = Rest::where('work_day',$display_date)->where('user_id',$user_id)->get();

            $rest_sum = 0;
            foreach ($rests_list as $rest_data){
                $rest_sum =  $rest_sum + $rest_data['rest_time'];       
            }

            $attendance_data['rest_sum'] = $rest_sum;

            $seconds = $rest_sum;
            $hours = floor($seconds / 3600);
            $minutes = floor(($seconds / 60) % 60);
            $seconds = $seconds % 60;
            $hms = $hours.':'.$minutes.':'.$seconds;
            $hms = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
            $attendance_data['rest_sum'] = $hms;

            $work_seconds = $attendance_data['total_work_time'];
            $work_hours = floor($work_seconds / 3600);
            $work_minutes = floor(($work_seconds / 60) % 60);
            $work_seconds = $work_seconds % 60;
            $work_hms = sprintf("%02d:%02d:%02d", $work_hours, $work_minutes, $work_seconds);
            $attendance_data['total_work_time'] = $work_hms;
        }

        return view('attendancedatelist',
            ['display_date' => $display_date],
            ['attendance_list' => $attendance_list],
        );
    }

    public function other_day(Request $request)
    {
        $request_date = $request['display_date'];

        $select_day = $request['select_day'];
        
        if($select_day == "back"){
            $display_date = date("Y-m-d", strtotime("$request_date -1 day"));
        }else if($select_day == "next"){
            $display_date = date("Y-m-d", strtotime("$request_date +1 day"));
        }

        $attendance_list = Attendance::select([
            'users.id as id',
            'attendances.user_id as user_id',
            'users.name as name',
            'attendances.start_time as start_time',
            'attendances.end_time as end_time',
            'attendances.total_work_time as total_work_time',
        ])
            ->from('users')
            ->join('attendances', function($join){
                $join->on('users.id', '=', 'attendances.user_id');
            })
            ->where('attendances.work_day',$display_date)
            ->orderBy('attendances.created_at', 'desc')
            ->paginate(2);
            $attendance_list->appends(compact('display_date'));

        foreach($attendance_list as $attendance_data){
            $user_id = $attendance_data['user_id'];
            $rests_list = Rest::where('work_day',$display_date)->where('user_id',$user_id)->get();

            $rest_sum = 0;
            foreach ($rests_list as $rest_data){
                $rest_sum =  $rest_sum + $rest_data['rest_time'];
            }

            $attendance_data['rest_sum'] = $rest_sum;

            $seconds = $rest_sum;
            $hours = floor($seconds / 3600);
            $minutes = floor(($seconds / 60) % 60);
            $seconds = $seconds % 60;
            $hms = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
            $attendance_data['rest_sum'] = $hms;

            $work_seconds = $attendance_data['total_work_time'];
            $work_hours = floor($work_seconds / 3600);
            $work_minutes = floor(($work_seconds / 60) % 60);
            $work_seconds = $work_seconds % 60;
            $work_hms = sprintf("%02d:%02d:%02d", $work_hours, $work_minutes, $work_seconds);
            $attendance_data['total_work_time'] = $work_hms;
        }

        return view('attendancedatelist',
            ['display_date' => $display_date],
            ['attendance_list' => $attendance_list],
        );    
    }
}