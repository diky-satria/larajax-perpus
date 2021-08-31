<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $fillable = ['nim','nama','email','jurusan_id','semester_id','kelas_id'];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}
