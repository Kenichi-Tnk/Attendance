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

        return view('admin.attendance.detail', compact('attendance'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'clock_in' => 'required|date_format:H:i',
            'clock_out' => 'required|date_format:H:i|after:clock_in',
            'rest_start' => 'nullable|date_format:H:i|before:clock_out|after:clock_in',
            'rest_end' => 'nullable|date_format:H:i|before:clock_out|after:rest_start',
            'note' => 'required|string',
        ], [
            'clock_out.after' => '出勤時間もしくは退勤時間が不適切な値です。',
            'rest_start.after' => '休憩開始時間が勤務時間外です。',
            'rest_end.after' => '休憩終了時間が勤務時間外です。',
            'note.required' => '備考を記入してください。',
        ]);

        $attendance = Attendance::findOrFail($id);

        // 勤怠情報の更新
        $attendance->update([
            'clock_in' => $request->input('clock_in'),
            'clock_out' => $request->input('clock_out'),
            'note' => $request->input('note'),
        ]);

        // 休憩時間の更新
        if ($request->has('rests')) {
            foreach ($request->input('rests') as $index => $rest) {
                if (isset($attendance->rests[$index])) {
                    $attendance->rests[$index]->update([
                        'rest_start' =>$rest['rest_start'],
                        'rest_end' => $rest['rest_end'],
                    ]);
                }
            }
        }

        return redirect()->route('admin.attendance.show', $attendance->id)->with('success', '勤怠情報が更新されました。');
    }
}
