@extends('templates/template1')

@section('konten')
<div class="row">
   <div class="col-md mt-4">
      <div class="d-flex justify-content-between">
         <div>
            <h6 class="judul-card">Data Transaksi</h6>
         </div>
         <div>
            <a href="{{ url('transaksi-tambah') }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="left" title="Tambah"><i class="fas fa-plus"></i></a>
         </div>
      </div>
      <div class="card card-edited">
         <div class="card-body">
            <table class="table table-sm table-striped" id="tab-tran">
               <thead class="thead-edited">
                  <tr>
                     <th>No</th>
                     <th>Kode Transkasi</th>
                     <th>Nama</th>
                     <th>Tgl Peminjaman</th>
                     <th>Tgl Pengembalian</th>
                     <th>Terlambat | Denda</th>
                     <th>Opsi</th>
                  </tr>
               </thead>
            </table>
         </div>
      </div>
   </div>
</div>
<!-- modal detail transaksi admin -->
<div class="modal fade" id="modal-detailTransaksiAdmin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-detailTransaksiAdminLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-detailTransaksiAdminLabel">Detail Transaksi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" id="btn-clo-mod-det-mah-adm" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <div class="row">
            <div class="col-md">
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
                     <th>Jurusan</th>
                     <td>:</td>
                     <td id="jurusanDetail"></td>
                  </tr>
                  <tr>
                     <th>Semester</th>
                     <td>:</td>
                     <td id="semesterDetail"></td>
                  </tr>
               </table>
            </div>
            <div class="col-md">
               <table class="table table-sm" id="modal-det-mah-adm">
                  <tr>
                     <th>Kode Transaksi</th>
                     <td>:</td>
                     <td id="kTransaksiDetail"></td>
                  </tr>
                  <tr>
                     <th>Petugas</th>
                     <td>:</td>
                     <td id="petugasDetail"></td>
                  </tr>
                  <tr>
                     <th>Jumlah</th>
                     <td>:</td>
                     <td id="jumlahDetail"></td>
                  </tr>
                  <tr>
                     <th>Terlambat | Denda</th>
                     <td>:</td>
                     <td id="dendaDetail"></td>
                  </tr>
               </table>
            </div>
         </div>
         <table class="table table-sm mt-3 table-striped">
            <thead class="thead-edited">
               <tr>
                  <th>No</th>
                  <th>Kode</th>
                  <th>Judul</th>
               </tr>
            </thead>
            <tbody id="tbody-buku">
               
            </tbody>
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
<!-- akhir modal detail transaksi admin -->
@endsection

@push('js')
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>
<script>
   let overlay = document.getElementById('overlay-container')
   overlay.style.display = 'flex'
   $(document).ready(function(){
      // ambil data transaksi
      $('#tab-tran').DataTable({
         serverSide: true,
         responsive: true,
         ajax:{
            url: 'transaksi'
         },
         columns: [
            {
               "data" : null, "sortable" : false,
               render: function(data, type, row, meta){
                  return meta.row + meta.settings._iDisplayStart + 1
               }
            },
            {data: 'kode', name: 'kode'},
            {data: 'nama', name: 'nama'},
            {data: 'tgl_peminjaman', name: 'tgl_peminjaman'},
            {data: 'tgl_pengembalian', name: 'tgl_pengembalian'},
            {data: 'denda', name: 'denda'},
            {data: 'opsi', name: 'opsi'},
         ]
      })
      overlay.style.display = 'none'

      // tutup modal detail transaksi admin
      $(document).on('click', '#btn-clo-mod-det-mah-adm', function(){
         $('#nimDetail').html('')
         $('#namaDetail').html('')
         $('#jurusanDetail').html('')
         $('#semesterDetail').html('')
         $('#kTransaksiDetail').html('')
         $('#petugasDetail').html('')
         $('#jumlahDetail').html('')
         $('#dendaDetail').html('')
      })

      // ambil data untuk modal detail transaksi admin
      $(document).on('click', '.modal-det-tran-adm', function(){
         let id = $(this).attr('id')
         let waitDetail = document.getElementById('waitDetail')
         waitDetail.style.display = 'block'

         let buku = $('#tbody-buku') 
         buku.find('tr').remove()

         $.ajax({
            type: 'GET',
            url: 'transaksi/'+id,
            success: function(response){
               $('#nimDetail').append(response.transaksi.nim)
               $('#namaDetail').append(response.transaksi.nama)
               $('#jurusanDetail').append(response.transaksi.jurusan)
               $('#semesterDetail').append(response.transaksi.semester)
               $('#kTransaksiDetail').append(response.transaksi.kode)
               $('#petugasDetail').append(response.transaksi.petugas)
               $('#jumlahDetail').append(response.transaksi.jumlah)
               if(response.transaksi.terlambat > 0){
                  $('#dendaDetail').append('<div style="color:red;font-weight:bold;">'+ response.transaksi.terlambat +' hari | '+ response.transaksi.uang_denda +'</div>')
               }else{
                  $('#dendaDetail').append('----')
               }

               let no = 0
               $.each(response.buku, function(key, value){
                  no++
                  $('#tbody-buku').append('<tr>\
                                       <td>'+ no +'</td>\
                                       <td>'+ value.kode_buku +'</td>\
                                       <td>'+ value.judul +'</td>\
                                    </tr>')
               })
               waitDetail.style.display = 'none'
            }
         })
      })

      // ajax token setup
      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      })

      // kembalikan peminjaman
      $(document).on('click', '.kembalikan', function(e){
         e.preventDefault()
         let id = $(this).attr('id')
         let kode = $(this).attr('kode')

         Swal.fire({
            title: 'Apa kamu yakin ?',
            text: "ingin mengembalikan buku dengan kode transaksi " + kode,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, lanjutkan',
            cancelButtonText: 'Kembali',
            cancelButtonColor: 'black'
            }).then((result) => {
            if (result.isConfirmed) {

               $.ajax({
                  type: 'PATCH',
                  url: 'transaksi/'+id,
                  success: function(){
                     $('#tab-tran').DataTable().ajax.reload()
                     Toast.fire({
                        icon: 'success',
                        title: 'Buku telah dikembalikan'
                     })
                  }
               })

            }
         })
      })

      // perpanjang peminjaman
      $(document).on('click', '.perpanjang', function(e){
         e.preventDefault()
         let id = $(this).attr('id')
         let kode = $(this).attr('kode')

         Swal.fire({
            title: 'Apa kamu yakin ?',
            text: "ingin memperpanjang peminjaman dengan kode transaksi " + kode,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, lanjutkan',
            cancelButtonText: 'Kembali',
            cancelButtonColor: 'black'
            }).then((result) => {
            if (result.isConfirmed) {

               $.ajax({
                  type: 'PATCH',
                  url: 'transaksi/perpanjang/'+id,
                  success: function(){
                     $('#tab-tran').DataTable().ajax.reload()
                     Toast.fire({
                        icon: 'success',
                        title: 'Peminjaman berhasil diperpanjang'
                     })
                  }
               })

            }
         })
      })
   })
</script>
@endpush