<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fault;
use App\Models\Student;
use App\Models\Archive;
use App\Models\User;
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
            'count_archive' => Archive::count(),
            'count_user' => User::count(),
        ]);
    }
    //Scoreboard
    public function scoreboard()
    {
        return view('dashboard.scoreboard', [
            'active' => 'Scoreboard',
            'faults' => Fault::select('nama', 'kelas', \DB::raw('SUM(poin) as total_poin'))->groupBy('nama', 'kelas')->get(),
        ]);
    }
    //logout
    /**
     * Handle an logout attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
