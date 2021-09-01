<?php

namespace App\Http\Controllers;

use datatables;
use App\Models\Buku;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $lokasi = Lokasi::orderBy('id', 'ASC')->get();
        $buku = Buku::orderBy('id', 'DESC')->get();

        if(request()->ajax()){
            return datatables()->of($buku)
                                ->addColumn('opsi', function($buku){
                                    $button = "<button class='btn btn-sm btn-info ms-1 lihat-buk' id='".$buku->id."' title='Lihat' data-bs-toggle='modal' data-bs-target='#modal-buk-det'><i class='fas fa-eye'></i></button>";
                                    $button .= "<button class='btn btn-sm btn-success ms-1 edit-buk' id='".$buku->id."' title='Edit' data-bs-toggle='modal' data-bs-target='#modal-buk-edi'><i class='fas fa-edit'></i></button>";
                                    $button .= "<button class='btn btn-sm btn-danger ms-1 hapus-buk' id='".$buku->id."' title='Hapus'><i class='fas fa-trash-alt'></i></button>";
                                    return $button;
                                })
                                ->addColumn('gambar', function($data){
                                    $gambar = asset('assets/gambar/'. $data->gambar);
                                    return "<img src='".$gambar."' width='80' height='50' style='border-radius:8px;'>";
                                })
                                ->rawColumns(['gambar','opsi'])
                                ->make(true);
        }
        return view('buku.buku', ['lokasi' => $lokasi]);
    }

    public function detail($id)
    {
        $data = Buku::find($id);
        $buku = [
            'id' => $data->id,
            'kode_buku' => $data->kode_buku,
            'judul' => $data->judul,
            'pengarang' => $data->pengarang,
            'penerbit' => $data->penerbit,
            'tahun' => $data->tahun,
            'isbn' => $data->isbn,
            'jumlah' => $data->jumlah,
            'lokasi_id' => $data->lokasi_id,
            'lokasi' => $data->lokasi->nama_lokasi,
            'gambar' => $data->gambar
        ];

        return response()->json([
            'buku' => $buku
        ]);
    }

    public function tambah()
    {
        request()->validate([
            'kode_buku' => 'required|unique:bukus,kode_buku',
            'judul' => 'required',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'tahun' => 'required|numeric|digits_between:1,4',
            'isbn' => 'required',
            'jumlah' => 'required|numeric|digits_between:1,9',
            'lokasi_id' => 'required',
            'gambar' => 'required|mimes:jpg,png,jpeg,gif|max:2048'
        ],[
            'kode_buku.required' => 'Kode buku harus di isi',
            'kode_buku.unique' => 'Kode buku sudah terdaftar',
            'judul.required' => 'Judul harus di isi',
            'pengarang.required' => 'Pengarang harus di isi',
            'penerbit.required' => 'Penerbit harus di isi',
            'tahun.required' => 'Tahun harus di isi',
            'tahun.numeric' => 'Format harus angka',
            'tahun.digits_between' => 'Max 4 digit',
            'isbn.required' => 'ISBN harus di isi',
            'jumlah.required' => 'Jumlah harus di isi',
            'jumlah.numeric' => 'Format harus angka',
            'jumlah.digits_between' => 'Max 9 digit',
            'lokasi_id.required' => 'Lokasi harus dipilih',
            'gambar.required' => 'Gambar harus di isi',
            'gambar.mimes' => 'Format file harus jpg/jpeg/png/gif',
            'gambar.max' => 'Ukuran gambar maximal 2 MB'
        ]);

        // upload gambar
        $gambar = request()->file('gambar');
        $extension = $gambar->getClientOriginalExtension();
        $upload = time() .'.'. $extension;
        $gambar->move(public_path('assets/gambar/'), $upload);

        Buku::create([
            'kode_buku' => strtoupper(request('kode_buku')),
            'judul' => ucwords(request('judul')),
            'pengarang' => ucwords(request('pengarang')),
            'penerbit' => ucwords(request('penerbit')),
            'tahun' => request('tahun'),
            'isbn' => ucwords(request('isbn')),
            'jumlah' => request('jumlah'),
            'lokasi_id' => request('lokasi_id'),
            'gambar' => $upload
        ]);

        return response()->json([
            'message' => 'buku berhasil ditambahkan'
        ]);
    }

    public function edit($id)
    {
        $buku = Buku::find($id);

        request()->validate([
            'judulEdit' => 'required',
            'pengarangEdit' => 'required',
            'penerbitEdit' => 'required',
            'tahunEdit' => 'required|numeric|digits_between:1,4',
            'isbnEdit' => 'required',
            'jumlahEdit' => 'required|numeric|digits_between:1,9'
        ],[
            'judulEdit.required' => 'Judul harus di isi',
            'pengarangEdit.required' => 'Pengarang harus di isi',
            'penerbitEdit.required' => 'Penerbit harus di isi',
            'tahunEdit.required' => 'Tahun harus di isi',
            'tahunEdit.numeric' => 'Format harus angka',
            'tahunEdit.digits_between' => 'Max 4 digit',
            'isbnEdit.required' => 'ISBN harus di isi',
            'jumlahEdit.required' => 'Jumlah harus di isi',
            'jumlahEdit.numeric' => 'Format harus angka',
            'jumlahEdit.digits_between' => 'Max 9 digit'
        ]);

        $gambar = request()->file('gambarEdit');
        if($gambar){
            $gambar_lama = $buku->gambar;
            if($gambar_lama){
                unlink('assets/gambar/'. $gambar_lama);
            }
            $extension = $gambar->getClientOriginalExtension();
            $upload = time() .'.'. $extension;
            $gambar->move(public_path('assets/gambar/'), $upload);

            $buku->update([
                'judul' => ucwords(request('judulEdit')),
                'pengarang' => ucwords(request('pengarangEdit')),
                'penerbit' => ucwords(request('penerbitEdit')),
                'tahun' => request('tahunEdit'),
                'isbn' => ucwords(request('isbnEdit')),
                'jumlah' => request('jumlahEdit'),
                'lokasi_id' => request('lokasi_idEdit'),
                'gambar' => $upload
            ]);
        }else{
            $buku->update([
                'judul' => ucwords(request('judulEdit')),
                'pengarang' => ucwords(request('pengarangEdit')),
                'penerbit' => ucwords(request('penerbitEdit')),
                'tahun' => request('tahunEdit'),
                'isbn' => ucwords(request('isbnEdit')),
                'jumlah' => request('jumlahEdit'),
                'lokasi_id' => request('lokasi_idEdit')
            ]);
        }

        return response()->json([
            'message' => 'buku berhasil diedit'
        ]);
    }

    public function hapus($id)
    {
        $buku = Buku::find($id);
        
        $gambar_lama = $buku->gambar;
        if($gambar_lama){
            unlink('assets/gambar/'.$gambar_lama);
        }

        $buku->delete();

        return response()->json([
            'message' => 'buku berhasil dihapus'
        ]);
    }
}
