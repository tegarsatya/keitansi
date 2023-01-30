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
			$whereClause = " WHERE tf.status = '$cari1' AND o.nama_out LIKE '%$cari2%' ";
		}
		$tabel	= '';
		$no		= $mulai;
		$qJumlah = "SELECT
						COUNT(id_tkf_t) AS total
					FROM
						tuker_faktur tf
					LEFT JOIN outlet o ON
						tf.id_kot = o.id_out
					$whereClause";
		$jumlah	= $conn->query($qJumlah)->fetch(PDO::FETCH_ASSOC);
		$qMaster = "SELECT
						tf.*,
						o.nama_out,
						a.nama_adm,
						c.kode_tfk
					FROM
						tuker_faktur tf
					LEFT JOIN outlet o ON
						tf.id_kot = o.id_out
					LEFT JOIN transaksi_faktur c ON 
				  		tf.id_tfk = c.id_tfk
					LEFT JOIN adminz a ON
						tf.created_by = a.id_adm
					$whereClause
					ORDER BY
						tf.created_at DESC
					LIMIT $mulai,$maxi";
		$master	= $conn->prepare($qMaster);
		$master->execute();
		while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
			$no++; 
			$tabel	.= '<tr><td><center>'.$no.'</center></td><td>'.$hasil['kode_tfk'].'</td><td>'.$hasil['tanggal_tkf'].'</td><td>'.$hasil['nama_out'].'</td><td>'.$hasil['nama_adm'].'</td><td>'.$hasil['created_at'].'</td><td>'.$hasil['note'].'</td><td>'.$hasil['status'].'</td></tr>';
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