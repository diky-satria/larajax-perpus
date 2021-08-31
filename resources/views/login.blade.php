@extends('templates/template1')

@section('konten')
<div class="row login">
   <div class="col-md-7 kiri">
      <img src="{{ asset('assets/img/login.png') }}">
   </div>
   <div class="col-md-5 kanan">
      <div class="home-background">
         <img src="{{ asset('assets/img/login.png') }}">
         <div class="card-login">
            <h4>Login</h4>
            <form action="{{ url('login/store') }}" method="post">
               @csrf
               @if($gagal = session()->get('message'))
               <div class="alert alert-edited mt-4 alert-danger">
                  {{ $gagal }}
               </div>
               @endif
               @if($logout = session()->get('logout'))
               <div class="alert alert-edited mt-4 alert-success">
                  {{ $logout }}
               </div>
               @endif
               <div class="form-group">
                  <input type="text" name="email" class="form-control field-login" placeholder="Email..">
                  @error("email")
                  <div class="form-text text-danger">
                        {{ $message }}
                  </div>
                  @enderror
               </div>
               <div class="form-group">
                  <input type="password" name="password" class="form-control field-login" placeholder="Password">
                  @error("password")
                  <div class="form-text text-danger">
                        {{ $message }}
                  </div>
                  @enderror
               </div>
               <div class="d-grid">
                  <button type="submit" class="btn btn-sm btn-primary btn-login-grid field-login">Login</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
@endsection