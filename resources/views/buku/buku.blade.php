@extends('templates/template1')

@section('konten')
<div class="row">
   <div class="col-md mt-4">
      <div class="d-flex justify-content-between">
         <div>
            <h6 class="judul-card">Data Buku</h6>
         </div>
         <div>
            <a href="{{ url('dashboard') }}" class="btn btn-sm btn-dark text-white" data-bs-toggle="tooltip" data-bs-placement="left" title="Kembali"><i class="fas fa-arrow-left"></i></a>
            <a href="" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-buk-tam"><i class="fas fa-plus"></i></a>
         </div>
      </div>
      <div class="card card-edited">
         <div class="card-body">
            <table class="table table-sm table-striped" id="tab-buk">
               <thead class="thead-edited">
                  <tr>
                     <th>No</th>
                     <th>Kode</th>
                     <th>Judul</th>
                     <th>Jumlah</th>
                     <th>Gambar</th>
                     <th>Opsi</th>
                  </tr>
               </thead>
            </table>
         </div>
      </div>
   </div>
</div>

<!-- modal detail buku -->
<div class="modal fade" id="modal-buk-det" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-buk-detLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-buk-detLabel">Detail Buku</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" id="btn-clo-mod-buk-det" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <table class="table table-sm" id="modal-det-buk">
            <tr>
               <th>Kode</th>
               <td>:</td>
               <td id="kodeDetail"></td>
            </tr>
            <tr>
               <th>Judul</th>
               <td>:</td>
               <td id="judulDetail"></td>
            </tr>
            <tr>
               <th>Pengarang</th>
               <td>:</td>
               <td id="pengarangDetail"></td>
            </tr>
            <tr>
               <th>Penerbit</th>
               <td>:</td>
               <td id="penerbitDetail"></td>
            </tr>
            <tr>
               <th>Tahun</th>
               <td>:</td>
               <td id="tahunDetail"></td>
            </tr>
            <tr>
               <th>ISBN</th>
               <td>:</td>
               <td id="isbnDetail"></td>
            </tr>
            <tr>
               <th>Jumlah</th>
               <td>:</td>
               <td id="jumlahDetail"></td>
            </tr>
            <tr>
               <th>Lokasi</th>
               <td>:</td>
               <td id="lokasiDetail"></td>
            </tr>
            <tr>
               <th>Gambar</th>
               <td>:</td>
               <td id="gambarDetail"></td>
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
<!-- akhir modal detail buku -->

<!-- modal tambah buku -->
<div class="modal fade" id="modal-buk-tam" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-buk-tamLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-buk-tamLabel">Tambah Buku</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" id="btn-clo-mod-buk" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <form action="" method="post" id="modal-tam-buk" enctype="multipart/form-data">
            <div class="form-group mt-2">
               <label>Kode</label>
               <input type="text" name="kode_buku" id="kode_buku" class="form-control">
            </div>
            <div class="form-group mt-2">
               <label>Judul</label>
               <input type="text" name="judul" id="judul" class="form-control">
            </div>
            <div class="form-group mt-2">
               <label>Pengarang</label>
               <input type="text" name="pengarang" id="pengarang" class="form-control">
            </div>
            <div class="form-group mt-2">
               <label>Penerbit</label>
               <input type="text" name="penerbit" id="penerbit" class="form-control">
            </div>
            <div class="row">
               <div class="col-md">
                  <div class="form-group mt-2">
                     <label>Tahun</label>
                     <input type="text" name="tahun" id="tahun" class="form-control">
                  </div>
                  <div class="form-group mt-2">
                     <label>ISBN</label>
                     <input type="text" name="isbn" id="isbn" class="form-control">
                  </div>
               </div>
               <div class="col-md">
                  <div class="form-group mt-2">
                     <label>Jumlah</label>
                     <input type="text" name="jumlah" id="jumlah" class="form-control">
                  </div>
                  <div class="form-group mt-2">
                     <label>Lokasi</label>
                     <select class="form-control" name="lokasi_id" id="lokasi_id">
                        <option value="">---</option>
                        @foreach($lokasi as $l)
                        <option value="{{ $l->id }}">{{ $l->nama_lokasi }}</option>
                        @endforeach
                     </select>
                  </div> 
               </div>
            </div>
            <div class="form-group mt-2">
               <label>Gambar</label>
               <input type="file" name="gambar" id="gambar" class="form-control">
            </div>
            <button type="submit" class="btn btn-sm btn-primary float-end mt-3 d-flex" id="btn-tam-buk">
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
<!-- akhir modal tambah buku -->

