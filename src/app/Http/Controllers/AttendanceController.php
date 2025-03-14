<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Rest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::where('user_id', Auth::id())->get();
        return view('attendance.index', compact('attendances'));
    }

    public function show($id)
    {
        $attendance = Attendance::findOrFail($id);
        return view('attendance.show', compact('attendance'));
    }

    public function create()
    {
        // 前日の勤怠記録を確認し、退勤打刻がされていない場合は自動的に退勤時間を設定する
        $previousAttendance = Attendance::where('user_id', Auth::id())
        ->whereDate('date', '<', now()->toDateString())
        ->whereIn('status', ['working', 'on_break'])
        ->first();

        if ($previousAttendance) {
            // 休憩中の場合、休憩を終了する
            if ($previousAttendance->status == 'on_break') {
                $rest = $previousAttendance->rests()->whereNull('rest_end')->first();
                if ($rest) {
                    $rest->update([
                        'rest_end' => '23:59:59',
                    ]);
                }
            }

             // 勤怠記録を更新
            $previousAttendance->update([
                'status' => 'finished',
                'clock_out' => '23:59:59', // 退勤打刻がされていない場合のデフォルト退勤時間
            ]);
        }

        //当日の勤怠記録を取得
        $attendance = Attendance::where('user_id', Auth::id())->whereDate('date', now()->toDateString())->first();
        return view('attendance.register', compact('attendance'));
    }

    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'status' => 'required',
        ]);

        //勤怠記録の保存
        Attendance::create([
            'user_id' => Auth::id(),
            'date' => now()->toDateString(),
            'clock_in' => now()->toTimeString(),
            'status' => $request->status,
        ]);

        return redirect()->route('attendance.index')->with('success', '勤怠が登録されました。');
    }

    public function update(Request $request, Attendance $attendance)
    {
        // バリデーション
        $request->validate([
            'status' => 'required',
        ]);

        // 勤怠記録の更新
        $attendance->update([
            'status' => $request->status,
            'clock_out' => $request->status == 'finished' ? now()->toTimeString() : $attendance->clock_out,
        ]);

        //休憩の記録
        if ($request->status == 'on_break') {
            Rest::create([
                'attendance_id' => $attendance->id,
                'rest_start' => now()->toTimeString(),
            ]);
        } elseif ($request->status == 'working') {
            $rest = $attendance->rests()->whereNull('rest_end')->first();
            if ($rest) {
                $rest->update([
                    'rest_end' => now()->toTimeString(),
                ]);
            }
        }

        return redirect()->route('attendance.create')->with('success', 'ステータスが更新されました。');
    }
}
