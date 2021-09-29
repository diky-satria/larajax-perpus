<?php 

	function kode_random($length){ 
		$data = "123456";
		$string = "PJ-";

		for ($i=0; $i < $length ; $i++) { 
			$pos = rand(0, strlen($data) -1);
			$string .= $data[$pos];
		}
		return $string;
	}

	function terlambat($tgl_kembali, $tgl_deadline){
		$selisih = strtotime($tgl_kembali) - strtotime($tgl_deadline);

		$selisih = $selisih/86400;

		if($selisih>=1){
			$hasil = floor($selisih);
		}else{
			$hasil = 0;
		}

		return $hasil;
	}

	function format_rupiah($value){
		return 'Rp. '.number_format($value, '0','.','.');
	}