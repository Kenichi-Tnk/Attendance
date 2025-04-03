<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceCorrect;
use App\Models\Rest;
use App\Http\Requests\AttendanceCorrectRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        // 現在の月を取得（クエリパラメータがない場合は今月）
        $currentMonth = $request->input('month', now()->format('Y-m'));

        // Carbonを使用して前月と翌月を計算
        $currentDate = \Carbon\Carbon::createFromFormat('Y-m', $currentMonth);
        $previousMonth = $currentDate->copy()->subMonth()->format('Y-m');
        $nextMonth = $currentDate->copy()->addMonth()->format('Y-m');

        // 現在の月の勤怠データを取得
        $attendances = Attendance::with('rests')
            ->where('user_id', Auth::id())
            ->whereYear('date', $currentDate->year)
            ->whereMonth('date', $currentDate->month)
            ->get();

        // ビューにデータを渡す
        return view('attendance.index', [
            'attendances' => $attendances,
            'currentMonth' => $currentDate->format('Y年m月'),
            'previousMonth' => $previousMonth,
            'nextMonth' => $nextMonth,
        ]);
    }

    public function show($id)
    {
        $attendance = Attendance::with('rests')->findOrFail($id);
        return view('attendance.show', compact('attendance'));
    }

    public function correct(AttendanceCorrectRequest $request, $id)
    {
        AttendanceCorrect::create([
            'user_id' => auth()->id(),
            'attendance_id' => $id,
            'date' => Attendance::findOrFail($id)->date, // 勤怠データの日付を使用
            'clock_in' => $request->clock_in,
            'clock_out' => $request->clock_out,
            'rest_start' => $request->rest_start,
            'rest_end' => $request->rest_end,
            'note' => $request->note,
            'status' => 'pending',
        ]);

        return redirect()->route('attendance.show', $id)->with('success', '修正申請が送信されました。');
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
            'status' => 'required|in:working,on_break,finished',
        ]);

        // ステータスの更新
        $attendance->update([
            'status' => $request->status,
            'clock_out' => $request->status == 'finished' ? now()->toTimeString() : $attendance->clock_out,
        ]);

        //休憩の処理
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
