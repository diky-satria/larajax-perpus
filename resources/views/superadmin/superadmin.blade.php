@extends('templates/template1')

@section('konten')
<div class="row">
   <div class="col-md-8 mt-4">
      <div class="d-flex justify-content-between">
         <div>
            <h6 class="judul-card">Data Admin</h6>
         </div>
      </div>
      <div class="card card-edited">
         <div class="card-body">
            <table id="example" class="table table-sm table-striped">
               <thead class="thead-edited">
                  <tr>
                     <th>No</th>
                     <th>Nama</th>
                     <th>Email</th>
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
            <h6 class="judul-card">Tambah Admin</h6>
         </div>
      </div>
      <div class="card card-edited">
         <div class="card-body">
            <form method="post" id="form-tambah-admin">
               <div class="form-group mt-2">
                  <label>Nama</label>
                  <input type="text" name="nama" id="nama" class="form-control">
               </div>
               <div class="form-group mt-2">
                  <label>Email</label>
                  <input type="text" name="email" id="email" class="form-control">
               </div>
               <div class="form-group mt-2">
                  <label>Password</label>
                  <input type="password" name="password" id="password" class="form-control">
               </div>
               <div class="form-group mt-2">
                  <label>Konfirmasi Password</label>
                  <input type="password" name="konfirmasi_password" id="konfirmasi_password" class="form-control">
               </div>
               <button type="submit" class="btn btn-sm btn-primary float-end mt-3 d-flex" id="btn-tam-adm">
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

<!-- modal edit admin -->
<div class="modal fade" id="modal-editAdmin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-editAdminLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-editAdminLabel">Edit Admin</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" id="btn-clo-mod-edi-adm" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <form action="" method="post" id="modal-edi-adm">
            <input type="hidden" name="id_edit" id="id_edit">
            <div class="form-group mt-2">
               <label>Nama</label>
               <input type="text" name="nama_edit" id="nama_edit" class="form-control">
            </div>
            <div class="form-group mt-2">
               <label>Email</label>
               <input type="text" id="email_edit" class="form-control" readonly>
            </div>
            
            <!-- tombol -->
            <div class="mt-3">
               <div id="wait" style="display:none;float:left;">
                  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: none; display: block; shape-rendering: auto;float:left;" width="24px" height="24px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                     <g>
                     <path d="M50 15A35 35 0 1 0 74.74873734152916 25.251262658470843" fill="none" stroke="#007bff" stroke-width="12"></path>
                     <path d="M49 3L49 27L61 15L49 3" fill="#007bff"></path>
                     <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
                     </g>
                  </svg><span style="font-weight:bold;display:block;float:right;">Loading...</span>
               </div>
               <button type="submit" class="btn btn-sm btn-primary float-end d-flex" id="btn-edi-adm">
                  <div>Edit</div>
                  <svg id="loadingEdit" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: rgba(255, 255, 255, 0); display: none; shape-rendering: auto;" width="24px" height="24px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                  <g>
                     <path d="M50 15A35 35 0 1 0 74.74873734152916 25.251262658470843" fill="none" stroke="#ffffff" stroke-width="12"></path>
                     <path d="M49 3L49 27L61 15L49 3" fill="#ffffff"></path>
                     <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
                  </g>
                  </svg>
               </button>
            </div>
            <!-- akhir tombol -->

         </form>
      </div>
    </div>
  </div>
</div>
<!-- akhir modal edit admin -->
@endsection