<!-- modal edit buku -->
<div class="modal fade" id="modal-buk-edi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-buk-ediLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-buk-ediLabel">Edit Buku</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" id="btn-clo-mod-buk-edi" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <form action="" method="post" id="modal-edi-buk" enctype="multipart/form-data">
            <input type="hidden" name="idEdit" id="idEdit">
            <div class="form-group mt-2">
               <label>Kode</label>
               <input type="text" name="kode_bukuEdit" id="kode_bukuEdit" class="form-control" readonly>
            </div>
            <div class="form-group mt-2">
               <label>Judul</label>
               <input type="text" name="judulEdit" id="judulEdit" class="form-control">
            </div>
            <div class="form-group mt-2">
               <label>Pengarang</label>
               <input type="text" name="pengarangEdit" id="pengarangEdit" class="form-control">
            </div>
            <div class="form-group mt-2">
               <label>Penerbit</label>
               <input type="text" name="penerbitEdit" id="penerbitEdit" class="form-control">
            </div>
            <div class="row">
               <div class="col-md">
                  <div class="form-group mt-2">
                     <label>Tahun</label>
                     <input type="text" name="tahunEdit" id="tahunEdit" class="form-control">
                  </div>
                  <div class="form-group mt-2">
                     <label>ISBN</label>
                     <input type="text" name="isbnEdit" id="isbnEdit" class="form-control">
                  </div>
               </div>
               <div class="col-md">
                  <div class="form-group mt-2">
                     <label>Jumlah</label>
                     <input type="text" name="jumlahEdit" id="jumlahEdit" class="form-control">
                  </div>
                  <div class="form-group mt-2">
                     <label>Lokasi</label>
                     <select class="form-control" name="lokasi_idEdit" id="lokasi_idEdit">
                        @foreach($lokasi as $l)
                        <option value="{{ $l->id }}">{{ $l->nama_lokasi }}</option>
                        @endforeach
                     </select>
                  </div> 
               </div>
            </div>
            <div class="form-group mt-2">
               <label>Gambar</label>
               <input type="file" name="gambarEdit" id="gambarEdit" class="form-control">
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
               <button type="submit" class="btn btn-sm btn-primary float-end d-flex" id="btn-edi-buk">
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
<!-- akhir modal edit buku -->
@endsection

