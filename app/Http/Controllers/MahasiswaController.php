<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    public function index()
    {
        return view('mahasiswa.mahasiswa');
    }

    public function ambilData()
    {
        $mahasiswa = Mahasiswa::where('email', Auth::user()->email)->first();
        $transaksi = $mahasiswa->transaksis()->orderBy('status', 'ASC')->get();

        date_default_timezone_set('Asia/Jakarta');
        $trans_hari_ini = $mahasiswa->transaksis()->where('tgl_peminjaman', now()->format('Y-m-d'))->count();
        $trans_di_pinjam = $mahasiswa->transaksis()->where('status', 1)->count();
        $tot_buk_pinj = $mahasiswa->transaksis()->where('status', 1)->sum('jumlah');

        return response()->json([
            'transaksi' => $transaksi,
            'trans_hari_ini' => $trans_hari_ini,
            'trans_di_pinjam' => $trans_di_pinjam,
            'tot_buk_pinj' => $tot_buk_pinj
        ]);
    }

    public function detail($id)
    {
        $trans = Transaksi::find($id);

        if($trans->mahasiswa->email !== Auth::user()->email){
            abort(403, 'Forbidden');
        }

        date_default_timezone_set('Asia/Jakarta');
        $tgl_sekarang = date('Y-m-d');
        $terlambat = terlambat($tgl_sekarang, $trans->tgl_pengembalian);
        $denda = 1000;
        $bayar = $trans->jumlah * ($terlambat * $denda);
        $uang_denda = format_rupiah($bayar);

        $detail = [
            'id' => $trans->id,
            'kode' => $trans->kode,
            'petugas' => $trans->petugas,
            'jumlah' => $trans->jumlah,
            'denda' => $uang_denda,
            'terlambat' => $terlambat
        ];

        $pinjam = $trans->pinjams()->get();
        $buku = [];

        foreach($pinjam as $p){
            $buku[] = [
                'kode_buku' => $p->buku->kode_buku,
                'judul' => $p->buku->judul
            ];
        }

        return response()->json([
            'detail' => $detail,
            'buku' => $buku
        ]);
    }
}
