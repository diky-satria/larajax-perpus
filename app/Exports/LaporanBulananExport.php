<?php

namespace App\Exports;

use App\Models\Transaksi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanBulananExport implements FromView
{
    protected $from;
    protected $to;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function view(): View
    {
        date_default_timezone_set('Asia/Jakarta');

        $data = Transaksi::whereBetween('tgl_peminjaman', [$this->from, $this->to])->where('status', '!=', 0)->orderBy('id', 'DESC')->get();

        return view('exports.laporan_bulanan_excel', [
            'awal_tanggal' => $this->from,
            'sampai_tanggal' => $this->to,
            'data' => $data
        ]);
    }
}
