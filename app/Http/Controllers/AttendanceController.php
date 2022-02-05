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
        $rest_val = Rest::where('user_id', $user_id)->where('work_day', $today)->whereNull('end_rest')->first();

        if($rest_val == null){

            return redirect('/')->with('result', '休憩中ではありません');

        }else{
            $start_rest = new Carbon($rest_val->work_day.' '.$rest_val->start_rest);
            $end_rest = Carbon::now()->format('H:i:s');
            $total_rest_time = $start_rest->diffInSeconds($end_rest);

            Rest::where('user_id', $user_id)->where('work_day', $today)->where('end_rest', null)->update([
                'user_id' => Auth::id(),
                'end_rest' => Carbon::now()->format('H:i:s'),
                'rest_time' => $total_rest_time
            ]);

            return redirect('/')->with('result', '休憩終了を記録しました');            
        }
    }

    public function end_attendance(Request $request){//勤務終了
        $user_id = Auth::id();
        $today = Carbon::today()->format('Y-m-d');
        $attendance_val = Attendance::where('user_id', $user_id)->where('work_day', $today)->whereNull('end_time')->first();

        if($attendance_val == null){

            return redirect('/')->with('result', '既に勤務終了済みです');

        }else{
            $start_time = new Carbon($attendance_val->work_day.' '.$attendance_val->start_time);
            $end_time = Carbon::now()->format('H:i:s');
            $total_work_time = $start_time->diffInSeconds($end_time);

            Attendance::where('user_id', $user_id)->where('work_day', $today)->where('end_time', null)->update([
                'user_id' => Auth::id(),
                'end_time' => Carbon::now()->format('H:i:s'),
                'total_work_time' => $total_work_time
            ]);

            return redirect('/')->with('result', '勤務終了を記録しました');
        }
    }
    
    public function datelist(Request $request)//日付一覧ページ
    {
        //何日のデータか？
        //何ページ目の情報か？

        $display_date = $request['display_date'];

        //defaultの処理
        if($display_date == null){
            $display_date = Carbon::today()->format('Y-m-d');
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
            ->simplePaginate(5);
            
            Log::alert('$attendance_listの出力調査', ['$attendance_list' => $attendance_list]);

        //①php上でrestsテーブルの合計を計算する
        foreach($attendance_list as $attendance_data){
            $user_id = $attendance_data['user_id'];
            $rests_list = Rest::where('work_day',$display_date)->where('user_id',$user_id)->get();

            $rest_sum = 0;//休憩時間の合計
            foreach ($rests_list as $rest_data){
                Log::alert('$rest_dataの出力調査', ['$rest_data' => $rest_data]);
                $rest_sum =  $rest_sum + $rest_data['rest_time'];//rest_timeが取れていない？
            }

            //phpのlistオブジェクトの中身の配列にrest_sum(合計休憩時間)を入れる。
            //（※値を入れると元の$attendance_listの中身も更新される）
            $attendance_data['rest_sum'] = $rest_sum;//休憩時間

            Log::alert('$rest_sumの出力調査', ['$rest_sum' => $rest_sum]);
            Log::alert('$attendance_dataの出力調査', ['$attendance_data' => $attendance_data]);
        }
        
        return view('attendancedatelist',
            ['work_days' => $display_date],
            ['attendance_list' => $attendance_list]
        );
    }
}