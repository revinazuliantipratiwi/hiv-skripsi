<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hiv extends Model
{
    // Secara default, Laravel sudah menggunakan table 'hivs'
    // Jika kamu ingin menuliskannya secara eksplisit, boleh ditambahkan:
    protected $table = 'hivs';

    // Kolom yang boleh diisi secara mass-assignment
    protected $fillable = [
        'kecamatan',
        'total_kasus',
        'tahun',
    ];

}
