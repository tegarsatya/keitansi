<?php
	error_reporting(0);
    require_once('../../config/connection/connection.php');
	require_once('../../config/connection/security.php');
	require_once('../../config/function/data.php');
	$secu	= new Security;
	$base	= new DB;
	$data	= new Data;
    $conn	= $base->open();
	$admin	= $secu->injection(@$_COOKIE['adminkuy']);
	$kunci	= $secu->injection(@$_COOKIE['kuncikuy']);
	$catat	= date('Y-m-d H:i:s');
	$act	= $secu->injection(@$_GET['act']);
	$secu->validadmin($admin, $kunci);
	if($secu->validadmin($admin, $kunci)==false){
		//header('location:'.$data->sistem('url_sis').'/signout');
		
	} else {
		switch($act){
			case "input":
				$kode	    = $data->basecode('FNC', 3, 'id_finance', 'finance');	
                $nomorf     = $secu->injection($_POST['nomor']);
                $nomorfak   = $secu->injection($_POST['nomor_faktur']);
                $nama	    = $secu->injection($_POST['nama_outlet']);
                $tgl        = $secu->injection($_POST['tanggal_faktur']);
				$nomorfakl  = $secu->injection($_POST['nomor_faktur_lagi']);
                // $        = $secu->injection($_POST['tanggal_faktur']);
				$save	= $conn->prepare("INSERT INTO finance VALUES(:kode, :nomorf, :nomorfak, :nama, :tgl, :nomorfakl, :catat, :admin, :catat, :admin)");
				$save->bindParam(":kode", $kode, PDO::PARAM_STR);
                $save->bindParam(":nomorf", $nomorf, PDO::PARAM_STR);
                $save->bindParam(":nomorfak", $nomorfak, PDO::PARAM_STR);
                // $save->bindParam(":nama", $nama, PDO::PARAM_STR);
				$save->bindParam(":nama", $nama, PDO::PARAM_STR);
                $save->bindParam(":tgl", $tgl, PDO::PARAM_STR);
				$save->bindParam(":nomorfakl", $nomorfakl, PDO::PARAM_STR);
				$save->bindParam(":catat", $catat, PDO::PARAM_STR);
				$save->bindParam(":admin", $admin, PDO::PARAM_STR);
				$save->bindParam(":catat", $catat, PDO::PARAM_STR);
				$save->bindParam(":admin", $admin, PDO::PARAM_STR);
				$save->execute();
				// 	var_dump($save);
				// exit();
				//RIWAYAT
				$riwayat= $conn->query("INSERT INTO riwayat VALUES('', '$kode', 'finance', 'Create', 'Input Tuker Faktur', '$catat', '$admin')");
				$hasil	= ($save==true) ? "success" : "error";
				// var_dump($hasil);
				// exit();
			    echo($hasil);
			break;
			// case "update":
			// 	$uniq	= $secu->injection($_POST['keycode']);
			// 	$kode	= base64_decode($uniq);
			// 	$nama	= $secu->injection($_POST['nama']);
			// 	//EDIT
			// 	$edit	= $conn->prepare("UPDATE cabang SET nama_cabang=:nama, updated_at=:catat, updated_by=:admin WHERE id_cabang=:kode");
			// 	$edit->bindParam(":kode", $kode, PDO::PARAM_STR);
			// 	$edit->bindParam(":nama", $nama, PDO::PARAM_STR);
			// 	$edit->bindParam(":catat", $catat, PDO::PARAM_STR);
			// 	$edit->bindParam(":admin", $admin, PDO::PARAM_STR);
			// 	$edit->execute();
			// 	//RIWAYAT
			// 	$riwayat= $conn->query("INSERT INTO riwayat VALUES('', '$kode', 'Cabang', 'Update', '', '$catat', '$admin')");
			// 	if($edit==true){
			// 		setcookie('info', 'success', time() + 5, '/');
			// 		setcookie('pesan', 'Data cabang berhasil diupdate.', time() + 5, '/');
			// 	} else {
			// 		setcookie('info', 'danger', time() + 5, '/');
			// 		setcookie('pesan', 'Data cabang gagal diupdate.', time() + 5, '/');
			// 	}
			// break;
			// case "delete":
			// 	$uniq	= $secu->injection($_POST['keycode']);
			// 	$kode	= base64_decode($uniq);
			// 	//REMOVE
			// 	$remove	= $conn->prepare("DELETE FROM cabang WHERE id_cabang=:kode");
			// 	$remove->bindParam(":kode", $kode, PDO::PARAM_STR);
			// 	$remove->execute();
			// 	//RIWAYAT
			// 	$riwayat= $conn->query("INSERT INTO riwayat VALUES('', '$kode', 'Cabang', 'Delete', '', '$catat', '$admin')");
			// 	if($remove==true){
			// 		setcookie('info', 'success', time() + 5, '/');
			// 		setcookie('pesan', 'Data cabang berhasil dihapus.', time() + 5, '/');
			// 	} else {
			// 		setcookie('info', 'danger', time() + 5, '/');
			// 		setcookie('pesan', 'Data cabang gagal dihapus.', time() + 5, '/');
			// 	}
			// break;
		}
	}
	$conn	= $base->close();
	// echo($url);
?>