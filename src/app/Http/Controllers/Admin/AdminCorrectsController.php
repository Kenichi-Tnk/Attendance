<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceCorrect;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AdminCorrectsController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending'); // デフォルトで承認待ち
        $requests = AttendanceCorrect::where('status', $status)->get();
        return view('admin.corrects.index', compact('requests'));
    }

    public function show($id)
    {
        $correct = AttendanceCorrect::with('attendance.rests')->findOrFail($id);
        return view('admin.corrects.show', compact('correct'));
    }

    public function approve(Request $request, $id)
    {
        $correct = AttendanceCorrect::findOrFail($id);
        $attendance = Attendance::findOrFail($correct->attendance_id);

         // 勤怠情報を修正申請の内容で更新
        $attendance->update([
            'date' => $correct->date,
            'clock_in' => $correct->clock_in,
            'clock_out' => $correct->clock_out,
            'note' => $correct->note,
        ]);

        // 修正申請のステータスを更新
        $correct->update(['status' => 'approved']);

        return redirect()->route('admin.corrects.index')->with('success', '修正申請が承認されました。');
    }
}
