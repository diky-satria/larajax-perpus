<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Pinjam;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class CollapseController extends Controller
{
    public function index()
    {
        return view('collapse.collapse');
    }

    public function ambilData()
    {
        $data = Transaksi::where('status', 0)->orderBy('id', 'DESC')->get();
        $transaksi = [];

        foreach($data as $d){
            $transaksi[] = [
                'id' => $d->id,
                'kode_transaksi' => $d->kode,
                'petugas' => $d->petugas,
                'jumlah' => $d->pinjams()->count()
            ];
        }

        return response()->json([
            'message' => 'data transaksi collapse',
            'transaksi' => $transaksi
        ]);
    }

    public function detail($id)
    {
        $transaksi = Transaksi::find($id);
        $data = $transaksi->pinjams()->get();
        $buku = [];
        foreach($data as $d){
            $buku[] = [
                'id' => $d->id,
                'buku_id' => $d->buku_id,
                'kode_buku' => $d->buku->kode_buku,
                'judul' => $d->buku->judul,
                'lokasi' => $d->buku->lokasi->nama_lokasi
            ];
        }

        return response()->json([
            'transaksi' => $transaksi,
            'buku' => $buku
        ]);
    }

    public function kembalikan($id)
    {
        $transaksi = Transaksi::find($id);
        $data = $transaksi->pinjams()->get();
        foreach($data as $d){
            // update jumlah buku
            $buku = Buku::where('id', $d->buku_id)->first();
            $buku->update([
                'jumlah' => $buku->jumlah + 1
            ]);

            // hapus data di table pinjam
            $pinjam = Pinjam::where('id', $d->id)->first();
            $pinjam->delete();

            // hapus data di table pinjam transaksi
            $transaksi->pinjams()->detach($d->id);
        }

        // hapus transaksi di table transaksi
        $transaksi->delete();

        return response()->json([
            'message' => 'buku telah dikembalikan'
        ]);
    }
}
