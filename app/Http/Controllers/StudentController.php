<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Kelas;
use App\Models\User;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Imports\StudentImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('user')->orderBy('nama', 'desc')->get(); // Memuat user terkait

        return view('dashboard.student.index', [
            'active' => 'Manajemen',
            'students' => $students,
            'kelas' => Kelas::orderBy('nama')->get(),
        ]);
    }

    public function selectByKelas($kelas)
    {
        $students = Student::with('user')->where('kelas', $kelas)->orderBy('nama')->get(); // Memuat user terkait

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

    public function store(StoreStudentRequest $request)
    {
        $validated = $request->validated();
        $student = Student::create($validated);

        $cleanName = Str::slug($student->nama, '');
        $baseEmail = $student->id . '_' . $cleanName;
        $email = $baseEmail . '@gmail.com';
        $counter = 1;

        // Cek keunikan email dan tambahkan angka jika diperlukan
        while (User::where('email', $email)->exists()) {
            $email = $baseEmail . $counter . '@gmail.com';
            $counter++;
        }

        // Email unik ditemukan, lanjutkan membuat user baru
        User::create([
            'nama' => $validated['nama'],
            'nip' => '-',
            'jabatan' => '-',
            'email' => $email,
            'password' => Hash::make('12345678'),
            'role' => 'Siswa',
            'id_student' => $student->id, // menyertakan ID siswa
        ]);

        // Kembalikan ke halaman dengan pesan sukses
        return redirect('/dashboard/student')->with('success', 'Siswa dan akun telah ditambahkan!');
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

    public function update(UpdateStudentRequest $request, Student $student)
    {
        $validated = $request->validated();

        // Cek dan update email jika 'nama' telah diubah
        if ($validated['nama'] != $student->nama) {
            $cleanName = Str::slug($validated['nama'], '');
            $baseEmail = $student->id . '_' . $cleanName;
            $email = $baseEmail . '@gmail.com';
            $counter = 1;

            // Cek keunikan email dan tambahkan angka jika diperlukan
            while (User::where('email', $email)->exists()) {
                $email = $baseEmail . $counter . '@gmail.com';
                $counter++;
            }

            // Manually find and update the associated user record
            $user = User::where('id_student', $student->id)->first();
            if ($user) {
                $user->update([
                    'email' => $email,
                    'nama' => $validated['nama'],
                ]);
            }
        }

        // Perbarui data siswa
        $student->update($validated);

        // Kembalikan ke halaman dengan pesan sukses
        return redirect('/dashboard/student')->with('success', 'Siswa telah diubah!');
    }

    public function destroy(Student $student)
    {
        // Menghapus user terkait
        $user = User::where('id_student', $student->id)->first();
        if ($user) {
            $user->delete();
        }

        // Menghapus siswa
        $student->delete();

        return redirect('/dashboard/student')->with('success', 'Siswa dan akun terkait telah dihapus!');
    }
}
