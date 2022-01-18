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
        $attendance = Attendance::where('user_id', $user_id)->where('work_day', $today)->first();
        // $attendanceの中身{id,user_id,work_day,start_time,end_time,create_date,update_date}

        //デバッグ
        Log::alert('useridの出力調査', ['Auth_user_id' => $user_id]);
        Log::alert('useridの出力調査', ['today' => $today]);
        // Log::alert('useridの出力調査', ['$attendance_user_id' => $attendance->user_id]);
        // Log::alert('useridの出力調査', ['$attendance_work_day' => $attendance->work_day]);
        // Log::alert('useridの出力調査', ['$attendance_end_time' => $attendance->end_time]);

        //①今日出勤しているかどうか？
        if($attendance != null){ //データがある場合:「勤務開始」ボタンが押せない
            return view('attendanceregister', ['btn_start_time' => $btn_start_time]);

            //②勤務終了時間が入っているか？
            if($attendance->end_time != null){//入っている場合：全てのボタンが押せない
                return view('attendanceregister', $btn_display);
            }else{//入っていない場合：③休憩中かどうか？
                $rest = Rest::where('user_id', $user_id)->where('work_day', $today)->first();
                // start_restをorder byで指定かつ一番初めのデータを持ってくる
                if($rest->start_rest != null){//データがある場合：④休憩終了時間があるかどうか？

                    if($rest->end_rest != null){//入っている場合（休憩終了）：「勤務終了」「休憩開始」ボタンが押せる
                        return view('attendanceregister', ['btn_end_time' => $btn_end_time], ['btn_rest_start' => $btn_rest_start]);//←trueにしたい
                    }else{//入っていない場合（休憩中）：「休憩終了」ボタンが押せる
                        return view('attendanceregister', ['btn_rest_end' => $btn_rest_end]);//←trueにしたい
                    }
                }else{//データがない場合：（休憩していない）：「勤務終了」「休憩開始」ボタンが押せる
                    return view('attendanceregister', ['btn_end_time' => $btn_end_time], ['btn_rest_start' => $btn_rest_start]);//←trueにしたい
                }            
            }
        }else{//データがない場合:「勤務開始」ボタンが押せる
            return view('attendanceregister', ['btn_start_time' => $btn_start_time]);//←trueにしたい
        }
    }


    public function start(Request $request){}//勤務開始

    public function reststart(Request $request){}//休憩開始

    public function restend(Request $request){}//休憩終了

    public function end(Request $request){}//勤務終了

    
    public function datelist()//日付一覧ページ
    {
        $items = Attendance::all();
        return view('attendancedatelist', ['items' => $items]);
    }
}