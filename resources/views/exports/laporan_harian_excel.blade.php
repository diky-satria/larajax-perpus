<h5 style="text-align:center;">Laporan harian tanggal {{ $tanggal }}</h5>
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
   @foreach($transaksi as $t)
      <tr>
         <td>{{ $loop->iteration }}</td>
         <td>{{ $t->kode }}</td>
         <td>{{ $t->mahasiswa->nama }}</td>
         <th>{{ $t->tgl_peminjaman }}</th>
         <th>{{ $t->tgl_pengembalian }}</th>
         <th>{{ $t->jumlah }}</th>
      </tr>
   @endforeach
   </tbody>
</table>