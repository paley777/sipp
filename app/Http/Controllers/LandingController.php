<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    //Homepage Login
    public function index()
    {
        return view('landing.index', [
            'active' => 'index',
        ]);
    }
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard')->with('success', 'Selamat Datang di Dashboard Sistem Informasi Poin Pelanggaran dan Pengarsipan Dokumen SMAN 4 Kota Bengkulu!');
        }
        return back()->with('loginError', 'E-mail/Password Anda Salah, Coba Lagi!');
    }
}
