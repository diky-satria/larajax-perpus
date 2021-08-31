<?php

namespace App\Http\Controllers;

use datatables;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\Semester;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaAdminController extends Controller
{
    public function index()
    {
        $jurusan = Jurusan::orderBy('nama_jurusan', 'ASC')->get();
        $semester = Semester::orderBy('id', 'ASC')->get();
        $kelas = Kelas::orderBy('id', 'ASC')->get();

        $mahasiswa = Mahasiswa::orderBy('id', 'DESC')->get();
        if(request()->ajax()){
            return datatables()->of($mahasiswa)
                                ->addColumn('jurusan', function($mahasiswa){
                                    return $mahasiswa->jurusan->nama_jurusan;
                                })
                                ->addColumn('opsi', function($mahasiswa){
                                    $button = "<button class='btn btn-sm btn-info ms-1 lihat-mah-adm' id='".$mahasiswa->id."' title='Lihat' data-bs-toggle='modal' data-bs-target='#modal-detailMahasiswaAdmin'><i class='fas fa-eye'></i></button>";
                                    $button .= "<button class='btn btn-sm btn-success ms-1 edit-mah-adm' id='".$mahasiswa->id."' title='Edit' data-bs-toggle='modal' data-bs-target='#modal-editMahasiswaAdmin'><i class='fas fa-edit'></i></button>";
                                    $button .= "<button class='btn btn-sm btn-danger ms-1 hapus-mah-adm' id='".$mahasiswa->id."' title='Hapus'><i class='fas fa-trash-alt'></i></button>";
                                    return $button;
                                })
                                ->rawColumns(['jurusan','opsi'])
                                ->make(true);
        }

        return view('mahasiswaadmin.mahasiswaadmin', ['jurusan' => $jurusan, 'semester' => $semester, 'kelas' => $kelas]);
    }

    public function detail($id)
    {
        $mahasiswa = Mahasiswa::find($id);
        $data[] = [
            'id' => $mahasiswa->id,
            'nim' => $mahasiswa->nim,
            'nama' => $mahasiswa->nama,
            'email' => $mahasiswa->email,
            'jurusan_id' => $mahasiswa->jurusan_id,
            'semester_id' => $mahasiswa->semester_id,
            'kelas_id' => $mahasiswa->kelas_id,
            'jurusan' => $mahasiswa->jurusan->nama_jurusan,
            'semester' => $mahasiswa->semester->nama_semester,
            'kelas' => $mahasiswa->kelas->nama_kelas
        ];

        return response()->json([
            'data' => $data
        ]);
    }

    public function tambah()
    {
        request()->validate([
            'nim' => 'required|unique:mahasiswas,nim',
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'jurusan' => 'required',
            'semester' => 'required',
            'kelas' => 'required'
        ],[
            'nim.required' => 'NIM harus di isi',
            'nim.unique' => 'NIM sudah terdaftar',
            'nama.required' => 'Nama harus di isi', 
            'email.required' => 'Email harus di isi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'jurusan.required' => 'Jurusan harus dipilih',
            'semester.required' => 'Semester harus dipilih',
            'kelas.required' => 'Kelas harus dipilih'
        ]);

        Mahasiswa::create([
            'nim' => strtoupper(request('nim')),
            'nama' => ucwords(request('nama')),
            'email' => request('email'),
            'jurusan_id' => request('jurusan'),
            'semester_id' => request('semester'),
            'kelas_id' => request('kelas')
        ]);

        User::create([
            'name' => ucwords(request('nama')),
            'email' => request('email'),
            'password' => bcrypt('password'),
            'role' => 'mahasiswa'
        ]);

        return response()->json([
            'message' => 'mahasiswa berhasil ditambahkan'
        ]);
    }

    public function edit($id)
    {
        $mahasiswa = Mahasiswa::find($id);
        $user = User::where('email', $mahasiswa->email)->first();

        request()->validate([
            'namaEdit' => 'required'
        ],[
            'namaEdit.required' => 'Nama harus di isi'
        ]);

        $user->update([
            'name' => request()->input('namaEdit')
        ]);

        $mahasiswa->update([
            'nama' => request()->input('namaEdit'),
            'jurusan_id' => request()->input('jurusanEdit'),
            'semester_id' => request()->input('semesterEdit'),
            'kelas_id' => request()->input('kelasEdit')
        ]);

        return response()->json([
            'message' => 'mahasiswa berhasil diedit'
        ]);
    }

    public function hapus($id)
    {
        $mahasiswa = Mahasiswa::find($id);
        $user = User::where('email', $mahasiswa->email)->first();
        $user->delete();
        $mahasiswa->delete();

        return response()->json([
            'message' => 'mahasiswa berhasil dihapus'
        ]);
    }
}
