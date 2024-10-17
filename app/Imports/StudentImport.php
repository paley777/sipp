<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Buat instance Student baru dengan data dari Excel
        $student = new Student([
            'nama' => $row[0],
            'kelas' => $row[1],
            'jenis_kelamin' => $row[2],
        ]);
        $student->save();

        // Buat email unik untuk siswa
        $cleanName = Str::slug($student->nama, '');
        $baseEmail = $student->id . '_' . $cleanName;
        $email = $baseEmail . '@gmail.com';
        $counter = 1;

        // Cek keunikan email dan tambahkan angka jika diperlukan
        while (User::where('email', $email)->exists()) {
            $email = $baseEmail . $counter . '@gmail.com';
            $counter++;
        }

        // Buat user yang terkait dengan siswa
        User::create([
            'nama' => $student->nama,
            'nip' => '-',
            'jabatan' => '-',
            'email' => $email,
            'password' => Hash::make('12345678'),
            'role' => 'Siswa',
            'id_student' => $student->id,
        ]);

        return $student;
    }
}
