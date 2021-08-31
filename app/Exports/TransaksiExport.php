<?php

namespace App\Exports;

use App\Models\Transaksi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TransaksiExport implements FromView
{
    public function view(): View
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d');
        $transaksi = Transaksi::where('tgl_peminjaman', $tanggal)->orderBy('id', 'DESC')->get();

        return view('exports.laporan_harian_excel', [
            'transaksi' => $transaksi,
            'tanggal' => $tanggal
        ]);
    }
}
