<h5 style="text-align:center;">Laporan tanggal {{ $awal_tanggal }} sampai {{ $sampai_tanggal }}</h5>
<table>
   <thead>
      <tr>
         <th>No</th>
         <th>Kode Transaksi</th>
         <th>Nama</th>
         <th>Tgl Peminjaman</th>
         <th>Tgl Pengembaian</th>
         <th>Jumlah</th>
      </tr>
   </thead>
   <tbody>
   @foreach($data as $d)
      <tr>
         <td>{{ $loop->iteration }}</td>
         <td>{{ $d->kode }}</td>
         <td>{{ $d->mahasiswa->nama }}</td>
         <th>{{ $d->tgl_peminjaman }}</th>
         <th>{{ $d->tgl_pengembalian }}</th>
         <th>{{ $d->jumlah }}</th>
      </tr>
   @endforeach
   </tbody>
</table>