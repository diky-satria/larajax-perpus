@extends('templates/template1')

@section('konten')
<div class="row">
   <div class="col-md-4">
      <div class="back-card mt-4">
         <div class="front-card front-card-peminjaman-hari-ini">
            <div class="row">
               <div class="col">
                  <h6>TRANSAKSI HARI INI</h6>
               </div>
            </div>
            <div class="row">
               <div class="col">
                  <h4 style="font-weight:bold;" id="trans-hari-ini"></h4>
               </div>
            </div>
         </div>
      </div>
      <div class="back-card mt-4">
         <div class="front-card front-card-total-transaksi">
            <div class="row">
               <div class="col">
                  <h6>TOTAL TRANSAKSI ( DIPINJAM )</h6>
               </div>
            </div>
            <div class="row">
               <div class="col">
                  <h4 style="font-weight:bold;" id="total-trans"></h4>
               </div>
            </div>
         </div>
      </div>
      <div class="back-card mt-4">
         <div class="front-card front-card-total-buku">
            <div class="row">
               <div class="col">
                  <h6>TOTAL BUKU ( DIPINJAM )</h6>
               </div>
            </div>
            <div class="row">
               <div class="col">
                  <h4 style="font-weight:bold;" id="total-buku"></h4>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-8">
      <div class="card card-trans-maha mt-4">
         <div class="card-header">
            Riwayat
         </div>
         <div class="card-body card-body-trans-maha">
            <ul class="list-group list-group-maha">
               
            </ul>
         </div>
      </div>
   </div>
</div>

<!-- modal detail -->
<div class="modal fade" id="modal-det-trans" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-det-transLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-det-transLabel">Detail</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" id="btn-close-modal-m" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <div class="row">
            <div class="col-md">
               <table class="table table-sm" id="modal-detail-m">
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
            <tbody id="tbody-buku-det">
               
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
<!-- akhir modal detail -->
@endsection

@push('js')
<script>
   let overlay = document.getElementById('overlay-container')
   overlay.style.display = 'flex'
   $(document).ready(function(){
      // ambil semua data
      $.ajax({
         type: 'GET',
         url: 'mahasiswa/data',
         success: function(response){
            $('#trans-hari-ini').append(response.trans_hari_ini)
            $('#total-trans').append(response.trans_di_pinjam)
            $('#total-buku').append(response.tot_buk_pinj)
            $.each(response.transaksi, function(key, value){
               let span = ''
               if(value.status === 1){
                  span = '<span class="badge bg-success">Dipinjam</span>'
               }else{
                  span = '<span class="badge bg-secondary">Dikembalikan</span>'
               }
               $('.list-group-maha').append('<li class="list-group-item list-group-item-maha d-flex" data-bs-toggle="modal" data-bs-target="#modal-det-trans" id="'+ value.id +'">\
                                                <div class="col">\
                                                   <h6 style="font-weight:bold;">'+ value.kode +'</h6>\
                                                   <p style="font-size:12px;line-height:6px;margin-bottom:8px;">'+ value.tgl_peminjaman +'</p>\
                                                   '+ span +'\
                                                </div>\
                                                <div class="col">\
                                                   <h6 style="font-weight:bold;float:right;">'+ value.jumlah +'</h6>\
                                                </div>\
                                             </li>')
            })
            overlay.style.display = 'none'
         }
      })

      // tutup modal detail
      $(document).on('click', '#btn-close-modal-m', function(){
         $('#kTransaksiDetail').html('')
         $('#petugasDetail').html('')
         $('#jumlahDetail').html('')
         $('#dendaDetail').html('')
      })

      // detail transaksi
      $(document).on('click', '.list-group-item-maha', function(){
         let id = $(this).attr('id')

         let waitDetail = document.getElementById('waitDetail')
         waitDetail.style.display = 'block'

         let buk = $('#tbody-buku-det')
         buk.find('tr').remove()
         
         $.ajax({
            type: 'GET',
            url: 'mahasiswa/detail/' + id,
            success: function(response){
               $('#kTransaksiDetail').append(response.detail.kode)
               $('#petugasDetail').append(response.detail.petugas)
               $('#jumlahDetail').append(response.detail.jumlah)
               if(response.detail.terlambat > 0){
                  $('#dendaDetail').append('<div style="color:red;font-weight:bold;">'+ response.detail.terlambat +' Hari | ' + response.detail.denda + '</div>')
               }else{
                  $('#dendaDetail').append('----')
               }

               let no = 0
               $.each(response.buku, function(key, value){
                  no++
                  $('#tbody-buku-det').append('<tr>\
                                                <td>'+ no +'</td>\
                                                <td>'+ value.kode_buku +'</td>\
                                                <td>'+ value.judul +'</td>\
                                             </tr>')
               })
               waitDetail.style.display = 'none'
            }
         })
      })
   })
</script>
@endpush