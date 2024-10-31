<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Requests\AttendanceRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $all_attendances = Attendance::with('user')->todaySearch()->get();
        $my_attendance = Attendance::userSearch()->todaySearch()->first();

        return view('index', compact('all_attendances', 'my_attendance'));
    }

    public function start()
    {
        $dt = new Carbon();
        $date = $dt->toDateString(); // CarbonクラスのtoDateStringメソッドの使用。インスタンスの持つ時刻情報から「年-月-日」の文字列を生成
        $time = $dt->toTimeString(); // CarbonクラスのtoTimeStringメソッドの使用。インスタンスの持つ時刻情報から「時:分:秒」の文字列を生成

        Attendance::create([
            'user_id' => Auth::id(), // ログイン済みユーザーのidをuser_idに入れる
            'date' => $date,
            'attendance_in' => $time
        ]);

        return redirect('/')->with('message', '勤務を開始しました');;
    }
    public function end(Request $request)
    {
        $dt = new Carbon(); // 現在時刻のCarbonインスタンス生成
        $time = $dt->toTimeString(); // CarbonクラスのtoTimeStringメソッドの使用。インスタンスの持つ時刻情報から「時:分:秒」の文字列を生成

        Attendance::find($request->attendance_id)->update([
            'attendance_out' => $time
        ]);

        return redirect('/')->with('message', '勤務を終了しました');
    }

    public function update(AttendanceRequest $request)
    {
        $attendance = $request->only(['date', 'attendance_in', 'attendance_out']);
        Attendance::find($request->attendance_id)->update($attendance);

        return redirect('/mypage')->with('message', '勤怠を更新しました');
    }
    public function destroy(Request $request)
    {
        Attendance::find($request->attendance_id)->delete();

        return redirect('/mypage')->with('message', '勤怠を削除しました');
    }
    public function store(AttendanceRequest $request)
    {
        $attendance = $request->only(['date', 'attendance_in', 'attendance_out']);
        $attendance['user_id'] = Auth::id();

        Attendance::create($attendance);

        return redirect('/mypage')->with('message', '勤怠を作成しました');
    }
}
