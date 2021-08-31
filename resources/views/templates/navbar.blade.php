<!-- navbar -->
@if(Auth::user())
<nav class="navbar navbar-expand-lg navbar-light fixed-top navbar-border-bottom">
@else
<nav class="navbar navbar-expand-lg navbar-light fixed-top navbar-border-bottom-hapus">
@endif
   <div class="container">
   <a class="navbar-brand" href="{{ url('/') }}">E-PUSTAKA</a>
   <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
   </button>
   <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      @if(Auth::user())
         <div class="navbar-nav me-auto">
               @if(Auth::user()->role == 'super admin' || Auth::user()->role == 'admin')
               <a class="nav-link {{ Request::is('dashboard') ? 'btn btn-sm btn-primary btn-navbar-edited' : '' }} text-center btn-dash" href="{{ url('dashboard') }}">Dashboard</a>
               @if(Auth::user()->role == 'super admin')
               <a class="nav-link {{ Request::is('super-admin') ? 'btn btn-sm btn-primary btn-navbar-edited' : '' }} text-center" href="{{ url('super-admin') }}">S-admin</a>
               @endif
               <a class="nav-link {{ Request::is('transaksi') ? 'btn btn-sm btn-primary btn-navbar-edited' : '' }} text-center" href="{{ url('transaksi') }}">Transaksi</a>
               @endif
               @if(Auth::user()->role == 'mahasiswa')
               <a class="nav-link {{ Request::is('mahasiswa') ? 'btn btn-sm btn-primary btn-navbar-edited' : '' }} text-center btn-maha" href="{{ url('mahasiswa') }}">Mahasiswa</a>
               @endif
         </div>
         <div class="nav-item dropdown">
               <a class="nav-link dropdown-toggle text-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color:gray;">
                  Hi, {{ Auth::user()->name }}
               </a>
               <ul class="dropdown-menu text-center" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="{{ url('profil-dan-password') }}">Profil & Password</a></li>
                  <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-logout" href="#">Logout</a></li>
               </ul>
         </div>
      @endif
      @if(!Auth::user())
      <div class="navbar-nav ms-auto">
         <a class="nav-link {{ Request::is('login') ? 'btn btn-sm btn-primary btn-navbar-edited' : '' }} text-center btn-log" href="{{ url('login') }}">Login</a>
      </div>
      @endif
   </div>
   </div>
</nav>
<!-- akhir navbar -->

<!-- modal logout -->
<div class="modal fade" id="modal-logout" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-logoutLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-logoutLabel">Logout</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Kembali</button>
        <a href="{{ url('logout') }}" class="btn btn-sm btn-primary">Logout</a>
      </div>
    </div>
  </div>
</div>
<!-- akhir modal logout -->