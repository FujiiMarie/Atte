<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Rest;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    //ホームページ
    public function index()//ログイン時にどのボタンが押せるかの画面表示
    {
        $user = Auth::user();//認証を行ったユーザー情報を取得

        $userId = Attendance::where('user_id', $user->id)->first();
        $today = Carbon::today();

        //セッションへ値が存在するか調べる場合hasを利用する　nullでない場合trueになる
        if ($request->session()->has('work_day')) 
        {
            if ($request->session()->has('end_time')) 
            {
                //表示：なし
            }
            else
            {
                //休憩中かどうか？restsテーブルからwhereでデータ取得、start_restをorser byで指定かつ一番初めのデータを持ってくる
                $userId = Rest::where('user_id', $user->id)->first();
                $today = Carbon::today();
                
                if ($request->session()->has('end_rest'))//休憩終了している
                {
                    //表示：勤務終了、休憩開始
                }
                elseif ($request->session()->has('start_rest'))//休憩中
                {
                    //表示：休憩終了
                }
                else
                {
                    //表示：勤務終了、休憩開始
                }
            }
        }
        else
        {
            //表示：勤務開始
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