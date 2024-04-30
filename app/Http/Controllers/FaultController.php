<?php

namespace App\Http\Controllers;

use App\Models\Fault;
use App\Models\Student;
use App\Http\Requests\StoreFaultRequest;
use App\Http\Requests\UpdateFaultRequest;

class FaultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.fault.index', [
            'active' => 'Manajemen',
            'faults' => Fault::orderBy('nama', 'desc')->get(),
        ]);
    }
    /**
     * Display a listing of the resource.
     */
     public function report()
    {
        return view('dashboard.fault.report', [
            'active' => 'Laporan',
            'faults' => Fault::orderBy('nama', 'desc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.fault.create', [
            'active' => 'Manajemen',
            'students' => Student::get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFaultRequest $request)
    {
        $student = Student::findOrFail($request->student_id);
        $validated = $request->validated();
        Fault::create([
            'nama' => $student->nama,
            'kelas' => $student->kelas,
            'nisn' => $validated['nisn'],
            'nama_ortu' => $validated['nama_ortu'],
            'alamat' => $validated['alamat'],
            'no_hp' => $validated['no_hp'],
            'pelanggaran' => $validated['pelanggaran'],
            'poin' => $validated['poin'],
        ]);
        return redirect('/dashboard/fault')->with('success', 'Pelanggaran telah ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fault $fault)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fault $fault)
    {
        return view('dashboard.fault.edit', [
            'active' => 'Manajemen',
            'students' => Student::get(),
            'fault' => $fault,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFaultRequest $request, Fault $fault)
    {
        $validated = $request->validated();
        $student = Student::findOrFail($request->student_id);
        $fault->update([
            'nama' => $student->nama,
            'kelas' => $student->kelas,
            'nisn' => $validated['nisn'],
            'nama_ortu' => $validated['nama_ortu'],
            'alamat' => $validated['alamat'],
            'no_hp' => $validated['no_hp'],
            'pelanggaran' => $validated['pelanggaran'],
            'poin' => $validated['poin'],
        ]);
        return redirect('/dashboard/fault')->with('success', 'Pelanggaran telah diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fault $fault)
    {
        Fault::destroy($fault->id);
        return redirect('/dashboard/fault')->with('success', 'Pelanggaran telah dihapus!');
    }
}
