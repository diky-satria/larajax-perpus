@extends('templates/template1')

@section('konten')
<div class="row">
   <div class="col-md mt-4">
      <div class="d-flex justify-content-between">
         <div>
            <h6 class="judul-card">Laporan Bulanan</h6>
         </div>
         <div>
            <a href="{{ url('dashboard') }}" class="btn btn-sm btn-dark text-white" data-bs-toggle="tooltip" data-bs-placement="left" title="Kembali"><i class="fas fa-arrow-left"></i></a>
            <a href="{{ url('laporan-bulanan/excel?from='. $awal_tanggal .'&to='. $sampai_tanggal) }}" class="btn btn-sm btn-success text-white" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Export to Excel">Excel</a>
            <a href="{{ url('laporan-bulanan/pdf?from='. $awal_tanggal .'&to='. $sampai_tanggal) }}" target="_blank" style="background-color:brown;" class="btn btn-sm text-white" data-bs-toggle="tooltip" data-bs-placement="right" title="Export to PDF">Pdf</a>
         </div>
      </div>
      <div class="card card-edited">
         <div class="card-body">
            <div class="row mb-4">
               <div class="col-lg-7"></div>
               <div class="col-lg-5">
                  <form action="" id="form-cari" class="d-flex">
                     <input type="date" class="form-control" name="from" id="from">
                     <input type="date" class="form-control mx-1" name="to" id="to">
                     <button type="submit" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Cari"><i class="fas fa-search"></i></button>
                  </form>
               </div>
            </div>
            <div class="row">
               <div class="col-lg">
                  <h5 style="text-align:center;margin-bottom:20px;">Laporan tanggal {{ $awal_tanggal }} sampai {{ $sampai_tanggal }}</h5>
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
                     <tbody>
                        @foreach($data as $d)
                        <tr>
                           <td>{{ $loop->iteration }}</td>
                           <td>{{ $d->kode }}</td>
                           <td>{{ $d->mahasiswa->nama }}</td>
                           <td>{{ $d->tgl_peminjaman }}</td>
                           <td>{{ $d->tgl_pengembalian }}</td>
                           <td>{{ $d->jumlah }}</td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@push('js')
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function(){
      $('#example').DataTable()
    })
</script>
@endpush