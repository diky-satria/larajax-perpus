@extends('templates/template1')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('konten')
<div class="row">
   <div class="col-md mt-4">
      <div class="d-flex justify-content-between">
         <div>
            <h6 class="judul-card">Transaksi Peminjaman</h6>
         </div>
         <div>
         <a href="{{ url('transaksi') }}" class="btn btn-sm btn-dark text-white" data-bs-toggle="tooltip" data-bs-placement="left" title="Kembali"><i class="fas fa-arrow-left"></i></a>
         </div>
      </div>
      <div class="card card-edited">
         <div class="card-body">
            <form action="" id="form-tam-buk">
               <div class="row">
                  <div class="col-md">
                     <div class="form-group mb-2">
                        <label>Kode Peminjaman</label>
                        <input type="text" class="form-control tran-control" name="kode" id="kode" value="{{ $kode_random }}" readonly>
                     </div>
                  </div>
                  <div class="col-md">
                     <div class="form-group mb-2">
                        <label>Tgl Peminjaman</label>
                        <input type="text" class="form-control tran-control" name="tgl_peminjaman" id="tgl_peminjaman" value="{{ $tgl_peminjaman }}" readonly>
                     </div>
                  </div>
                  <div class="col-md">
                     <div class="form-group mb-2">
                        <label>Tgl Pengembalian</label>
                        <input type="text" class="form-control tran-control" name="tgl_pengembalian" id="tgl_pengembalian" value="{{ $tgl_pengembalian }}" readonly>
                     </div>
                  </div>
                  <div class="col-md">
                     <div class="form-group">
                        <label>Buku</label>
                        <select class="form-control select2" name="buku_id" id="buku_id" data-width="100%">
                           <option value="">----</option>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md">
                     <button type="submit" class="btn btn-sm btn-primary float-end mt-3 d-flex" id="btn-tran-tam-buk">
                        <div>Tambah</div>
                        <svg id="loading" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: rgba(255, 255, 255, 0); display: none; shape-rendering: auto;" width="24px" height="24px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                        <g>
                           <path d="M50 15A35 35 0 1 0 74.74873734152916 25.251262658470843" fill="none" stroke="#ffffff" stroke-width="12"></path>
                           <path d="M49 3L49 27L61 15L49 3" fill="#ffffff"></path>
                           <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
                        </g>
                        </svg>
                     </button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<div class="row" id="con-tab" style="margin-top:60px;display:none;">
   <div class="col-md">
      <div class="card card-edited">
         <div class="row">
            <div class="col-md">
               <table class="table table-sm" id="tab-pil-buk">
                  <thead class="thead-edited">
                     <tr>
                        <th>No</th>
                        <th>Kode Buku</th>
                        <th>Judul</th>
                        <th>Opsi</th>
                     </tr>
                  </thead>
                  <tbody id="tbody">
                     
                  </tbody>
               </table>
            </div>
         </div>
         <div class="row mb-4">
            <div class="col-md"></div>
            <div class="col-md"></div>
            <div class="col-md"></div>
            <div class="col-md">
               <form action="" id="lanjutkan-peminjaman">
                  <input type="hidden" name="count" id="count">
                  <div class="form-group mt-1">
                     <label>Mahasiswa</label>
                     <select name="mahasiswa_id" class="form-control select22" id="mahasiswa_id" data-width="100%">
                        <option value="">----</option>
                        @foreach($mhs as $m)
                        <option value="{{ $m->id }}">{{ $m->nama }}</option>
                        @endforeach
                     </select>
                  </div>
                  <div class="d-grid">
                     <button type="submit" class="btn btn-sm btn-primary mt-3 mb-4" id="btn-lanjutkan">
                        <div id="text-lanjutkan" style="display:block;">Lanjutkan</div>
                        <svg id="loadingLanjutkan" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: rgba(255, 255, 255, 0); display: none; shape-rendering: auto;" width="24px" height="24px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                        <g>
                           <path d="M50 15A35 35 0 1 0 74.74873734152916 25.251262658470843" fill="none" stroke="#ffffff" stroke-width="12"></path>
                           <path d="M49 3L49 27L61 15L49 3" fill="#ffffff"></path>
                           <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
                        </g>
                        </svg>
                     </button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="row" id="con-none" style="margin-top:60px;display:block;">
   <div class="col-md">
      <h5 class="text-center" style="background-color:rgb(255, 101, 101);padding:10px;border-radius:10px;">Anda belum memilih buku</h5>
   </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
   let overlay = document.getElementById('overlay-container')
   overlay.style.display = 'flex'
   $(document).ready(function() {
      // edit select option ke select2
      select()
      function select(){
         $('.select2').select2();
      }

      // select2 untuk form yang bawah / diatas button lanjutkan
      select22()
      function select22(){
         $('.select22').select2();
      }

      // ambil data buku
      ambilDataBuku()
      function ambilDataBuku(){
         let buku = $('#buku_id')
         buku.find('.opt').remove()

         $.ajax({
            type: 'GET',
            url: 'transaksi-ambil-data',
            success: function(response){
               $.each(response.buku, function(key, value){
                  $('#buku_id').append("<option class='opt' value='"+value.id+"'>"+value.judul+"</option>")
               })
               overlay.style.display = 'none'
            }
         })
      }

      // ajax token setup
      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      })

      //menghilangkan disabled setelah menginputkan buku
      $(document).on('change', '#buku_id', function(){
         let btn = document.getElementById('btn-tran-tam-buk')
         btn.removeAttribute('disabled', false)
      })
   
      // tambah data buku
      $(document).on('submit', '#form-tam-buk', function(e){
         e.preventDefault()
         let form = $('#form-tam-buk')
         form.find('.form-text').remove()

         let btn = document.getElementById('btn-tran-tam-buk')
         btn.setAttribute('disabled', true)
         let loading = document.getElementById('loading')
         loading.style.display = 'block'
         let formData = new FormData($('#form-tam-buk')[0])
   
         $.ajax({
            type: 'POST',
            url: 'transaksi-tambah/tambah',
            data: formData,
            contentType: false,
            processData: false,
            success: function(){
               ambilDataBuku()
               tampilBuku()
               loading.style.display = 'none'
               Toast.fire({
                  icon: 'success',
                  title: 'Buku berhasil dipilih'
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

      // menampilkan data buku yang telah dipilih
      function tampilBuku(){
         let tr = $('#tbody')
         tr.find('tr').remove()
         let kode = $('#kode').val()

         $.ajax({
            type: 'GET',
            url: 'transaksi-tambah/tampil/' + kode,
            success: function(response){
               let con_tab = document.getElementById('con-tab')
               let con_none = document.getElementById('con-none')
               if(response.count > 0){
                  con_tab.style.display = 'block'
                  con_none.style.display = 'none'
                  $('#count').val(response.count)
                  
                  let baris = 0
                  $.each(response.data, function(key, value){
                     baris = baris + 1
                     $('#tbody').append('<tr>\
                              <td>'+baris+'</td>\
                              <td>'+value.kode_buku+'</td>\
                              <td>'+value.judul+'</td>\
                              <td><button class="btn btn-sm btn-danger hapusBuku" id="'+value.id+'" kode-buku="'+value.kode_buku+'" title="Hapus"><i class="fas fa-trash-alt"></i></button></td>\
                           </tr>')
                  })
               }else{
                  con_tab.style.display = 'none'
                  con_none.style.display = 'block'
               }
            }
         })
      }

      // hapus buku yang telah dipilih di table
      $(document).on('click', '.hapusBuku', function(){
         overlay.style.display = 'flex'
         let id = $(this).attr('id')
         let kode_buku = $(this).attr('kode-buku')
         let kode_trans = $('#kode').val()

         $.ajax({
            type: 'DELETE',
            url: 'transaksi-tambah/hapus/'+id+'/'+kode_buku+'/'+kode_trans,
            success: function(){
               ambilDataBuku()
               tampilBuku()
               overlay.style.display = 'none'
               Toast.fire({
                  icon: 'success',
                  title: 'Buku berhasil dihapus'
               })
            }
         })
      })

      // lanjutkan peminjaman dengan memilih mahasiswa
      $(document).on('submit', '#lanjutkan-peminjaman', function(e){
         e.preventDefault()
         let kode = $('#kode').val()
         let formData = new FormData($('#lanjutkan-peminjaman')[0])

         let btn = document.getElementById('btn-lanjutkan')
         btn.setAttribute('disabled', true)
         let textLanjutkan = document.getElementById('text-lanjutkan')
         textLanjutkan.style.display = 'none'
         let loadingLanjutkan = document.getElementById('loadingLanjutkan')
         loadingLanjutkan.style.display = 'block'
         let form = $('#lanjutkan-peminjaman')
         form.find('.form-text').remove()


         $.ajax({
            type: 'POST',
            url: 'transaksi-tambah/update/'+kode,
            data: formData,
            contentType: false,
            processData: false,
            success: function(){
               Toast.fire({
                  icon: 'success',
                  title: 'Transaksi berhasil ditambahkan'
               })
               setTimeout(() => {
                  window.location.replace('transaksi')
               }, 1500)
            },
            error: function(xhr){
               var res = xhr.responseJSON;
               if($.isEmptyObject(res) == false){
                  $.each(res.errors, function(key, value){
                     $('#' + key)
                        .closest('.form-group')
                        .append("<div class='form-text text-danger'>" + value + "</div>")
                        textLanjutkan.style.display = 'block'
                        loadingLanjutkan.style.display = 'none'
                        btn.removeAttribute('disabled', false)
                  })
               }
            }
         })
      })
   })
</script>
@endpush