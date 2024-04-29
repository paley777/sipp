<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fault;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //Index
    public function index()
    {
        return view('dashboard.index', [
            'active' => 'Beranda',
            'count_fault' => Fault::count(),
            'count_student' => Student::count(),
        ]);
    }
}
