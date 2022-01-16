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
        $btn_display->btn_start_time = false;//trueならボタン表示
        $btn_display->btn_end_time = false;
        $btn_display->btn_start_rest = false;
        $btn_display->btn_end_rest = false;

        $user = Auth::user();
        $user_id = $user->id;
        $today = Carbon::today()->format('Y-m-d');
        $attendance = Attendance::where('user_id', $user_id)->where('work_day', $today)->first();
        // $attendanceの中身{id,user_id,work_day,start_time,end_time,create_date,update_date}

        Log::alert('useridの出力調査', ['$attendance_user_id' => $attendance->user_id]);
        Log::alert('useridの出力調査', ['$attendance_work_day' => $attendance->work_day]);
        Log::alert('useridの出力調査', ['$attendance_end_time' => $attendance->end_time]);

        //①今日出勤しているかどうか？
        if($attendance != null){ //データがある場合:「勤務開始」ボタンが押せない
            $btn_display->btn_start_time = false;

            //②勤務終了時間が入っているか？
            if($attendance->btn_end_time != null){//入っている場合：全てのボタンが押せない
                $btn_display = false;
            }else{//入っていない場合：③休憩中かどうか？
                $rest = Rest::where('user_id', $user_id)->where('work_day', $today)->first();

                // start_restをorder byで指定かつ一番初めのデータを持ってくる
                if($rest->start_rest != null){//データがある場合：④休憩終了時間があるかどうか？

                    if($rest->end_rest != null){//入っている場合（休憩終了）：「勤務終了」「休憩開始」ボタンが押せる
                        $btn_display->btn_end_time = true;
                        $btn_display->btn_rest_start = true;
                    }else{
                        $btn_display->btn_rest_end = true;//入っていない場合（休憩中）：「休憩終了」ボタンが押せる    
                    }
                }else{//データがない場合：（休憩していない）：「勤務終了」「休憩開始」ボタンが押せる
                    $btn_display->btn_end_time = true;
                    $btn_display->btn_start_rest = true;
                }            
            }
        }else{//データがない場合:「勤務開始」ボタンが押せる
            $btn_display->btn_start_time = true;
        }
        //bladeに$btn_displayを渡す
        

        return view('attendanceregister',compact('btn_display'));
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