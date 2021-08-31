@extends('templates/template1')

@section('konten')
<div class="row">
   <div class="col-md-8 mt-4">
      <div class="d-flex justify-content-between">
         <div>
            <h6 class="judul-card">Profil Kamu</h6>
         </div>
      </div>
      <div class="card card-edited">
         <div class="card-body">
            <table class="table table-sm">
               <tr>
                  <th>Nama</th>
                  <td>:</td>
                  <td>{{ Auth::user()->name }}</td>
               </tr>
               <tr>
                  <th>Email</th>
                  <td>:</td>
                  <td>{{ Auth::user()->email }}</td>
               </tr>
               @if(Auth::user()->role === 'super admin' || Auth::user()->role === 'admin')
               <tr>
                  <th>Hak Akses</th>
                  <td>:</td>
                  <td>{{ Auth::user()->role }}</td>
               </tr>
               @else
               <tr>
                  <th>Jurusan</th>
                  <td>:</td>
                  <td>{{ $mahasiswa->jurusan->nama_jurusan }}</td>
               </tr>
               <tr>
                  <th>Semester</th>
                  <td>:</td>
                  <td>{{ $mahasiswa->semester->nama_semester }}</td>
               </tr>
               <tr>
                  <th>Kelas</th>
                  <td>:</td>
                  <td>{{ $mahasiswa->kelas->nama_kelas }}</td>
               </tr>
               @endif
            </table>
         </div>
      </div>
   </div>
   <div class="col-md-4 mt-4">
   <div class="d-flex justify-content-between">
         <div>
            <h6 class="judul-card">Ubah Password</h6>
         </div>
      </div>
      <div class="card card-edited">
         <div class="card-body">
            <form action="" id="form-ubah-password">
               <div class="form-group">
                  <label>Password</label>
                  <input type="password" name="password" id="password" class="form-control">
               </div>
               <div class="form-group mt-2">
                  <label>Konfirmasi Password</label>
                  <input type="password" name="konfirmasi_password" id="konfirmasi_password" class="form-control">
               </div>
               <button type="submit" class="btn btn-sm btn-primary float-end mt-3 d-flex" id="btn-uba-pass">
                  <div>Ubah</div>
                  <svg id="loading" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: rgba(255, 255, 255, 0); display: none; shape-rendering: auto;" width="24px" height="24px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                  <g>
                     <path d="M50 15A35 35 0 1 0 74.74873734152916 25.251262658470843" fill="none" stroke="#ffffff" stroke-width="12"></path>
                     <path d="M49 3L49 27L61 15L49 3" fill="#ffffff"></path>
                     <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
                  </g>
                  </svg>
               </button>
            </form>
         </div>
      </div>
   </div>
</div>
@endsection

@push('js')
<script>
   $(document).ready(function(){
      // ajax toke setup
      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      })

      // ubah password
      $(document).on('submit', '#form-ubah-password', function(e){
         e.preventDefault()

         let btn = document.getElementById('btn-uba-pass')
         btn.setAttribute('disabled', true)
         let loading = document.getElementById('loading')
         loading.style.display = 'block'
         let form = $('#form-ubah-password')
         form.find('.form-text').remove()

         let formData = new FormData($('#form-ubah-password')[0])

         $.ajax({
            type: 'POST',
            url: 'ubah-password',
            data: formData,
            contentType: false,
            processData: false,
            success: function(){
               $('#password').val('')
               $('#konfirmasi_password').val('')
               Swal.fire(
                  'Berhasil',
                  'Password berhasil diubah',
                  'success'
               )
               btn.removeAttribute('disabled', false)
               loading.style.display = 'none'
            },
            error: function(xhr){
               var res = xhr.responseJSON;
               if($.isEmptyObject(res) == false){
                  $.each(res.errors, function(key, value){
                     $('#' + key)
                        .closest('.form-group')
                        .append("<div class='form-text text-danger'>" + value + "</div>")
                        btn.removeAttribute('disabled', false)
                        loading.style.display = 'none'
                  })
               }
            }
         })
      })
   })
</script>
@endpush