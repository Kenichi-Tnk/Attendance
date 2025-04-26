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
        $correct = AttendanceCorrect::with('rests')->findOrFail($id);
        //dd($correct->rests);

        return view('admin.corrects.show', compact('correct'));
    }

    public function approve(Request $request, $id)
    {
        $correct = AttendanceCorrect::with('rests')->findOrFail($id);
        $attendance = Attendance::findOrFail($correct->attendance_id);

         // 勤怠情報を修正申請の内容で更新
        $attendance->update([
            'clock_in' => $correct->clock_in,
            'clock_out' => $correct->clock_out,
            'note' => $correct->note,
        ]);

        // 休憩データの更新
        $attendance->rests()->delete(); //既存の休憩データを削除
        foreach ($correct->rests as $rest) {
            if ($rest->rest_start !== '00:00' && $rest_end !== '00:00') {
                $attendance->rests()->create([
                    'rest_start' => $rest->rest_start,
                    'rest_end' => $rest->rest_end,
                ]);
            }
        }

        // 修正申請のステータスを更新
        $correct->update(['status' => 'approved']);

        return redirect()->route('admin.corrects.index')->with('success', '修正申請が承認されました。');
    }
}
