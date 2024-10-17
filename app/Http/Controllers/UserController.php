<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.user.index', [
            'active' => 'Manajemen',
            'users' => User::where('role', 'Administrator')->orWhere('role', 'Guru')->orderBy('nama', 'desc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.user.create', [
            'active' => 'Manajemen',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'email' => 'required|unique:users',
            'jabatan' => 'required',
            'role' => 'required',
            'password' => 'required',
        ]);
        $validatedData['password'] = Hash::make($validatedData['password']);
        User::create($validatedData);

        return redirect('/dashboard/user')->with('success', 'Pengguna telah ditambahkan!');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store_changepass(UpdateUserRequest $request, User $user)
    {
        $validatedData = $request->validated();
        $validatedData['password'] = Hash::make($validatedData['password']);
        User::where('id', $user['id'])->update($validatedData);
        return redirect('/dashboard')->with('success', 'Kata Sandi telah diubah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('dashboard.user.edit', [
            'active' => 'Manajemen',
            'user' => $user,
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function changepass()
    {
        $user = Auth::user();

        return view('dashboard.user.edit', [
            'active' => 'Manajemen',
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validatedData = $request->validated();
        $validatedData['password'] = Hash::make($validatedData['password']);
        User::where('id', $user['id'])->update($validatedData);
        return redirect('/dashboard/user')->with('success', 'Pengguna telah diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);
        return redirect('/dashboard/user')->with('success', 'Pengguna telah dihapus!');
    }
}
