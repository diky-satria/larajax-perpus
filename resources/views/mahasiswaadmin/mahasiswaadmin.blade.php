@extends('templates/template1')

@section('konten')
<div class="row">
   <div class="col-md mt-4">
      <div class="d-flex justify-content-between">
         <div>
            <h6 class="judul-card">Data Mahasiswa</h6>
         </div>
         <div>
            <a href="{{ url('dashboard') }}" class="btn btn-sm btn-dark text-white" data-bs-toggle="tooltip" data-bs-placement="left" title="Kembali"><i class="fas fa-arrow-left"></i></a>
            <a href="" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-mahasiswaAdmin"><i class="fas fa-plus"></i></a>
         </div>
      </div>
      <div class="card card-edited">
         <div class="card-body">
            <table class="table table-sm table-striped" id="tab-mah-adm">
               <thead class="thead-edited">
                  <tr>
                     <th>No</th>
                     <th>NIM</th>
                     <th>Nama</th>
                     <th>Jurusan</th>
                     <th>Opsi</th>
                  </tr>
               </thead>
            </table>
         </div>
      </div>
   </div>
</div>

<!-- modal detail mahasiswa admin -->
<div class="modal fade" id="modal-detailMahasiswaAdmin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-detailMahasiswaAdminLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-detailMahasiswaAdminLabel">Detail Mahasiswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" id="btn-clo-mod-det-mah-adm" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <table class="table table-sm" id="modal-det-mah-adm">
            <tr>
               <th>NIM</th>
               <td>:</td>
               <td id="nimDetail"></td>
            </tr>
            <tr>
               <th>Nama</th>
               <td>:</td>
               <td id="namaDetail"></td>
            </tr>
            <tr>
               <th>Email</th>
               <td>:</td>
               <td id="emailDetail"></td>
            </tr>
            <tr>
               <th>Jurusan</th>
               <td>:</td>
               <td id="jurusanDetail"></td>
            </tr>
            <tr>
               <th>Semester</th>
               <td>:</td>
               <td id="semesterDetail"></td>
            </tr>
            <tr>
               <th>Kelas</th>
               <td>:</td>
               <td id="kelasDetail"></td>
            </tr>
         </table>
         <div id="waitDetail" style="display:none;float:left;">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: none; display: block; shape-rendering: auto;float:left;" width="24px" height="24px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
               <g>
               <path d="M50 15A35 35 0 1 0 74.74873734152916 25.251262658470843" fill="none" stroke="#007bff" stroke-width="12"></path>
               <path d="M49 3L49 27L61 15L49 3" fill="#007bff"></path>
               <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
               </g>
            </svg><span style="font-weight:bold;display:block;float:right;">Loading...</span>
         </div>
      </div>
    </div>
  </div>
</div>
<!-- akhir modal detail mahasiswa admin -->

<!-- modal tambah mahasiswa admin -->
<div class="modal fade" id="modal-mahasiswaAdmin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-mahasiswaAdminLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-mahasiswaAdminLabel">Tambah Mahasiswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" id="btn-clo-mod-tam-mah-adm" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <form action="{{ url('mahasiswa-admin/tambah') }}" method="post" id="modal-tam-mah-adm">
            <div class="form-group mt-2">
               <label>NIM</label>
               <input type="text" name="nim" id="nim" class="form-control">
            </div>
            <div class="form-group mt-2">
               <label>Nama</label>
               <input type="text" name="nama" id="nama" class="form-control">
            </div>
            <div class="form-group mt-2">
               <label>Email</label>
               <input type="text" name="email" id="email" class="form-control">
            </div>
            <div class="form-group mt-2">
               <label>Jurusan</label>
               <select class="form-control" name="jurusan" id="jurusan">
                  <option value="">---</option>
                  @foreach($jurusan as $j)
                  <option value="{{ $j->id }}">{{ $j->nama_jurusan }}</option>
                  @endforeach
               </select>
            </div>
            <div class="form-group mt-2">
               <label>Semester</label>
               <select class="form-control" name="semester" id="semester">
                  <option value="">---</option>
                  @foreach($semester as $s)
                  <option value="{{ $s->id }}">{{ $s->nama_semester }}</option>
                  @endforeach
               </select>
            </div>
            <div class="form-group mt-2">
               <label>Kelas</label>
               <select class="form-control" name="kelas" id="kelas">
                  <option value="">---</option>
                  @foreach($kelas as $k)
                  <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                  @endforeach
               </select>
            </div>
            <button type="submit" class="btn btn-sm btn-primary float-end mt-3 d-flex" id="btn-tam-mah-adm">
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
<!-- akhir modal tambah mahasiswa admin -->

