<?php

namespace App\Http\Controllers;

use App\Models\Fault;
use App\Models\Student;
use App\Models\Rule;
use App\Http\Requests\StoreFaultRequest;
use App\Http\Requests\UpdateFaultRequest;
use Illuminate\Support\Facades\Auth;

class FaultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Jika role pengguna adalah 'Siswa', tampilkan hanya fault miliknya
        if ($user->role == 'Siswa') {
            $faults = Fault::where('id_student', $user->id_student)
                ->orderBy('nama', 'desc')
                ->get();
        } else {
            // Jika bukan 'Siswa', tampilkan semua fault
            $faults = Fault::orderBy('nama', 'desc')->get();
        }

        return view('dashboard.fault.index', [
            'active' => 'Manajemen',
            'faults' => $faults,
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
            'rules' => Rule::get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFaultRequest $request)
    {
        $student = Student::findOrFail($request->student_id);
        $rule = Rule::findOrFail($request->rule_id);
        $validated = $request->validated();
        Fault::create([
            'nama' => $student->nama,
            'id_student' => $validated['student_id'],
            'kelas' => $student->kelas,
            'nisn' => $validated['nisn'],
            'nama_ortu' => $validated['nama_ortu'],
            'alamat' => $validated['alamat'],
            'no_hp' => $validated['no_hp'],
            'pelanggaran' => $rule->pelanggaran,
            'poin' => $rule->point,
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
            'rules' => Rule::get(),
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
        $rule = Rule::findOrFail($request->rule_id);
        $fault->update([
            'nama' => $student->nama,
            'kelas' => $student->kelas,
            'nisn' => $validated['nisn'],
            'nama_ortu' => $validated['nama_ortu'],
            'alamat' => $validated['alamat'],
            'no_hp' => $validated['no_hp'],
            'pelanggaran' => $rule->pelanggaran,
            'poin' => $rule->point,
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
