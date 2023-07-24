<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $libraries = Course::get();
        $enrollments = Enrollment::with('course')->where('user_id', Auth::id())->get();

        return view('dashboard', compact('libraries', 'enrollments'));
    }
}
