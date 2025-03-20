<?php

namespace App\Http\Controllers;

use App\Models\AttendanceCorrect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CorrectController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending');
        $requests = AttendanceCorrect::where('user_id', Auth::id())
            ->where('status', $status)
            ->get();

        return view('corrects.index', compact('requests'));
    }

    public function create()
    {
        return view('corrects.create');
    }

    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'attendance_id' => 'required|exists:attendances,id',
            'reason' => 'required|string|max:255',
        ]);

        //申請の保存
        AttendanceCorrect::create([
            'user_id' => Auth::id(),
            'attendance_id' => $request->attendance_id,
            'reason' => $request->reason,
        ]);

        return redirect()->route('corrects.index')->with('success', '勤怠修正申請を送信しました');
    }

    public function show($id)
    {
        $request = AttendanceCorrect::findOrFail($id);
        return view('corrects.show', compact('request'));
    }

    public function edit($id)
    {
        $request = AttendanceCorrect::findOrFail($id);
        return view('corrects.edit', compact('request'));
    }

    public function update(Request $request, $id)
    {
        // バリデーション
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        //申請の更新
    $request = AttendanceCorrect::findOrFail($id);
    $correctRequest->update([
        'reason' => $request->reason,
    ]);

    return redirect()->route('corrects.index')->with('success', '勤怠修正申請を更新しました');
    }
}
