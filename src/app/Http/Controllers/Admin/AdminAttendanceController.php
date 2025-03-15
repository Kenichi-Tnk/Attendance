<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AdminAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        $attendances = Attendance::whereDate('date', $date)->get();
        return view('admin.attendance.index', compact('attendances', 'date'));
    }

    public function show($id)
    {
        $attendance = Attendance::findOrFail($id);

        return view('admin.attendance.show', compact('attendance'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'clock_in' => 'required|date_format:H:i',
            'clock_out' => 'required|date_format:H:i|after:clock_in',
            'rest_start' => 'nullable|date_format:H:i|before:clock_out|after:clock_in',
            'rest_end' => 'nullable|date_format:H:i|before:clock_out|after:rest_start',
            'note' => 'required|string',
        ], [
            'clock_out.after' => '出勤時間もしくは退勤時間が不適切な値です。',
            'rest_start.after' => '休憩時間が勤務時間外です。',
            'rest_end.after' => '休憩時間が勤務時間外です。',
            'note.required' => '備考を記入してください。',
        ]);

        $attendance = Attendance::findOrFail($id);
        $attendance->update($request->all());

        return redirect()->route('admin.attendance.show', $attendance->id)->with('success', '勤怠情報が更新されました。');
    }
}
