<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Rest;
use App\Models\AttendanceCorrect;
use Auth;

class UserController extends Controller
{
    //勤怠打刻をする
    public function clockIn()
    {
        $attendance = Attendance::create([
            'user_id' => Auth::id(),
            'date' => now()->toDateString(),
            'clock_in' => now(),
            'status' => 'working',
        ]);

        return redirect()->back()->with('success', 'Clocked in successfully.');
    }

    public function clockOut($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->clock_out = now();
        $attendance->status = 'finished';
        $attendance->save();

        return redirect()->back()->with('success', 'Clocked out successfully.');
    }

    //勤怠打刻画面を表示
    public function showClockPage()
    {
        $attendance = Attendance::where('user_id', Auth::id())
            ->where('date', now()->toDateString())
            ->first();
            return view('user.clock', compact('attendance'));
    }

    //勤怠一覧を確認
    public function getAttendances()
    {
        $attendances = Attendance::where('user_id', Auth::id())->get();
        return view('user.attendances', compact('attendances'));
    }

    //勤怠詳細を確認 / 修正申請
    public function getAttendanceDetail($id)
    {
        $attendance = Attendance::with('rests')->findOrFail($id);
        return view('user.attendance_detail', compact('attendance'));
    }

    public function requestCorrection(Request $request, $id)
    {
        AttendanceCorrect::create([
            'user_id' => Auth::id(),
            'attendance_id' => $id,
            'type' => $request->type,
            'requested_time' => $request->requested_time,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Correction request submitted successfully.');
    }

    //自分が行った申請を確認
    public function getRequests()
    {
        $requests = AttendanceCorrect::where('user_id', Auth::id())->get();
        return view('user.requests', compact('requests'));
    }
}
