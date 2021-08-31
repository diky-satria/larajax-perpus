<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function index()
    {
        return view('superadmin.superadmin');
    }

    public function ambilData()
    {
        $admin = User::where('role', 'admin')->orderBy('id', 'DESC')->get();

        return response()->json([
            'message' => 'data admin',
            'admin' => $admin
        ]);
    }

    public function detail($id)
    {
        $adminDetail = User::find($id);

        return response()->json([
            'message' => 'detail data admin',
            'adminDetail' => $adminDetail
        ]);
    }

    public function tambah()
    {
        request()->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'konfirmasi_password' => 'required|same:password'
        ],[
            'nama.required' => 'Nama harus di isi',
            'email.required' => 'Email harus di isi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus di isi',
            'password.min' => 'Password minimal 6 karakter',
            'konfirmasi_password.required' => 'Konfirmasi password harus di isi',
            'konfirmasi_password.same' => 'Konfirmasi password salah'
        ]);

        User::create([
            'name' => ucwords(request('nama')),
            'email' => request('email'),
            'password' => bcrypt(request('konfirmasi_password')),
            'role' => 'admin'
        ]);

        return response()->json([
            'message' => 'tambah admin berhasil'
        ]);
    }

    public function edit($id)
    {
        request()->validate([
            'nama_edit' => 'required'
        ],[
            'nama_edit.required' => 'Nama harus di isi'
        ]);

        $admin = User::find($id);
        $admin->update([
            'name' => ucwords(request('nama_edit'))
        ]);

        return response()->json([
            'message' => 'admin berhasil diedit'
        ]);
    }

    public function hapus($id)
    {
        $admin = User::find($id);
        $admin->delete();

        return response()->json([
            'message' => 'admin berhasil dihapus'
        ]);
    }
}