<!-- modal edit mahasiswa admin -->
<div class="modal fade" id="modal-editMahasiswaAdmin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-editMahasiswaAdminLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-editMahasiswaAdminLabel">Edit Mahasiswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" id="btn-clo-mod-edi-mah-adm" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <form method="patch" id="modal-edi-mah-adm">
            <input type="hidden" name="idEdit" id="idEdit">
            <div class="form-group mt-2">
               <label>NIM</label>
               <input type="text" name="nimEdit" id="nimEdit" class="form-control" readonly>
            </div>
            <div class="form-group mt-2">
               <label>Nama</label>
               <input type="text" name="namaEdit" id="namaEdit" class="form-control">
            </div>
            <div class="form-group mt-2">
               <label>Email</label>
               <input type="text" name="emailEdit" id="emailEdit" class="form-control" readonly>
            </div>
            <div class="form-group mt-2">
               <label>Jurusan</label>
               <select class="form-control" name="jurusanEdit" id="jurusanEdit">
                  @foreach($jurusan as $j)
                  <option value="{{ $j->id }}">{{ $j->nama_jurusan }}</option>
                  @endforeach
               </select>
            </div>
            <div class="form-group mt-2">
               <label>Semester</label>
               <select class="form-control" name="semesterEdit" id="semesterEdit">
                  @foreach($semester as $s)
                  <option value="{{ $s->id }}">{{ $s->nama_semester }}</option>
                  @endforeach
               </select>
            </div>
            <div class="form-group mt-2">
               <label>Kelas</label>
               <select class="form-control" name="kelasEdit" id="kelasEdit">
                  @foreach($kelas as $k)
                  <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                  @endforeach
               </select>
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
               <button type="submit" class="btn btn-sm btn-primary float-end d-flex" id="btn-edi-mah-adm">
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
<!-- akhir modal edit mahasiswa admin -->
@endsection

