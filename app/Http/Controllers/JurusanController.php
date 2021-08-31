<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index()
    {
        return view('jurusan.jurusan');
    }

    public function ambilData()
    {
        $jurusans = Jurusan::orderBy('id', 'DESC')->get();

        return response()->json([
            'jurusans' => $jurusans
        ]);
    }

    public function tambah()
    {
        request()->validate([
            'nama_jurusan' => 'required|unique:jurusans,nama_jurusan'
        ],[
            'nama_jurusan.required' => 'Nama jurusan harus di isi',
            'nama_jurusan.unique' => 'Jurusan ini sudah ada'
        ]);

        Jurusan::create([
            'nama_jurusan' => ucwords(request('nama_jurusan'))
        ]);

        return response()->json([
            'message' => 'jurusan berhasil ditambahkan'
        ]);
    }

    public function hapus($id){
        $jurusan = Jurusan::find($id);
        $jurusan->delete();

        return response()->json([
            'message' => 'jurusan berhasil dihapus'
        ]);
    }
}
