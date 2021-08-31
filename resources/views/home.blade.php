@extends('templates/template1')

@section('konten')
<div class="row home">
   <div class="col-lg kiri">
      <img src="{{ asset('assets/img/home.png') }}">
      <h2 class="selamat">Selamat datang di web <br> perpustakaan <b style="font-weight:bold;">UNUSIA</b></h2>
      <p>Membantu anda melakukan peminjaman dan <br> pengembalian buku dengan mudah dan aman</p>
      <a href="{{ url('login') }}" class="tombol-login">Login</a>
   </div>
   <div class="col-lg kanan">
      <div class="home-background">
         <img src="{{ asset('assets/img/home.png') }}">
      </div>
   </div>
</div>
@endsection