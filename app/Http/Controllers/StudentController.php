<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Kelas;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Imports\StudentImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.student.index', [
            'active' => 'Manajemen',
            'students' => Student::orderBy('nama', 'desc')->get(),
            'kelas' => Kelas::orderBy('nama')->get(),
        ]);
    }
    public function selectByKelas($kelas)
    {
        $students = Student::where('kelas', $kelas)->orderBy('nama')->get();
        return view('dashboard.student.index', [
            'active' => 'Manajemen',
            'students' => $students,
            'kelas' => Kelas::orderBy('nama')->get(),
            'selected_kelas' => $kelas,
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function report()
    {
        return view('dashboard.student.report', [
            'active' => 'Laporan',
            'students' => Student::orderBy('nama', 'desc')->get(),
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function import(Request $request)
    {
        Excel::import(new StudentImport(), $request->file('file')->store('temp'));
        return back()->with('success', 'Data telah diimpor!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.student.create', [
            'active' => 'Manajemen',
            'classes' => Kelas::get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        $validated = $request->validated();
        Student::create($validated);
        return redirect('/dashboard/student')->with('success', 'Siswa telah ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        return view('dashboard.student.edit', [
            'active' => 'Manajemen',
            'student' => $student,
            'classes' => Kelas::get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        $validated = $request->validated();
        $student->update($validated);
        return redirect('/dashboard/student')->with('success', 'Siswa telah diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        Student::destroy($student->id);
        return redirect('/dashboard/student')->with('success', 'Siswa telah dihapus!');
    }
}
