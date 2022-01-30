<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Rest;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    //ホーム
    public function index(Request $request)//ログイン時にどのボタンが押せるかの画面表示
    {
        $btn_start_attendance = false;
        $btn_end_attendance = false;
        $btn_start_rest = false;
        $btn_end_rest = false;

        $user_id = Auth::id();
        $today = Carbon::today()->format('Y-m-d');
        $now = Carbon::now()->format('H:i:s');
        $attendance = Attendance::where('user_id', $user_id)->where('work_day', $today)->first();
        // $attendanceの中身{id,user_id,work_day,start_time,end_time,create_date,update_date}

        $attendance_s_t = Attendance::where('user_id', $user_id)->where('work_day', $today)->value('start_time');

        //デバッグ
        Log::alert('useridの出力調査', ['Auth_user_id' => $user_id]);
        Log::alert('今日の出力調査', ['today' => $today]);
        Log::alert('現在時刻の出力調査', ['now' => $now]);
        Log::alert('attendanceの出力調査', ['attendance' => $attendance]);

        Log::alert('attendance_s_tの出力調査', ['attendance_s_t' => $attendance_s_t]);

        //①今日出勤しているかどうか？
        if($attendance != null){ //データがある場合:「勤務開始」ボタンが押せない

            //②勤務終了時間が入っているか？
            if($attendance['end_time'] != null){//入っている場合：全てのボタンが押せない

            }else{//入っていない場合：③休憩中かどうか？

                $rest = Rest::where('user_id', $user_id)->where('work_day', $today)->orderBy('start_rest', 'desc')->first();
                // $restの中身{user_id,work_day,start_rest,end_rest,create_date,update_date}

                Log::alert('restの出力調査', ['rest' => $rest]);

                if($rest != null){//データがある場合：④休憩終了時間があるかどうか？

                    if($rest['end_rest'] != null){//入っている場合（休憩終了）：「勤務終了」「休憩開始」ボタンが押せる
                        $btn_end_attendance = true;
                        $btn_start_rest = true;
                    }else{//入っていない場合（休憩中）：「休憩終了」ボタンが押せる
                        $btn_end_rest = true;
                    }
                }else{//データがない場合：（休憩していない）：「勤務終了」「休憩開始」ボタンが押せる
                    $btn_end_attendance = true;
                    $btn_start_rest = true;
                }            
            }
        }else{//データがない場合:「勤務開始」ボタンが押せる
            $btn_start_attendance = true;
        }
            
        $btn_display = [//trueならボタン表示
        'btn_start_attendance' => $btn_start_attendance,
        'btn_end_attendance' => $btn_end_attendance,
        'btn_start_rest' => $btn_start_rest,
        'btn_end_rest' => $btn_end_rest,
        ];

        Log::alert('btn_displayの出力調査', ['btn_display' => $btn_display]);

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
            // insert into attendances(user_id, work_day, start_time) values(1, 2022-01-30, 09:00:00);
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
            // insert into rests(user_id, work_day, start_rest) values(1, 2022-01-30,  10:00:00);
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
        $start_rest = Rest::where('user_id', $user_id)->where('work_day', $today)->value('start_rest');        
        $end_rest = Rest::where('user_id', $user_id)->where('work_day', $today)->value('end_rest');

        if($end_rest == null || $start_rest != null){
            Rest::where('user_id', $user_id)->where('work_day', $today)->where('end_rest', null)->update([
            // update rests set end_rest = 2022/01/30 11:00:00 where user_id = $user_id and work_day = $work_day and end_rest = Null;
                'user_id' => Auth::id(),
                'work_day' => Carbon::today()->format('Y-m-d'),
                'end_rest' => Carbon::now()->format('H:i:s'),
            ]);

            return redirect('/')->with('result', '休憩終了を記録しました');
        }else{
            return redirect('/')->with('result', '既に休憩終了済みです');
        }
    }

    public function end_attendance(Request $request){//勤務終了
        $user_id = Auth::id();
        $today = Carbon::today()->format('Y-m-d');
        $end_time = Attendance::where('user_id', $user_id)->where('work_day', $today)->value('end_time');

        if($end_time == null){
            Attendance::where('user_id', $user_id)->where('work_day', $today)->where('end_time', $end_time)->update([
            // update attendance set end_time = 2022/01/30 12:00:00 where user_id = $user_id and work_day = $work_day end_time = Null;
                'user_id' => Auth::id(),
                'work_day' => Carbon::today()->format('Y-m-d'),
                'end_time' => Carbon::now()->format('H:i:s'),
            ]);

            return redirect('/')->with('result', '勤務終了を記録しました');
        }else{
            return redirect('/')->with('result', '既に勤務終了済みです');
        }
    }
    
    public function datelist(Request $request)//日付一覧ページ
    {
        $items = Attendance::all();
        return view('attendancedatelist', ['items' => $items]);
    }
}