<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\User::create([
            'nama' => 'Valleryan Virgil Zuliuskandar',
            'nip' => 'G1A020021',
            'jabatan' => 'Guru',
            'email' => 'admin@gmail.com',
            'role' => 'Administrator',
            'password' => Hash::make('admin'),
        ]);
    }
}
