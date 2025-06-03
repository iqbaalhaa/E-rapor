<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin Sekolah',
                'email' => 'admin@sekolah.test',
                'password' => Hash::make('admin'),
                'role' => 'admin',
                'linked_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Guru Bahasa',
                'email' => 'guru@sekolah.test',
                'password' => Hash::make('guru'),
                'role' => 'guru',
                'linked_id' => null, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Wali Kelas X IPA 1',
                'email' => 'walikelas@sekolah.test',
                'password' => Hash::make('walikelas'),
                'role' => 'walikelas',
                'linked_id' => null, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
