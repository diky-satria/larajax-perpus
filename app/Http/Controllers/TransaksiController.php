<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Pinjam;
use App\Models\Mahasiswa;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function index()
    {
        $data = Transaksi::where('status', 1)->orderBy('id', 'DESC')->get();
        if(request()->ajax()){
            return datatables()->of($data)
                                ->addColumn('nama', function($data){
                                    return $data->mahasiswa->nama;
                                })
                                ->addColumn('denda', function($data){
                                    date_default_timezone_set('Asia/Jakarta');
                                    $tgl_sekarang = date('Y-m-d');
                                    $terlambat = terlambat($tgl_sekarang, $data->tgl_pengembalian);
                                    if($terlambat > 0){  
                                        $denda = 1000;
                                        $bayar = $data->jumlah * ($terlambat * $denda);
                                        $push = format_rupiah($bayar);
                                        return '<div style="color:red;font-weight:bold;">'.$terlambat.' hari | '.$push.'</div>';
                                    }else{
                                        return '----';
                                    }
                                })
                                ->addColumn('opsi', function($data){
                                    $button = "<button class='btn btn-sm btn-info ms-1 modal-det-tran-adm' id='".$data->id."' title='Lihat' data-bs-toggle='modal' data-bs-target='#modal-detailTransaksiAdmin'><i class='fas fa-eye'></i></button>";
                                    $button .= "<button class='btn btn-sm btn-dark ms-1 kembalikan' kode='".$data->kode."' id='".$data->id."' title='Kembalikan'><i class='fas fa-arrow-left'></i></button>";

                                    date_default_timezone_set('Asia/Jakarta');
                                    $tgl_sekarang = date('Y-m-d');
                                    $terlambat = terlambat($tgl_sekarang, $data->tgl_pengembalian);

                                    if($terlambat > 0){
                                        $button .= "<button class='btn btn-sm btn-primary ms-1' title='Tidak bisa diperpanjang' disabled><i class='fas fa-arrow-right'></i></button>";
                                    }else{
                                        $button .= "<button class='btn btn-sm btn-primary ms-1 perpanjang' kode='".$data->kode."' id='".$data->id."' title='Perpanjang'><i class='fas fa-arrow-right'></i></button>";
                                    }
                                    return $button;
                                })
                                ->rawColumns(['nama','denda','opsi'])
                                ->make(true);
        }
        return view('transaksi.transaksi');
    }

    public function detail($id)
    {
        $tran = Transaksi::find($id);

        date_default_timezone_set('Asia/Jakarta');
        $tgl_sekarang = date('Y-m-d');
        $terlambat = terlambat($tgl_sekarang, $tran->tgl_pengembalian);
        $denda = 1000;
        $bayar = $tran->jumlah * ($terlambat * $denda);
        $uang_denda = format_rupiah($bayar);

        $transaksi = [
            'nim' => $tran->mahasiswa->nim,
            'nama' => $tran->mahasiswa->nama,
            'jurusan' => $tran->mahasiswa->jurusan->nama_jurusan,
            'semester' => $tran->mahasiswa->semester->nama_semester,
            'kode' => $tran->kode,
            'petugas' => $tran->petugas,
            'jumlah' => $tran->jumlah,
            'terlambat' => $terlambat,
            'uang_denda' => $uang_denda 
        ];

        $pinjam = $tran->pinjams()->get();

        $buku = [];
        foreach($pinjam as $p){
            $buku[] = [
                'kode_buku' => $p->buku->kode_buku,
                'judul' => $p->buku->judul
            ];
        }

        return response()->json([
            'transaksi' => $transaksi,
            'buku' => $buku
        ]);
    }

    public function ambilData()
    {
        $buku = Buku::where('jumlah', '>', 0)->orderBy('judul', 'ASC')->get();

        return response()->json([
            'buku' => $buku
        ]);
    }

    public function viewTambah()
    {
        $kode_random = kode_random(8);
        date_default_timezone_set('Asia/Jakarta');
        $tgl_peminjaman = date('Y-m-d');
        $tgl_pengembalian = date('Y-m-d', time()+60*60*24*8);
        $mhs = Mahasiswa::orderBy('nama', 'ASC')->get();
        return view('transaksi.viewTambah', [
            'kode_random' => $kode_random,
            'tgl_peminjaman' => $tgl_peminjaman,
            'tgl_pengembalian' => $tgl_pengembalian,
            'mhs' => $mhs
        ]);
    }

    public function tambahBuku()
    {
        $trans = Transaksi::where('kode', request('kode'))->first();

        request()->validate([
            'kode' => 'required',
            'tgl_peminjaman' => 'required',
            'tgl_pengembalian' => 'required',
            'buku_id' => 'required'
        ],[
            'kode.required' => 'Kode harus di isi',
            'tgl_peminjaman.required' => 'Tgl peminjaman harus di isi',
            'tgl_pengembalian.required' => 'Tgl pengembalian harus di isi',
            'buku_id.required' => 'Buku harus dipilih'
        ]);

        if($trans){
            $trans->pinjams()->create([
                'buku_id' => request('buku_id'),
                'qty' => 1
            ]);

            $buku = Buku::where('id', request('buku_id'))->first();
            $buku->update([
                'jumlah' => $buku->jumlah - 1
            ]);
        }else{
            Transaksi::create([
                'kode' => request('kode'),
                'tgl_peminjaman' => request('tgl_peminjaman'),
                'tgl_pengembalian' => request('tgl_pengembalian'),
                'jumlah' => 0,
                'status' => 0,
                'petugas' => Auth::user()->name
            ])->pinjams()->create([
                'buku_id' => request('buku_id'),
                'qty' => 1
            ]);

            $buku = Buku::where('id', request('buku_id'))->first();
            $buku->update([
                'jumlah' => $buku->jumlah - 1
            ]);
        }

        return response()->json([
            'message' => 'buku berhasil ditambahkan'
        ]);
    }

    public function tampilBuku($kode)
    {
        $transaksi = Transaksi::where('kode', $kode)->first();

        if($transaksi){
            $trans = $transaksi->pinjams()->get();
            $count = $transaksi->pinjams()->count();
            $data = [];
            foreach($trans as $t){
                $data[] = [
                    'id' => $t->id,
                    'kode_buku' => $t->buku->kode_buku,
                    'judul' => $t->buku->judul
                ];
            }

            return response()->json([
                'message' => 'data berhasil ditambahkan',
                'data' => $data,
                'count' => $count
            ]);
        }else{
            return response()->json([
                'message' => 'belum ada data',
                'count' => 0
            ]);
        }
    }

    public function hapusBuku($id, $kode_buku, $kode_transaksi)
    {
        $transaksi = Transaksi::where('kode', $kode_transaksi)->first();
        $transaksi->pinjams()->detach($id);
        $pinjam = Pinjam::find($id);
        $pinjam->delete();

        $buku = Buku::where('kode_buku', $kode_buku)->first();
        $buku->update([
            'jumlah' => $buku->jumlah + 1
        ]);

        return response()->json([
            'message' => 'buku berhasil dihapus'
        ]);
    }
 
    public function updateTransaksi($kode)
    {
        request()->validate([
            'mahasiswa_id' => 'required'
        ],[
            'mahasiswa_id.required' => 'Mahasiswa harus dipilih'
        ]);

        $transaksi = Transaksi::where('kode', $kode)->first();
        $transaksi->update([
            'mahasiswa_id' => request('mahasiswa_id'),
            'status' => 1,
            'jumlah' => request('count')
        ]);

        return response()->json([
            'message' => 'lanjutkan transaksi berhasil'
        ]);
    }

    public function kembalikan($id)
    {
        $transaksi = Transaksi::find($id);

        $trans = $transaksi->pinjams()->get();

        foreach($trans as $t){
            $buku = Buku::where('id', $t->buku_id)->first();
            $buku->update([
                'jumlah' => $buku->jumlah + 1
            ]);
        }

        $transaksi->update([
            'status' => 2
        ]);

        return response()->json([
            'message' => 'buku berhasil dikemblikan'
        ]);
    }

    public function perpanjang($id)
    {
        $transaksi = Transaksi::find($id);

        date_default_timezone_set('Asia/Jakarta');
        $tgl_peminjaman = date('Y-m-d');
        $tgl_pengembalian = date('Y-m-d', time()+60*60*24*8);

        $transaksi->update([
            'tgl_peminjaman' => $tgl_peminjaman,
            'tgl_pengembalian' => $tgl_pengembalian
        ]);

        return response()->json([
            'message' => 'transaksi berhasil diperpanjang'
        ]);
    }
}
