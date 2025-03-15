<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AdminStaffController extends Controller
{
    public function index()
    {
        $users = User::where('is_admin', false)->get();
        return view('admin.staff.index', compact('users'));
    }

    public function show($id, Request $request)
    {
        $user = User::findOrFail($id);
        $month = $request->input('month', now()->format('Y-m'));
        $attendances = Attendance::where('user_id', $id)
            ->where('date', 'like', $month . '%')
            ->get();
        return view('admin.staff.show', compact('user', 'attendances','month'));
    }

    public function exportCsv($id, Request $request)
    {
        $user = User::findOrFail($id);
        $month = $request->input('month', now()->format('Y-m'));
        $attendances = Attendance::where('user_id', $id)
            ->where('date', 'like', $month . '%')
            ->get();
        
        $csvData = [];
        $csvData[] = ['日付', '出勤', '退勤', '休憩', '合計'];

        foreach ($attendances as $attendance) {
            $csvData[] = [
                $attendance->date,
                $attendance->clock_in,
                $attendance->clock_out,
                $attendance->rest_time,
                $attendance->total_time,
            ];
        }

        $filename = $user->name . '_' . $month . '_勤怠.csv';
        $handle = fopen('php://memory', '+');
        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }
        rewind($handle);
        $csvContent = stream_get_contents($handle);
        fclose($handle);

        return Response::make($csvContent, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
