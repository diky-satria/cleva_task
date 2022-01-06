<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $fillable = ['id_jabatan','nip','nama_karyawan','jenis_kelamin','telepon','cv'];

    public function jabatan()
    {
        return $this->belongsTo('App\Models\Jabatan', 'id_jabatan', 'id');
    }
}
