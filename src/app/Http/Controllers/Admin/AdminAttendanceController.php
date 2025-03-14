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
}
