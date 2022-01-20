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
        $btn_display = [//trueならボタン表示
            'btn_start_time' => false,
            'btn_end_time' => false,
            'btn_start_rest' => false,
            'btn_end_rest' => false,
        ];

        $btn_start_time = $btn_display['btn_start_time'];
        $btn_end_time = $btn_display['btn_end_time'];
        $btn_start_rest = $btn_display['btn_start_rest'];
        $btn_end_rest = $btn_display['btn_end_rest'];

        $user = Auth::user();
        $user_id = Auth::id();
        $today = Carbon::today()->format('Y-m-d');
        $now = Carbon::now();
        $attendance = Attendance::where('user_id', $user_id)->where('work_day', $today)->first();
        $end_time = Attendance::where('end_time', $now)->first();
        // $attendanceの中身{id,user_id,work_day,start_time,end_time,create_date,update_date}

        //デバッグ
        Log::alert('useridの出力調査', ['Auth_user_id' => $user_id]);
        Log::alert('今日の出力調査', ['today' => $today]);
        Log::alert('現在時刻の出力調査', ['now' => $now]);
        Log::alert('attendanceの出力調査', ['attendance' => $attendance]);
        Log::alert('end_timeの出力調査', ['end_time' => $end_time]);

        //①今日出勤しているかどうか？
        if($attendance != null){ //データがある場合:「勤務開始」ボタンが押せない
            return view('attendanceregister', ['btn_start_time' => $btn_start_time]);

            //②勤務終了時間が入っているか？
            if($end_time != null){//入っている場合：全てのボタンが押せない
                return view('attendanceregister', $btn_display);
            }else{//入っていない場合：③休憩中かどうか？

                $start_rest = Rest::start_rest();
                $now_rest = Rest::orderBy('start_rest', 'desc')->first();

                Log::alert('start_restの出力調査', ['start_rest' => $start_rest]);
                Log::alert('now_restの出力調査', ['now_rest' => $now_rest]);

                if($now_rest != null){//データがある場合：④休憩終了時間があるかどうか？

                    if($now_rest != null){//入っている場合（休憩終了）：「勤務終了」「休憩開始」ボタンが押せる
                        $btn_end_time = true;
                        $btn_rest_start = true;
                        return view('attendanceregister', ['btn_end_time' => $btn_end_time, 'btn_rest_start' => $btn_rest_start]);
                    }else{//入っていない場合（休憩中）：「休憩終了」ボタンが押せる
                        $btn_end_rest = true;
                        return view('attendanceregister', ['btn_rest_end' => $btn_end_rest]);
                    }
                }else{//データがない場合：（休憩していない）：「勤務終了」「休憩開始」ボタンが押せる
                    $btn_end_time = true;
                    $btn_start_rest = true;
                    return view('attendanceregister', ['btn_end_time' => $btn_end_time, 'btn_rest_start' => $btn_start_rest]);
                }            
            }
        }else{//データがない場合:「勤務開始」ボタンが押せる
            $btn_start_time = true;
            return view('attendanceregister', ['btn_start_time' => $btn_start_time]);
        }
    }


    public function start(Request $request){}//勤務開始

    public function startrest(Request $request){}//休憩開始

    public function endrest(Request $request){}//休憩終了

    public function end(Request $request){}//勤務終了

    
    public function datelist()//日付一覧ページ
    {
        $items = Attendance::all();
        return view('attendancedatelist', ['items' => $items]);
    }
}