@push('js')
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>
<script>
   let overlay = document.getElementById('overlay-container')
   overlay.style.display = 'flex'
   $(document).ready(function(){
      // ambil data mahasiswa admin
      $('#tab-mah-adm').DataTable({
         serverSide: true,
         responsive: true,
         ajax: {
            url: 'mahasiswa-admin'
         },
         columns: [
            {
               "data" : null, "sortable" : false,
               render: function(data, type, row, meta){
                  return meta.row + meta.settings._iDisplayStart + 1
               }
            },
            {data: 'nim', name: 'nim'},
            {data: 'nama', name: 'nama'},
            {data: 'jurusan', name: 'jurusan'},
            {data: 'opsi', name: 'opsi'},
         ]
      })
      overlay.style.display = 'none'

      // ajax token setup
      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      })

      // tutup modal tambah mahasiswa admin
      $(document).on('click', '#btn-clo-mod-tam-mah-adm', function(){
         var form = $('#modal-tam-mah-adm')
         form.find('.form-text').remove()
         $('#nim').val('')
         $('#nama').val('')
         $('#email').val('')
         $('#jurusan').val('')
         $('#semester').val('')
         $('#kelas').val('')
         
      })

      // tambah mahasiswa admin
      $(document).on('submit', '#modal-tam-mah-adm', function(e){
         e.preventDefault()

         let btn = document.getElementById('btn-tam-mah-adm')
         btn.setAttribute('disabled', true)
         let loading = document.getElementById('loading')
         loading.style.display = 'block'
         let formData = new FormData($('#modal-tam-mah-adm')[0])

         var form = $('#modal-tam-mah-adm')
         form.find('.form-text').remove()

         $.ajax({
            type: 'POST',
            url: 'mahasiswa-admin/tambah',
            data: formData,
            contentType: false,
            processData: false,
            success: function(){
               $('#tab-mah-adm').DataTable().ajax.reload()
               $('#btn-clo-mod-tam-mah-adm').click()
               btn.removeAttribute('disabled', false)
               loading.style.display = 'none'
               Toast.fire({
                  icon: 'success',
                  title: 'Mahasiswa berhasil ditambahkan'
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

      // loading detail data modal
      function wait(){
         let wait = document.getElementById('wait')
         let btn = document.getElementById('btn-edi-mah-adm')
         wait.style.display = 'block'
         btn.setAttribute('disabled', true)
      }

      // hapus loading detail data modal
      function hapusWait(){
         let wait = document.getElementById('wait')
         let btn = document.getElementById('btn-edi-mah-adm')
         wait.style.display = 'none'
         btn.removeAttribute('disabled', false)
      }

      // tutup modal detail mahasiswa admin
      $(document).on('click', '#btn-clo-mod-det-mah-adm', function(){
         $('#nimDetail').html('')
         $('#namaDetail').html('')
         $('#emailDetail').html('')
         $('#jurusanDetail').html('')
         $('#semesterDetail').html('')
         $('#kelasDetail').html('')
      })

      // ambil detail mahasiswa untuk modal detail
      $(document).on('click', '.lihat-mah-adm', function(){
         let waitDetail = document.getElementById('waitDetail')
         waitDetail.style.display = 'block'
         let id = $(this).attr('id')

         $.ajax({
            type: 'GET',
            url: 'mahasiswa-admin/detail/'+id,
            success: function(response){
               $('#nimDetail').append(response.data[0].nim)
               $('#namaDetail').append(response.data[0].nama)
               $('#emailDetail').append(response.data[0].email)
               $('#jurusanDetail').append(response.data[0].jurusan)
               $('#semesterDetail').append(response.data[0].semester)
               $('#kelasDetail').append(response.data[0].kelas)
               waitDetail.style.display = 'none'
            }
         })
      })

      // tutup modal edit mahasiswa admin
      $(document).on('click', '#btn-clo-mod-edi-mah-adm', function(){
         let form = $('#modal-edi-mah-adm')
         form.find('.form-text').remove()
      })

      // ambil detail mahasiswa untuk modal edit
      $(document).on('click', '.edit-mah-adm', function(){
         wait()
         let id = $(this).attr('id')

         $.ajax({
            type: 'GET',
            url: 'mahasiswa-admin/detail/'+id,
            success: function(response){
               $('#idEdit').val(response.data[0].id)
               $('#nimEdit').val(response.data[0].nim)
               $('#namaEdit').val(response.data[0].nama)
               $('#emailEdit').val(response.data[0].email)
               $('#jurusanEdit').val(response.data[0].jurusan_id)
               $('#semesterEdit').val(response.data[0].semester_id)
               $('#kelasEdit').val(response.data[0].kelas_id)
               hapusWait()
            }
         })
      })

      // edit mahasiswa admin
      $(document).on('submit', '#modal-edi-mah-adm', function(e){
         e.preventDefault()

         let btn = document.getElementById('btn-edi-mah-adm')
         btn.setAttribute('disabled', true)
         let loadingEdit = document.getElementById('loadingEdit')
         loadingEdit.style.display = 'block'
         let id = $('#idEdit').val()
         let formData = new FormData($('#modal-edi-mah-adm')[0])

         $.ajax({
            type: 'POST',
            url: 'mahasiswa-admin/edit/'+id,
            data: formData,
            contentType: false,
            processData: false,
            success: function(){
               $('#btn-clo-mod-edi-mah-adm').click()
               btn.removeAttribute('disabled', false)
               loadingEdit.style.display = 'none'
               $('#tab-mah-adm').DataTable().ajax.reload()
               Toast.fire({
                  icon: 'success',
                  title: 'Mahasiswa berhasil diedit'
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

      // hapus mahasiswa admin
      $(document).on('click', '.hapus-mah-adm', function(e){
         e.preventDefault()
         let id = $(this).attr('id')

         Swal.fire({
            title: 'Apa kamu yakin ?',
            text: "ingin menghapus mahasiswa ini",
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
                  url: "mahasiswa-admin/hapus/"+id,
                  success: function(){
                     $('#tab-mah-adm').DataTable().ajax.reload()
                     Toast.fire({
                        icon: 'success',
                        title: 'Mahasiswa berhasil dihapus'
                     })
                  }
               })

            }
         })
      })
   })
</script>
@endpush