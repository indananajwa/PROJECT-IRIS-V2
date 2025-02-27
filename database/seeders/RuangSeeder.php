<?php

namespace Database\Seeders;

use App\Models\Ruang;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RuangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $ruang = [
            ['noruang' => 'E101', 'blokgedung' => 'E', 'lantai' => '1', 'fungsi' => 'Ruang Kelas', 'kapasitas' => '50', 'status' => 'Disetujui', 'prodi' => 'Informatika'],
            ['noruang' => 'E102', 'blokgedung' => 'E', 'lantai' => '1', 'fungsi' => 'Ruang Kelas', 'kapasitas' => '50', 'status' => 'Disetujui', 'prodi' => 'Informatika'],
            ['noruang' => 'E103', 'blokgedung' => 'E', 'lantai' => '1', 'fungsi' => 'Ruang Kelas', 'kapasitas' => '50', 'status' => 'Disetujui', 'prodi' => 'Informatika'],
            ['noruang' => 'A101', 'blokgedung' => 'A', 'lantai' => '1', 'fungsi' => 'Ruang Kelas', 'kapasitas' => '50', 'status' => 'Disetujui', 'prodi' => 'Informatika'],
            ['noruang' => 'A102', 'blokgedung' => 'A', 'lantai' => '1', 'fungsi' => 'Ruang Kelas', 'kapasitas' => '50', 'status' => 'Disetujui', 'prodi' => 'Informatika'],
            ['noruang' => 'A103', 'blokgedung' => 'A', 'lantai' => '1', 'fungsi' => 'Ruang Kelas', 'kapasitas' => '50', 'status' => 'Disetujui', 'prodi' => 'Informatika'],
            ['noruang' => 'A104', 'blokgedung' => 'A', 'lantai' => '1', 'fungsi' => 'Ruang Kelas', 'kapasitas' => '50', 'status' => 'Disetujui', 'prodi' => 'Biologi'],
            ['noruang' => 'B101', 'blokgedung' => 'B', 'lantai' => '1', 'fungsi' => 'Ruang Kelas', 'kapasitas' => '50', 'status' => 'Disetujui', 'prodi' => 'Biologi'],
            ['noruang' => 'B102', 'blokgedung' => 'B', 'lantai' => '1', 'fungsi' => 'Ruang Kelas', 'kapasitas' => '50', 'status' => 'Disetujui', 'prodi' => 'Fisika'],
            ['noruang' => 'B103', 'blokgedung' => 'B', 'lantai' => '1', 'fungsi' => 'Ruang Kelas', 'kapasitas' => '50', 'status' => 'Disetujui', 'prodi' => 'Fisika'],
            ['noruang' => 'B104', 'blokgedung' => 'B', 'lantai' => '1', 'fungsi' => 'Ruang Kelas', 'kapasitas' => '50', 'status' => 'Disetujui', 'prodi' => 'Informatika'],
            ['noruang' => 'K101', 'blokgedung' => 'K', 'lantai' => '1', 'fungsi' => 'Ruang Kelas', 'kapasitas' => '50', 'status' => 'Disetujui', 'prodi' => 'Informatika'],
            ['noruang' => 'K102', 'blokgedung' => 'K', 'lantai' => '1', 'fungsi' => 'Ruang Kelas', 'kapasitas' => '50', 'status' => 'Disetujui', 'prodi' => 'Statistika'],
            ['noruang' => 'K201', 'blokgedung' => 'K', 'lantai' => '2', 'fungsi' => 'Ruang Kelas', 'kapasitas' => '50', 'status' => 'Disetujui', 'prodi' => 'Fisika'],
            ['noruang' => 'K202', 'blokgedung' => 'K', 'lantai' => '2', 'fungsi' => 'Ruang Kelas', 'kapasitas' => '50', 'status' => 'Disetujui', 'prodi' => 'Informatika'],
            ['noruang' => 'C101', 'blokgedung' => 'C', 'lantai' => '1', 'fungsi' => 'Ruang Kelas', 'kapasitas' => '50', 'status' => 'Disetujui', 'prodi' => 'Fisika'],
            ['noruang' => 'C102', 'blokgedung' => 'C', 'lantai' => '1', 'fungsi' => 'Ruang Kelas', 'kapasitas' => '50', 'status' => 'Disetujui', 'prodi' => 'Statistika'],
            ['noruang' => 'C103', 'blokgedung' => 'C', 'lantai' => '1', 'fungsi' => 'Ruang Kelas', 'kapasitas' => '50', 'status' => 'Disetujui', 'prodi' => 'Statistika'],
            ['noruang' => 'C014', 'blokgedung' => 'C', 'lantai' => '1', 'fungsi' => 'Ruang Kelas', 'kapasitas' => '50', 'status' => 'Disetujui', 'prodi' => 'Informatika']
        ];

        foreach ($ruang as $p) {
            Ruang::create($p);
        }
        
    }
}