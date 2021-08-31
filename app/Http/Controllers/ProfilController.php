<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::where('email', Auth::user()->email)->first();
        return view('profil.profil', [
            'mahasiswa' => $mahasiswa
        ]);
    }

    public function ubahPassword()
    {
        request()->validate([
            'password' => 'required|min:6',
            'konfirmasi_password' => 'required|same:password'
        ],[
            'password.required' => 'Password harus di isi',
            'password.min' => 'Password minimal 6 karakter',
            'konfirmasi_password.required' => 'Konfirmasi password harus di isi',
            'konfirmasi_password.same' => 'Konfirmasi password salah'
        ]);

        $user = User::find(Auth::user()->id);

        $user->update([
            'password' => bcrypt(request('konfirmasi_password'))
        ]);

        return response()->json([
            'message' => 'password berhasil diubah'
        ]);
    }
}
