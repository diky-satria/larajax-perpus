<div class="laporan_harian_pdf">
    <h3 style="text-align:center;">Laporan harian tanggal {{ $tanggal }}</h3>
    <table style="width:100%;border-collapse: collapse;">
       <thead>
          <tr style="background-color:rgb(0, 119, 255);color:white;">
             <th style="padding:7px 0;">No</th>
             <th style="padding:7px 0;">Kode Transaksi</th>
             <th style="padding:7px 0;">Nama</th>
             <th style="padding:7px 0;">Tgl Peminjaman</th>
             <th style="padding:7px 0;">Tgl Pengembalian</th>
             <th style="padding:7px 0;">Jumlah</th>
          </tr>
       </thead>
       <tbody>
       @foreach($data as $t)
          <tr>
             <td style="border-bottom:1px solid black;text-align:center;padding:4px 0;">{{ $loop->iteration }}</td>
             <td style="border-bottom:1px solid black;padding:4px 0;">{{ $t->kode }}</td>
             <td style="border-bottom:1px solid black;padding:4px 0;">{{ $t->mahasiswa->nama }}</td>
             <th style="border-bottom:1px solid black;padding:4px 0;">{{ $t->tgl_peminjaman }}</th>
             <th style="border-bottom:1px solid black;padding:4px 0;">{{ $t->tgl_pengembalian }}</th>
             <th style="border-bottom:1px solid black;padding:4px 0;">{{ $t->jumlah }}</th>
          </tr>
       @endforeach
       </tbody>
    </table>
</div>