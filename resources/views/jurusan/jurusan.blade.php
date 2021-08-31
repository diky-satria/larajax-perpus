@extends('templates/template1')

@section('konten')
<div class="row">
   <div class="col-md-8 mt-4">
      <div class="d-flex justify-content-between">
         <div>
            <h6 class="judul-card">Data Jurusan</h6>
         </div>
         <div>
            <a href="{{ url('dashboard') }}" class="btn btn-sm btn-dark text-white" data-bs-toggle="tooltip" data-bs-placement="left" title="Kembali"><i class="fas fa-arrow-left"></i></a>
         </div>
      </div>
      <div class="card card-edited">
         <div class="card-body">
            <table id="example" class="table table-sm table-striped">
               <thead class="thead-edited">
                  <tr>
                     <th>No</th>
                     <th>Jurusan</th>
                     <th>Opsi</th>
                  </tr>
               </thead>
               <tbody>
                  
               </tbody>
            </table>
         </div>
      </div>
   </div>
   <div class="col-md-4 mt-4">
   <div class="d-flex justify-content-between">
         <div>
            <h6 class="judul-card">Tambah Jurusan</h6>
         </div>
      </div>
      <div class="card card-edited">
         <div class="card-body">
            <form action="{{ url('jurusan/tambah') }}" method="post" id="form-tambah-jurusan">
               <div class="form-group">
                  <label>Nama Jurusan</label>
                  <input type="text" name="nama_jurusan" id="nama_jurusan" class="form-control">
               </div>
               <button type="submit" class="btn btn-sm btn-primary float-end mt-3 d-flex" id="btn-tam-jur">
                  <div>Tambah</div>
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
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>
<script>
   let overlay = document.getElementById('overlay-container')
   overlay.style.display = 'flex'
   $(document).ready(function(){
      
      // ambil data
      ambilData()
      function ambilData(){
         let baris = 0
         $.ajax({
            type: "GET",
            url: "jurusan/ambilData",
            success: function(response){
               $('tbody').html('')
               $.each(response.jurusans, function(key, value){
                  baris = baris + 1
                  $('tbody').append('<tr>\
                                       <td>'+baris+'</td>\
                                       <td>'+value.nama_jurusan+'</td>\
                                       <td><button class="btn btn-sm btn-danger btn-hap-jur" id="'+value.id+'"><i class="fas fa-trash-alt"></i></button></td>\
                                    </tr>')
               })
               $('#example').DataTable()
            }
         })
         overlay.style.display = 'none'
      }

      // ajax toke setup
      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      });

      // tambah jurusan
      $(document).on('submit', '#form-tambah-jurusan', function(e){
         e.preventDefault()

         let btn = document.getElementById('btn-tam-jur')
         btn.setAttribute('disabled', true)
         let loading = document.getElementById('loading')
         loading.style.display = 'block'
         let formData = new FormData($('#form-tambah-jurusan')[0])

         var form = $('#form-tambah-jurusan')
         form.find('.form-text').remove()

         $.ajax({
            type: "POST",
            url: "jurusan/tambah",
            data: formData,
            contentType: false,
            processData: false,
            success: function(){
               $('#example').DataTable().destroy()
               $('#nama_jurusan').val('')
               ambilData()
               loading.style.display = 'none'
               btn.removeAttribute('disabled', false)
               Toast.fire({
                  icon: 'success',
                  title: 'Jurusan berhasil ditambahkan'
               })
            },
            error: function(xhr){
               var res = xhr.responseJSON;
               if($.isEmptyObject(res) == false){
                  $.each(res.errors, function(key, value){
                     $('#' + key)
                        .closest('.form-group')
                        .append("<div class='form-text text-danger'>" + value + "</div>")
                        loading.style.display = 'none'
                        btn.removeAttribute('disabled', false)
                  })
               }
            }
         })
      })

      // hapus jurusan
      $(document).on('click', '.btn-hap-jur', function(e){
         e.preventDefault()
         let id = $(this).attr('id')

         Swal.fire({
            title: 'Apa kamu yakin ?',
            text: "ingin menghapus jurusan ini",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Kembali',
            cancelButtonColor: 'black'
            }).then((result) => {
            if (result.isConfirmed) {

               $.ajax({
                  type: "DELETE",
                  url: "jurusan/hapus/"+id,
                  success: function(){
                     $('#example').DataTable().destroy()
                     ambilData()
                     Toast.fire({
                        icon: 'success',
                        title: 'Jurusan berhasil dihapus'
                     })
                  },
                  error: function(){
                     toastFail.fire({
                        icon: 'error',
                        title: 'Jurusan gagal dihapus, masih ada mahasiswa yang menggunakan jurusan ini !'
                     })
                  }
               })

            }
         })
      })
   })
</script>
@endpush