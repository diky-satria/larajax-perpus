<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $fillable = ['kode_buku','judul','pengarang','penerbit','tahun','jumlah','isbn','lokasi_id','gambar'];

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }
}
