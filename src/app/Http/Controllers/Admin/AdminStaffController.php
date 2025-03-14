<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminStaffController extends Controller
{
    public function index()
    {
        $users = User::where('is_admin', false)->get();
        return view('admin.staff.index', compact('users'));
    }
}
