<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::where('user_id', Auth::id())->get();
        return view('attendance.index', compact('attendances'));
    }

    public function create()
    {
        $attendance = Attendance::where('user_id', Auth::id())->whereDate('date', now()->toDateString())->first();
        return view('attendance.register', compact('attendance'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'clock_in' => 'required|date_format:H:i',
            'clock_out' => 'required|date_format:H:i|after:clock_in',
        ]);

        Attendance::create([
            'user_id' => Auth::id(),
            'clock_in' => $request->clock_in,
            'clock_out' => $request->clock_out,
            'date' => now()->toDateString(),
            'status' => 'working',
        ]);

        return redirect()->route('attendance.index')->with('success', '勤怠が登録されました。');
    }

    public function update(Request $request, Attendance $attendance)
    {
        $attendance->update([
            'status' => $request->status,
        ]);

        return redirect()->route('attendance.create')->with('success', 'ステータスが更新されました。');
    }

    public function show(Attendance $attendance)
    {
        return view('attendance.show', compact('attendance'));
    }
}
