@extends('templates/template1')

@section('konten')
<div class="row">
   <div class="col-md mt-4">
      <div class="d-flex justify-content-between">
         <div>
            <h6 class="judul-card">Laporan Harian</h6>
         </div>
         <div>
            <a href="{{ url('dashboard') }}" class="btn btn-sm btn-dark text-white" data-bs-toggle="tooltip" data-bs-placement="left" title="Kembali"><i class="fas fa-arrow-left"></i></a>
            <a href="{{ url('laporan-harian/excel') }}" class="btn btn-sm btn-success text-white" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Export to Excel">Excel</a>
            <a href="{{ url('laporan-harian/pdf') }}" target="_blank" style="background-color:brown;" class="btn btn-sm text-white" data-bs-toggle="tooltip" data-bs-placement="right" title="Export to PDF">Pdf</a>
         </div>
      </div>
      <div class="card card-edited">
         <div class="card-body">
            <h5 style="text-align:center;margin-bottom:20px;">Laporan harian tanggal {{ $tanggal }}</h5>
            <table id="example" class="table table-sm table-striped" style="width:100%">
               <thead class="thead-edited">
                  <tr>
                     <th>No</th>
                     <th>Kode Transaksi</th>
                     <th>Nama</th>
                     <th>Tgl Peminjaman</th>
                     <th>Tgl Pengembalian</th>
                     <th>Jumlah</th>
                  </tr>
               </thead>
            </table>
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
      $('#example').DataTable({
         serverSide: true,
         responsive: true,
         ajax: {
            url: 'laporan-harian'
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
            {data: 'jumlah', name: 'jumlah'},
         ],
      })
      overlay.style.display = 'none'
   })
</script>
@endpush