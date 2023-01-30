<?php
	error_reporting(0);
	require_once('../../config/connection/connection.php');
	require_once('../../config/connection/security.php');
	require_once('../../config/function/data.php');
	$secu	= new Security;
	$base	= new DB;
	$data	= new Data;
	$conn	= $base->open();
	$catat	= date('Y-m-d H:i:s');
	$act	= $secu->injection(@$_GET['act']);
	$admin	= $secu->injection(@$_COOKIE['adminkuy']);
	$kunci	= $secu->injection(@$_COOKIE['kuncikuy']);
	// $menu	= $secu->injection(@$_POST['namamenu']);
	$secu->validadmin($admin, $kunci);
	if($secu->validadmin($admin, $kunci)==false){
		//header('location:'.$data->sistem('url_sis').'/signout');
		// $url	= 'signout';
	} else {
		switch($act){
			case "input":
				$kode	               = $data->basecode('RTK', 3, 'id_rute', 'rute');
				$nama	               = $secu->injection($_POST['nama']);
                $rute_satu     	       = $secu->injection($_POST['rute_satu']);
                $rute_dua     	       = $secu->injection($_POST['rute_dua']);
                $rute_tiga             = $secu->injection($_POST['rute_tiga']);
                $rute_empat            = $secu->injection($_POST['rute_empat']);
                $rute_lima             = $secu->injection($_POST['rute_lima']);
                $rute_enam             = $secu->injection($_POST['rute_enam']);
                $rute_tujuh            = $secu->injection($_POST['rute_tujuh']);
                $rute_delapan          = $secu->injection($_POST['rute_delapan']);
                $rute_sembilan         = $secu->injection($_POST['rute_sembilan']);
                $rute_sepuluh          = $secu->injection($_POST['rute_sepuluh']);
                $rute_sebelas          = $secu->injection($_POST['rute_sebelas']);
                $rute_duabelas         = $secu->injection($_POST['rute_duabelas']);
                $rute_tigabelas        = $secu->injection($_POST['rute_tigabelas']);
                $tgl                   = $secu->injection($_POST['tanggal_kirim']);
				$save	= $conn->prepare("INSERT INTO rute VALUES(:kode, :nama, :rute_satu, :rute_dua, :rute_tiga, :rute_empat, :rute_lima, :rute_enam, :rute_tujuh, :rute_delapan, :rute_sembilan, :rute_sepuluh, :rute_sebelas, :rute_duabelas, :rute_tigabelas, :tgl, :catat, :admin, :catat, :admin)");
				$save->bindParam(":kode", $kode, PDO::PARAM_STR);
				$save->bindParam(":nama", $nama, PDO::PARAM_STR);
                $save->bindParam(":rute_satu", $rute_satu, PDO::PARAM_STR);
                $save->bindParam(":rute_dua", $rute_dua, PDO::PARAM_STR);
                $save->bindParam(":rute_tiga", $rute_tiga, PDO::PARAM_STR);
                $save->bindParam(":rute_empat", $rute_empat, PDO::PARAM_STR);
                $save->bindParam(":rute_lima", $rute_lima, PDO::PARAM_STR);
                $save->bindParam(":rute_enam", $rute_enam, PDO::PARAM_STR);
                $save->bindParam(":rute_tujuh", $rute_tujuh, PDO::PARAM_STR);
                $save->bindParam(":rute_delapan", $rute_delapan, PDO::PARAM_STR);
                $save->bindParam(":rute_sembilan", $rute_sembilan, PDO::PARAM_STR);
                $save->bindParam(":rute_sepuluh", $rute_sepuluh, PDO::PARAM_STR);
                $save->bindParam(":rute_sebelas", $rute_sepuluh, PDO::PARAM_STR);
                $save->bindParam(":rute_duabelas", $rute_duabelas, PDO::PARAM_STR);
                $save->bindParam(":rute_tigabelas", $rute_tigabelas, PDO::PARAM_STR);
                $save->bindParam(":tanggal_kirim", $tgl, PDO::PARAM_STR);
				$save->bindParam(":catat", $catat, PDO::PARAM_STR);
				$save->bindParam(":admin", $admin, PDO::PARAM_STR);
				$save->execute();
				$riwayat= $conn->query("INSERT INTO riwayat VALUES('', '$kode', 'Rute', 'Create', 'Input Data Rute', '$catat', '$admin')");

				$hasil	= ($save==true) ? "success" : "error";
				// var_dump($hasil);
				// exit();
				echo($hasil);
			break;
			// case "update":
			// 	$uniq	= $secu->injection($_POST['keycode']);
			// 	$kode	= base64_decode($uniq);
			// 	$nama	= $secu->injection($_POST['gudang']);
			// 	//EDIT
			// 	$edit	= $conn->prepare("UPDATE gudang SET gudang=:gudang, updated_at=:catat, updated_by=:admin WHERE id_gudang=:kode");
			// 	$edit->bindParam(":kode", $kode, PDO::PARAM_STR);
			// 	$edit->bindParam(":gudang", $nama, PDO::PARAM_STR);
			// 	$edit->bindParam(":catat", $catat, PDO::PARAM_STR);
			// 	$edit->bindParam(":admin", $admin, PDO::PARAM_STR);
			// 	$edit->execute();
			// 	//RIWAYAT
			// 	$riwayat= $conn->query("INSERT INTO riwayat VALUES('', '$kode', 'gudang', 'Update', '', '$catat', '$admin')");
			// 	if($edit==true){
			// 		setcookie('info', 'success', time() + 5, '/');
			// 		setcookie('pesan', 'Data gudang berhasil diupdate.', time() + 5, '/');
			// 	} else {
			// 		setcookie('info', 'danger', time() + 5, '/');
			// 		setcookie('pesan', 'Data gudang gagal diupdate.', time() + 5, '/');
			// 	}
			// break;
			// case "delete":
			// 	$uniq	= $secu->injection($_POST['keycode']);
			// 	$kode	= base64_decode($uniq);
			// 	//REMOVE
			// 	$remove	= $conn->prepare("DELETE FROM gudang WHERE id_gudang=:kode");
			// 	$remove->bindParam(":kode", $kode, PDO::PARAM_STR);
			// 	$remove->execute();
			// 	//RIWAYAT
			// 	$riwayat= $conn->query("INSERT INTO riwayat VALUES('', '$kode', 'gudang', 'Delete', '', '$catat', '$admin')");
			// 	if($remove==true){
			// 		setcookie('info', 'success', time() + 5, '/');
			// 		setcookie('pesan', 'Data gudang berhasil dihapus.', time() + 5, '/');
			// 	} else {
			// 		setcookie('info', 'danger', time() + 5, '/');
			// 		setcookie('pesan', 'Data gudang gagal dihapus.', time() + 5, '/');
			// 	}
			// break;
		}
		
	}
	$conn	= $base->close();
	// echo($url);
?>