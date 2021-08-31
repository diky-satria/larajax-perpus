<?php

namespace App\Http\Controllers;

use datatables;
use PDF;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Exports\TransaksiExport;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Facades\Excel;

class LaporanHarian extends Controller
{
    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d');

        $data = Transaksi::where('tgl_peminjaman', $tanggal)->where('status', '!=', 0)->orderBy('id', 'DESC')->get();

        if(request()->ajax()){
            return datatables()->of($data)
                                ->addColumn('nama', function($data){
                                    return $data->mahasiswa->nama;
                                })
                                ->rawColumns(['nama'])
                                ->make(true);
        }
        return view('laporan.harian', ['tanggal' => $tanggal]);
    }

    public function exportExcel() 
    {
        return Excel::download(new TransaksiExport, 'Laporan harian.xlsx');
    }

    public function exportPdf()
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d');
        $data = Transaksi::where('tgl_peminjaman', $tanggal)->orderBy('id', 'DESC')->get();

        $pdf = PDF::loadView('exports.laporan_harian_pdf', ['data' => $data, 'tanggal' => $tanggal]);
        return $pdf->stream('Laporan harian.pdf');
    }
}
