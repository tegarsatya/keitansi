<?php
	require_once('../../config/connection/connection.php');
	require_once('../../config/connection/security.php');
	require_once('../../config/function/data.php');
	require_once('../../config/function/paging.php');
	$base	= new DB;
	$secu	= new Security;
	$data	= new Data;
	$paging	= new Paging;
	$conn	= $base->open();
    $sistem	= $data->sistem('url_sis');
	//ACCESS DATA
	$admin	= $secu->injection(@$_COOKIE['adminkuy']);
	$kunci	= $secu->injection(@$_COOKIE['kuncikuy']);
	$level	= $secu->injection(@$_COOKIE['jeniskuy']);
	$valid	= $secu->validadmin($admin, $kunci);
	//POST DATA
	$cari	= $secu->injection(@$_GET['caridata']);
	$page	= $secu->injection(@$_GET['halaman']);
	$maxi	= $secu->injection(@$_GET['maximal']);
	$menu	= $secu->injection(@$_GET['menudata']);
	$mulai	= ($page>1) ? (($page * $maxi) - $maxi) : 0;
	//READ DATA
	if($valid==false){
		$tabel	= '<tr><td colspan="6">Session login anda habis...</td></tr>';
		$navi	= '';
	} else {
		$whereClause = '';
		$jumlah	= 0;
		$navi	= '';
		if ($cari != '') {
			$pecah	= explode('_', $cari);
			$cari1	= @$pecah[0];
			$cari2	= @$pecah[1];
			$whereClause = " WHERE tfkk.id_rute = '$cari1' AND o.nama_adm LIKE '%$cari2%' ";
		}
		$tabel	= '';
		$no		= $mulai;
		$qJumlah = "SELECT
						COUNT(id_rute) AS total
					FROM
						rute tfkk
					LEFT JOIN adminz o ON
						tfkk.id_rute = o.id_adm
					$whereClause";
		$jumlah	= $conn->query($qJumlah)->fetch(PDO::FETCH_ASSOC);
		$qMaster = "SELECT
						tfkk.*,
						o.nama_adm,
                        tfkk.tanggal
						-- tfkk.tanggal_faktur
					FROM
                        rute tfkk
					LEFT JOIN adminz o ON
						tfkk.nama_pengirim = o.id_adm
					-- LEFT JOIN transaksi_faktur c ON 
				  	-- 	tfkk.nomor_faktur = c.id_tfk
					-- LEFT JOIN adminz a ON
					-- 	tfkk.created_by = a.id_adm
		$whereClause
					ORDER BY
						tfkk.created_at DESC
					LIMIT $mulai,$maxi";
		$master	= $conn->prepare($qMaster);
		$master->execute();
		while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
			$no++; 
            $uniq	= base64_encode($hasil['id_rute']);
			$edit	= ($data->akses($admin, $menu, 'A.update_status')==='Active') ? '<a href="'.$data->sistem('url_sis').'/rute/e/'.$hasil['id_rute'].'"><span class="badge badge-info"><i class="fa fa-edit"></i></span></a>' : '';
            // $view	= ($data->akses($admin, $menu, 'A.read_status')==='Active') ? '<a target="_blank" href="'.$sistem.'/laporan/xps/finance/kwitansi.php?key='.$hasil['id_finance'].'" title="Cetak SJ"><span class="badge badge-warning"><i class="fa fa-truck"></i></span></a> <a target="_blank" href="'.$sistem.'/laporan/xps/finance/finance.php?key='.$hasil['id_finance'].'" title="Cetak Tanda Terima"><span class="badge badge-success"><i class="fa fa-print"></i></span></a>' : '';
			$delete	= ($data->akses($admin, $menu, 'A.delete_status')==='Active') ? ' <a href="#modal1" onclick="crud(\'rute\', \'delete\', \''.$hasil['id_rute'].'\')" data-toggle="modal"><span class="badge badge-danger"><i class="fa fa-trash"></i></span></a>' : '';

			$tabel	.= '<tr><td><center>'.$no.'</center></td><td>'.$hasil['nama_adm'].'</td><td>'.$hasil['tanggal'].'</td><td>'.$delete.$edit.'</td></tr>';
		}
		$navi	= $paging->myPaging($menu, $jumlah['total'], $maxi, $page);
	}
	$conn	= $base->close();
	$json	= array("tabel" => $tabel, "halaman" => $page, "paginasi" => $navi);
	http_response_code(200);
	header('Access-Control-Allow-Origin: *');
	header("Content-type: application/json; charset=utf-8");
	//header('Content-type: text/html; charset=UTF-8');
	echo(json_encode($json));
?>