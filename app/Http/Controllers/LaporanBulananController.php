<?php

namespace App\Http\Controllers;

use datatables;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanBulananExport;
use PDF;

class LaporanBulananController extends Controller
{
    public function index()
    {
        $from = request('from');
        $to = request('to');
        
        date_default_timezone_set('Asia/Jakarta');
        if($from && $to){
            $data = Transaksi::whereBetween('tgl_peminjaman', [$from, $to])->where('status', '!=', 0)->orderBy('id', 'DESC')->get();
            $awal_tanggal = $from;
            $sampai_tanggal = $to;
        }else{
            $data = Transaksi::whereBetween('tgl_peminjaman', [now()->firstOfMonth(), now()])->where('status', '!=', 0)->orderBy('id', 'DESC')->get();
            $awal_tanggal = now()->firstOfMonth()->format('Y-m-d');
            $sampai_tanggal = now()->format('Y-m-d');
        }

        return view('laporan.bulanan', [
            'awal_tanggal' => $awal_tanggal,
            'sampai_tanggal' => $sampai_tanggal,
            'data' => $data
        ]);
    }

    public function exportExcel()
    {
        $from = request('from');
        $to = request('to');
        return Excel::download(new LaporanBulananExport($from, $to), 'Laporan bulanan.xlsx');
    }

    public function exportPdf()
    {
        $awal_tanggal = request('from');
        $sampai_tanggal = request('to');
        $data = Transaksi::whereBetween('tgl_peminjaman', [$awal_tanggal, $sampai_tanggal])->where('status', '!=', 0)->orderBy('id', 'DESC')->get();

        $pdf = PDF::loadView('exports.laporan_bulanan_pdf', [
            'data' => $data,
            'awal_tanggal' => $awal_tanggal,
            'sampai_tanggal' => $sampai_tanggal
        ]);
        return $pdf->stream('Laporan bulanan.pdf');
    }
}
