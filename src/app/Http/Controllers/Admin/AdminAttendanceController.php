<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AdminAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        $today = now()->toDateString();
        $staffs = User::where('is_admin', false)->get();

        foreach ($staffs as $staff) {
            Attendance::firstOrCreate(
                ['user_id' => $staff->id, 'date' => $today],
                [
                    'clock_in' => null,
                    'clock_out' => null,
                    'rest_time' => '00:00',
                    'total_time' => '00:00'
                ]
                );
        }

        $attendances = Attendance::where('date', $date)->get()->keyBy('user_id');

        return view('admin.attendance.index', compact('date', 'staffs', 'attendances'));
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

        // 休憩時間合計が勤務時間を超えていないかチェック
        $clockIn = strtotime($request->input('clock_in'));
        $clockOut = strtotime($request->input('clock_out'));
        if ($request->has('rests')) {
            foreach ($request->input('rests') as $rest) {
                if (!empty($rest['rest_start'])) {
                $restStart = strtotime($rest['rest_start']);
                if ($restStart < $clockIn || $restStart > $clockOut) {
                    return back()->withErrors(['rests' => '休憩開始時間が勤務時間外です'])->withInput();
                }
            }
            if (!empty($rest['rest_end'])) {
                $restEnd = strtotime($rest['rest_end']);
                if ($restEnd < $clockIn || $restEnd > $clockOut) {
                    return back()->withErrors(['rests' => '休憩終了時間が勤務時間外です'])->withInput();
                }
            }
            }
        }

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