@push('js')
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>
<script>
   let overlay = document.getElementById('overlay-container')
   overlay.style.display = 'flex'
   $(document).ready(function(){ 
      // admil data admin
      ambilData()
      function ambilData(){
         let no = 0
         $.ajax({
            type: 'GET',
            url: 'super-admin/ambil-data',
            success: function(response){
               $('tbody').html('')
               $.each(response.admin, function(key, value){
                  no++
                  $('tbody').append('<tr>\
                                       <td>'+no+'</td>\
                                       <td>'+value.name+'</td>\
                                       <td>'+value.email+'</td>\
                                       <td>\
                                       <button class="btn btn-sm btn-success edit-adm" title="Edit" id="'+value.id+'" data-bs-toggle="modal" data-bs-target="#modal-editAdmin"><i class="fas fa-edit"></i></button>\
                                       <button class="btn btn-sm btn-danger ms-1 hapus-adm" id="'+value.id+'" title="Hapus"><i class="fas fa-trash-alt"></i></button>\
                                       </td>\
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
      })

      // tambah data admin
      $(document).on('submit', '#form-tambah-admin', function(e){
         e.preventDefault()
         let btn = document.getElementById('btn-tam-adm')
         btn.setAttribute('disabled', true)
         let loading = document.getElementById('loading')
         loading.style.display = 'block'
         let formData = new FormData($('#form-tambah-admin')[0])

         let form = $('#form-tambah-admin')
         form.find('.form-text').remove()

         $.ajax({
            type: 'POST',
            url: 'super-admin/tambah',
            data: formData,
            contentType: false,
            processData: false,
            success: function(){
               $('#example').DataTable().destroy()
               ambilData()
               btn.removeAttribute('disabled', false)
               loading.style.display = 'none'
               $('#nama').val('')
               $('#email').val('')
               $('#password').val('')
               $('#konfirmasi_password').val('')
               Toast.fire({
                  icon: 'success',
                  title: 'Admin berhasil ditambahkan'
               })
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

      // ambil data detail untuk modal edit admin
      $(document).on('click', '.edit-adm', function(){
         let id = $(this).attr('id')

         let wait = document.getElementById('wait')
         wait.style.display = 'block'
         let btn = document.getElementById('btn-edi-adm')
         btn.setAttribute('disabled', true)

         $.ajax({
            type: 'GET',
            url: 'super-admin/detail/'+ id,
            success: function(response){
               $('#id_edit').val(response.adminDetail.id)
               $('#nama_edit').val(response.adminDetail.name)
               $('#email_edit').val(response.adminDetail.email)
               wait.style.display = 'none'
               btn.removeAttribute('disabled', false)
            }
         })
      })

      // tutup modal edit admin
      $(document).on('click', '#btn-clo-mod-edi-adm', function(){
         let error = $('#modal-edi-adm')
         error.find('.form-text').remove()
      })

      // edit data admin
      $(document).on('submit', '#modal-edi-adm', function(e){
         e.preventDefault()
         let btn = document.getElementById('btn-edi-adm')
         btn.setAttribute('disabled', true)
         let loadingEdit = document.getElementById('loadingEdit')
         loadingEdit.style.display = 'block'

         let id = $('#id_edit').val()
         let formData = new FormData($('#modal-edi-adm')[0])

         $.ajax({
            type: 'POST',
            url: 'super-admin/edit/' + id,
            data: formData,
            contentType: false,
            processData: false,
            success: function(){
               ambilData()
               $('#btn-clo-mod-edi-adm').click()
               btn.removeAttribute('disabled', false)
               loadingEdit.style.display = 'none'
               Toast.fire({
                  icon: 'success',
                  title: 'Admin berhasil diedit'
               })
            },
            error: function(xhr){
               var res = xhr.responseJSON;
               if($.isEmptyObject(res) == false){
                  $.each(res.errors, function(key, value){
                     $('#' + key)
                        .closest('.form-group')
                        .append("<div class='form-text text-danger'>" + value + "</div>")
                        btn.removeAttribute('disabled', false)
                        loadingEdit.style.display = 'none'
                  })
               }
            }
         })
      })

      // hapus data admin
      $(document).on('click', '.hapus-adm', function(e){
         e.preventDefault()
         let id = $(this).attr('id')

         Swal.fire({
            title: 'Apa kamu yakin ?',
            text: "ingin menghapus admin ini",
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
                  url: "super-admin/hapus/"+id,
                  success: function(){
                     $('#example').DataTable().destroy()
                     ambilData()
                     Toast.fire({
                        icon: 'success',
                        title: 'Admin berhasil dihapus'
                     })
                  }
               })

            }
         })
      })
   })
</script>
@endpush