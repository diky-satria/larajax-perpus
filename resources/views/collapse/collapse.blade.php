@extends('templates/template1')

@section('konten')
<div class="row">
   <div class="col-md mt-4">
      <div class="d-flex justify-content-between">
         <div>
            <h6 class="judul-card">Transaksi Collapse</h6>
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
                     <th>Kode Transaksi</th>
                     <th>Petugas</th>
                     <th>Jumlah</th>
                     <th>Opsi</th>
                  </tr>
               </thead>
               <tbody id="tbody-data">

               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
<!-- modal detail collapse -->
<div class="modal fade" id="modal-detailCollapse" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-detailCollapseLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-detailCollapseLabel">Detail Collapse</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" id="btn-clo-mod-col" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <div class="row">
            <div class="col-md">
               <table class="table table-sm">
                  <tr>
                     <th>Kode Transaksi</th>
                     <td>:</td>
                     <td id="kode_transaksi"></td>
                  </tr>
                  <tr>
                     <th>Tgl Peminjaman</th>
                     <td>:</td>
                     <td id="tgl_peminjaman"></td>
                  </tr>
                  <tr>
                     <th>Tgl Pengembalian</th>
                     <td>:</td>
                     <td id="tgl_pengembalian"></td>
                  </tr>
                  <tr>
                     <th>Petugas</th>
                     <td>:</td>
                     <td id="petugas"></td>
                  </tr>
               </table>
            </div>
         </div>
         <div class="row">
            <div class="col-md">
               <table class="table table-sm table-striped">
                  <thead class="thead-edited">
                     <tr>
                        <th>No</th>
                        <th>Kode Buku</th>
                        <th>Judul</th>
                        <th>Lokasi</th>
                     </tr>
                  </thead>
                  <tbody id="tbody-buku">
                     
                  </tbody>
               </table>
            </div>
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
         </div>
         <!-- akhir tombol -->

      </div>
    </div>
  </div>
</div>
<!-- akhir modal detail collapse -->
@endsection

@push('js')
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>
<script>
   let overlay = document.getElementById('overlay-container')
   overlay.style.display = 'flex'
   $(document).ready(function(){
      // ambil data transaksi collapse
      ambilData()
      function ambilData(){
         let tbody = $('#tbody-data')
         tbody.find('tr').remove()

         let no = 0
         $.ajax({
            type: 'GET',
            url: 'collapse/ambil',
            success: function(response){
               $.each(response.transaksi, function(key, value){
                  no++
                  $('#tbody-data').append('<tr>\
                                       <td>'+no+'</td>\
                                       <td>'+value.kode_transaksi+'</td>\
                                       <td>'+value.petugas+'</td>\
                                       <td>'+value.jumlah+'</td>\
                                       <td>\
                                          <button class="btn btn-sm btn-info ms-1 lihat-tran-col" title="Lihat" data-bs-toggle="modal" data-bs-target="#modal-detailCollapse" id="'+value.id+'"><i class="fas fa-eye"></i></button>\
                                          <button class="btn btn-sm btn-danger ms-1 kembalikan-tran-col" title="kembalikan" id="'+value.id+'"><i class="fas fa-trash-alt"></i></button>\
                                       </td>\
                                    </tr>')
               })
               $('#example').DataTable()
               overlay.style.display = 'none'
            }
         })
      }

      // tutup modal detail
      $(document).on('click', '#btn-clo-mod-col', function(){
         $('#kode_transaksi').html('')
         $('#tgl_peminjaman').html('')
         $('#tgl_pengembalian').html('')
         $('#petugas').html('')
         let tbody = $('#tbody-buku')
         tbody.find('tr').remove()
      })

      // detail data collapse
      detail_collapse()
      function detail_collapse(){
         $(document).on('click', '.lihat-tran-col', function(){
            let wait = document.getElementById('wait')
            wait.style.display = 'block'
            let id = $(this).attr('id')
            let no = 0
   
            $.ajax({
               type: 'GET',
               url: 'collapse/detail/' + id,
               success: function(response){
                  $('#kode_transaksi').append(response.transaksi.kode)
                  $('#tgl_peminjaman').append(response.transaksi.tgl_peminjaman)
                  $('#tgl_pengembalian').append(response.transaksi.tgl_pengembalian)
                  $('#petugas').append(response.transaksi.petugas)
   
                  $.each(response.buku, function(key, value){
                     no++
                     $('#tbody-buku').append('<tr>\
                                                <td>'+no+'</td>\
                                                <td>'+value.kode_buku+'</td>\
                                                <td>'+value.judul+'</td>\
                                                <td>'+value.lokasi+'</td>\
                                             </tr>')
                  })
                  wait.style.display = 'none'
               }
            })
         })
      }

      // ajax token setup
      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      })

      // kembalikan buku 
      $(document).on('click', '.kembalikan-tran-col', function(e){
         e.preventDefault()
         overlay.style.display = 'flex'
         let id = $(this).attr('id')

         $.ajax({
            type: 'POST',
            url: 'collapse/kembalikan/'+id,
            success: function(){
               $('#example').DataTable().destroy()
               ambilData()
               overlay.style.display = 'none'
               Toast.fire({
                  icon: 'success',
                  title: 'Buku berhasil dikembalikan'
               })
            }
         })
      })
   })
</script>
@endpush