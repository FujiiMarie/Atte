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

        // $user = Auth::user();←不要？
        $user_id = Auth::id();
        $today = Carbon::today()->format('Y-m-d');
        $now = Carbon::now();
        $attendance = Attendance::where('user_id', $user_id)->where('work_day', $today)->first();
        // $attendanceの中身{id,user_id,work_day,start_time,end_time,create_date,update_date}

        //デバッグ
        Log::alert('useridの出力調査', ['Auth_user_id' => $user_id]);
        Log::alert('今日の出力調査', ['today' => $today]);
        Log::alert('現在時刻の出力調査', ['now' => $now]);
        Log::alert('attendanceの出力調査', ['attendance' => $attendance]);

        //①今日出勤しているかどうか？
        if($attendance != null){ //データがある場合:「勤務開始」ボタンが押せない

            //②勤務終了時間が入っているか？
            if($attendance['end_time'] != null){//入っている場合：全てのボタンが押せない

            }else{//入っていない場合：③休憩中かどうか？

                $now_rest = Rest::where('user_id', $user_id)->orderBy('start_rest', 'desc')->first();//←修正必要！！

                Log::alert('now_restの出力調査', ['now_rest' => $now_rest]);

                if($now_rest != null){//データがある場合：④休憩終了時間があるかどうか？

                    if($now_rest['end_rest'] != null){//入っている場合（休憩終了）：「勤務終了」「休憩開始」ボタンが押せる
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

        return view('attendanceregister',
            ['btn_display' => $btn_display],
            ['btn_start_attendance' => $btn_start_attendance],
            ['btn_end_attendance' => $btn_end_attendance],
            ['btn_start_rest' => $btn_start_rest],
            ['btn_end_rest' => $btn_end_rest]
        );
    }

    public function start_attendance(Request $request){}//勤務開始

    public function end_attendance(Request $request){}//勤務終了

    public function start_rest(Request $request){}//休憩開始

    public function end_rest(Request $request){}//休憩終了
    
    public function datelist()//日付一覧ページ
    {
        $items = Attendance::all();
        return view('attendancedatelist', ['items' => $items]);
    }
}