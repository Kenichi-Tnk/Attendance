<?php

namespace App\Http\Controllers;

use App\Models\AttendanceCorrect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CorrectController extends Controller
{
    public function index()
    {
        $requests = Correct::where('user_id', Auth::id())->get();
        return view('corrects.index', compact('requests'));
    }
}
