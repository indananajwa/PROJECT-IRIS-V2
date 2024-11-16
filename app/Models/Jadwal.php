<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';
    protected $fillable = [
        'hari',
        'jammulai',
        'jamselesai',
        'ruang',
        'kodemk',
        'kelas',
        'kapasitas',
        'prodi',
        'status'
    ];

    public function mahasiswa(){
        return $this->belongsTo(Mahasiswa::class);
    }
}
