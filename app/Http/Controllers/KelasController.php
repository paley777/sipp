<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Http\Requests\StoreKelasRequest;
use App\Http\Requests\UpdateKelasRequest;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.class.index', [
            'active' => 'Manajemen',
            'classes' => Kelas::orderBy('nama', 'desc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.class.create', [
            'active' => 'Manajemen',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKelasRequest $request)
    {
        $validated = $request->validated();
        Kelas::create($validated);
        return redirect('/dashboard/class')->with('success', 'Kelas telah ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kelas $kelas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kelas $class)
    {
        return view('dashboard.class.edit', [
            'active' => 'Manajemen',
            'class' => $class,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKelasRequest $request, Kelas $class)
    {
        $validated = $request->validated();
        $class->update($validated);
        return redirect('/dashboard/class')->with('success', 'Kelas telah diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kelas $class)
    {
        Kelas::destroy($class->id);
        return redirect('/dashboard/class')->with('success', 'Kelas telah dihapus!');
    }
}