@push('js')
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>
<script>
   let overlay = document.getElementById('overlay-container')
   overlay.style.display = 'flex'
   $(document).ready(function(){
      // ambil data buku
      $('#tab-buk').DataTable({
         serverSide: true,
         responsive: true,
         ajax: {
            url: 'buku',
         },
         columns: [
            {
               "data" : null, "sortable" : false,
               render: function(data, type, row, meta){
                  return meta.row + meta.settings._iDisplayStart + 1
               }
            },
            {data: 'kode_buku', name: 'kode_buku'},
            {data: 'judul', name: 'judul'},
            {data: 'jumlah', name: 'jumlah'},
            {data: 'gambar', name: 'gambar'},
            {data: 'opsi', name: 'opsi'}
         ]
      })
      overlay.style.display = 'none'

      // tutup modal buku detail
      $(document).on('click', '#btn-clo-mod-buk-det', function(){
         $('#kodeDetail').html('')
         $('#judulDetail').html('')
         $('#pengarangDetail').html('')
         $('#penerbitDetail').html('')
         $('#tahunDetail').html('')
         $('#isbnDetail').html('')
         $('#jumlahDetail').html('')
         $('#lokasiDetail').html('')
         $('#gambarDetail').html('')
      })

      // ambil data untuk modal detail
      $(document).on('click', '.lihat-buk', function(){
         let waitDetail = document.getElementById('waitDetail')
         waitDetail.style.display = 'block'
         let id = $(this).attr('id')

         $.ajax({
            type: 'GET',
            url: 'buku/detail/'+ id,
            success: function(response){
               $('#kodeDetail').append(response.buku.kode_buku)
               $('#judulDetail').append(response.buku.judul)
               $('#pengarangDetail').append(response.buku.pengarang)
               $('#penerbitDetail').append(response.buku.penerbit)
               $('#tahunDetail').append(response.buku.tahun)
               $('#isbnDetail').append(response.buku.isbn)
               $('#jumlahDetail').append(response.buku.jumlah)
               $('#lokasiDetail').append(response.buku.lokasi)
               $('#gambarDetail').append("<img src='"+ 'assets/gambar/'+ response.buku.gambar +"' width='150' height='200' style='border-radius:10px;'>")
               waitDetail.style.display = 'none'
            }
         })
      })

      // ajax toke setup
      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      })

      // tutup modal tambah buku
      $(document).on('click', '#btn-clo-mod-buk', function(){
         let form = $('#modal-tam-buk')
         form.find('.form-text').remove()
         $('#kode_buku').val('')
         $('#judul').val('')
         $('#pengarang').val('')
         $('#penerbit').val('')
         $('#tahun').val('')
         $('#isbn').val('')
         $('#jumlah').val('')
         $('#lokasi_id').val('')
         $('#gambar').val('')
      })

      //tambah buku
      $(document).on('submit', '#modal-tam-buk', function(e){
         e.preventDefault()
         let formData = new FormData($('#modal-tam-buk')[0])
         let btn = document.getElementById('btn-tam-buk')
         btn.setAttribute('disabled', true)
         let loading = document.getElementById('loading')
         loading.style.display = 'block'
         let form = $('#modal-tam-buk')
         form.find('.form-text').remove()

         $.ajax({
            type: 'POST',
            url: 'buku/tambah',
            data: formData,
            contentType: false,
            processData: false,
            success: function(){
               $('#tab-buk').DataTable().ajax.reload()
               $('#btn-clo-mod-buk').click()
               btn.removeAttribute('disabled', false)
               loading.style.display = 'none'
               Toast.fire({
                  icon: 'success',
                  title: 'Buku berhasil ditambahkan'
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

      // tutup modal buku edit
      $(document).on('click', '#btn-clo-mod-buk-edi', function(){
         let form = $('#modal-edi-buk')
         form.find('.form-text').remove()
      })

      // ambil detail data untuk modal edit
      $(document).on('click', '.edit-buk', function(){
         let id = $(this).attr('id')
         let wait = document.getElementById('wait')
         let btn = document.getElementById('btn-edi-buk')
         wait.style.display = 'block'
         btn.setAttribute('disabled', true)

         $.ajax({
            type: 'GET',
            url: 'buku/detail/'+ id,
            success: function(response){
               $('#idEdit').val(response.buku.id)
               $('#kode_bukuEdit').val(response.buku.kode_buku)
               $('#judulEdit').val(response.buku.judul)
               $('#pengarangEdit').val(response.buku.pengarang)
               $('#penerbitEdit').val(response.buku.penerbit)
               $('#tahunEdit').val(response.buku.tahun)
               $('#isbnEdit').val(response.buku.isbn)
               $('#jumlahEdit').val(response.buku.jumlah)
               $('#lokasi_idEdit').val(response.buku.lokasi_id)
               wait.style.display = 'none'
               btn.removeAttribute('disabled', false)
            }
         })
      })

      // edit buku
      $(document).on('submit', '#modal-edi-buk', function(e){
         e.preventDefault()
         let id = $('#idEdit').val()
         let formData = new FormData($('#modal-edi-buk')[0])
         let btn = document.getElementById('btn-edi-buk')
         btn.setAttribute('disabled', true)
         let loadingEdit = document.getElementById('loadingEdit')
         loadingEdit.style.display = 'block'

         let form = $('#modal-edi-buk')
         form.find('.form-text').remove()

         $.ajax({
            type: 'POST',
            url: 'buku/edit/' + id,
            data: formData,
            contentType: false,
            processData: false,
            success: function(){
               $('#tab-buk').DataTable().ajax.reload()
               $('#btn-clo-mod-buk-edi').click()
               btn.removeAttribute('disabled', false)
               loadingEdit.style.display = 'none'
               Toast.fire({
                  icon: 'success',
                  title: 'Buku berhasil diedit'
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

      $(document).on('click', '.hapus-buk', function(){
         let id = $(this).attr('id')

         Swal.fire({
            title: 'Apa kamu yakin ?',
            text: "ingin menghapus buku ini",
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
                  url: "buku/hapus/"+id,
                  success: function(){
                     $('#tab-buk').DataTable().ajax.reload()
                     Toast.fire({
                        icon: 'success',
                        title: 'Buku berhasil dihapus'
                     })
                  }
               })

            }
         })
      })
   })
</script>
@endpush