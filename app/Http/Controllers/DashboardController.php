<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Jurusan;
use App\Models\Mahasiswa;
use App\Models\Transaksi;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard/dashboard');
    }

    public function ambilData()
    {
        $mahasiswa = Mahasiswa::all()->count();
        $buku = Buku::all()->count();
        $jurusan = Jurusan::all()->count();
        $collapse = Transaksi::where('status', 0)->count();

        $lineChart = DB::SELECT("SELECT tgl_peminjaman, SUM(jumlah) jumlah FROM transaksis 
                                GROUP BY tgl_peminjaman ORDER BY tgl_peminjaman DESC LIMIT 15");
        $tgl = []; 
        $jumlah = [];
        foreach($lineChart as $lc){
            $tgl[] = $lc->tgl_peminjaman;
            $jumlah[] = $lc->jumlah;
        };

        $chartDoughnut = DB::SELECT("SELECT bukus.judul, SUM(pinjams.qty) AS jumlahPinjam
                                FROM pinjams LEFT JOIN bukus ON pinjams.buku_id=bukus.id
                                GROUP BY judul ORDER BY jumlahPinjam DESC LIMIT 5");

        $judul = [];
        $qty = [];
        foreach($chartDoughnut as $cd){
            $judul[] = $cd->judul;
        }

        return response()->json([
            'mahasiswa' => $mahasiswa,
            'buku' => $buku,
            'jurusan' => $jurusan,
            'collapse' => $collapse,
            'tgl' => array_reverse($tgl),
            'jumlah' => array_reverse($jumlah),
            'chartDoughnut' => $chartDoughnut,
            'judul' => $judul
        ]);
    }
}
