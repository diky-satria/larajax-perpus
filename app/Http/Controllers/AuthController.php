<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function store()
    {
        request()->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ],[
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password min 6 karakter'
        ]);

        if(Auth::attempt(['email' => request('email'), 'password' =>request('password')])){
            if(Auth::user()->role == 'super admin' || Auth::user()->role == 'admin'){
                return redirect('/dashboard');
            }elseif(Auth::user()->role == 'mahasiswa'){
                return redirect('mahasiswa');
            }else{
                return redirect('login');
            }
        }

        return redirect('login')->with('message', 'Email dan Password tidak sesuai');
    }

    public function logout()
    {
        Auth::logout();

        return redirect('login')->with('logout', 'Anda telah keluar');
    }
}
