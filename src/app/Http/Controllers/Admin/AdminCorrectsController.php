<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminCorrectsController extends Controller
{
    public function index()
    {
        return view('admin.corrects.index');
    }
}
