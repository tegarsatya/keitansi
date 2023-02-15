<?php
	error_reporting(0);
    require_once('../../config/connection/connection.php');
	require_once('../../config/connection/security.php');
	require_once('../../config/function/data.php');
	$secu	= new Security;
	$base	= new DB;
	$data	= new Data;
    // $conn	= $base->open();
	$admin	= $secu->injection(@$_COOKIE['adminkuy']);
	$kunci	= $secu->injection(@$_COOKIE['kuncikuy']);
	$catat	= date('Y-m-d H:i:s');
	$act	= $secu->injection(@$_GET['act']);
	$secu->validadmin($admin, $kunci);
	if($secu->validadmin($admin, $kunci)==false){
		header('location:'.$data->sistem('url_sis').'/signout');
		
	} else {
		$conn	= $base->open();
		switch($act){
			case "input":
				$id		= '';
				$kode	    = $data->basecode('FNC', 3, 'id_finance', 'finance');	
                $nomorf     = $secu->injection($_POST['nomor']);
                $nama	    = $secu->injection($_POST['nama_outlet']);
                $tgl        = $secu->injection($_POST['tanggal_faktur']);
			
				$save	= $conn->prepare("INSERT INTO finance VALUES(:kode, :nomorf, :nama, :tgl, :id, :catat, :admin, :catat, :admin)");
				$save->bindParam(":id", $id, PDO::PARAM_STR);
				$save->bindParam(":kode", $kode, PDO::PARAM_STR);
                $save->bindParam(":nomorf", $nomorf, PDO::PARAM_STR);
                // $save->bindParam(":nomorfak", $nomorfak, PDO::PARAM_STR);
                // $save->bindParam(":nama", $nama, PDO::PARAM_STR);
				$save->bindParam(":nama", $nama, PDO::PARAM_STR);
                $save->bindParam(":tgl", $tgl, PDO::PARAM_STR);
				$save->bindParam(":nokwi", $nokwi, PDO::PARAM_STR);
				$save->bindParam(":catat", $catat, PDO::PARAM_STR);
				$save->bindParam(":admin", $admin, PDO::PARAM_STR);
				$save->execute();

				$no		= 0;
				$jumlah	= count(@$_POST['nokwi']);
				while($no<$jumlah)
				{
					$nokwi	= $secu->injection(@$_POST['nokwi'][$no]);
					$ket	= $secu->injection(@$_POST['ket'][$no]);
					// Save
					$save	= $conn->prepare("INSERT INTO finance_detail VALUES(:id, :nomorf, :nokwi, :ket, :catat, :admin, :catat, :admin)");
					$save->bindParam(":id", $id, PDO::PARAM_STR);
					$save->bindParam(":nomorf", $nomorf, PDO::PARAM_STR);
					$save->bindParam(":nokwi", $nokwi, PDO::PARAM_STR);
					$save->bindParam(":ket", $ket, PDO::PARAM_STR);
					$save->bindParam(":catat", $catat, PDO::PARAM_STR);
					$save->bindParam(":admin", $admin, PDO::PARAM_STR);
				
					$save->execute();
					
				$no++;
				}
			
				//RIWAYAT
				$riwayat= $conn->query("INSERT INTO riwayat VALUES('', '$kode', 'finance', 'Create', 'Input Tuker Faktur', '$catat', '$admin')");
				$hasil	= ($save==true) ? "success" : "error";
			
			    echo($hasil);
			break;
			case "update";
				// $kode	    = $data->basecode('FNC', 3, 'id_finance', 'finance');	
				$nomorf     = $secu->injection($_POST['nomor']);
				$nama	    = $secu->injection($_POST['nama_outlet']);
				$tgl        = $secu->injection($_POST['tanggal_faktur']);
				$edit		= $conn->prepare("UPDATE finance SET nomor=:nomorf, nama_outlet=:nama, tanggal_faktur=:tgl, no_kwitansi=:nokwi,  updated_at=:catat, updated_by=:admin WHERE id_finance=:kode");
				$edit->bindParam(":kode", $kode, PDO::PARAM_STR);
				$edit->bindParam(":nomorf", $nomorf, PDO::PARAM_STR);
				$edit->bindParam(":nama", $nama, PDO::PARAM_STR);
				$edit->bindParam(":tgl", $tgl, PDO::PARAM_STR);
				$edit->bindParam(":nokwi", $nokwi, PDO::PARAM_STR);
				$edit->bindParam(":catat", $catat, PDO::PARAM_STR);
				$edit->bindParam(":admin", $admin, PDO::PARAM_STR);
				$edit->execute();
				// Hapus finance_detail
				$remove	= $conn->prepare("DELETE FROM finance_detail WHERE id_finance=:kode");
				$remove->bindParam(":kode", $kode, PDO::PARAM_STR);
				$remove->execute();

				$no		= 0;
				$jumlah	= count(@$_POST['nokwi']);
				while($no<$jumlah)
				{
					$nokwi	= $secu->injection(@$_POST['nokwi'][$no]);
					$ket	= $secu->injection(@$_POST['ket'][$no]);
					// Save
					$save	= $conn->prepare("INSERT INTO finance_detail VALUES(:id, :nomorf, :nokwi, :ket, :catat, :admin, :catat, :admin)");
					$save->bindParam(":id", $id, PDO::PARAM_STR);
					$save->bindParam(":nomorf", $nomorf, PDO::PARAM_STR);
					$save->bindParam(":nokwi", $nokwi, PDO::PARAM_STR);
					$save->bindParam(":ket", $ket, PDO::PARAM_STR);
					$save->bindParam(":catat", $catat, PDO::PARAM_STR);
					$save->bindParam(":admin", $admin, PDO::PARAM_STR);
					$save->execute();
					
				$no++;
				}
				//RIWAYAT
				$riwayat= $conn->query("INSERT INTO riwayat VALUES('', '$kode', 'Finance', 'Update', '', '$catat', '$admin')");
				$hasil	= ($edit==true) ? "success" : "error";
				echo($hasil);
			break;



			case "delete":
				$kode	= $secu->injection($_POST['keycode']);
				$dele	= $conn->prepare("DELETE A, B FROM finance AS A LEFT JOIN finance_detail AS B ON A.id_finance=B.id_finance WHERE A.id_finance=:kode");
				$dele->bindParam(":kode", $kode, PDO::PARAM_STR);
				$dele->execute();
				/*
				$dele	= $conn->prepare("DELETE FROM outlet_alamat WHERE id_out=:kode");
				$dele->bindParam(":kode", $kode, PDO::PARAM_STR);
				$dele->execute();
				$dele	= $conn->prepare("DELETE FROM outlet_diskon WHERE id_out=:kode");
				$dele->bindParam(":kode", $kode, PDO::PARAM_STR);
				$dele->execute();
				*/
				//RIWAYAT
				$riwayat= $conn->query("INSERT INTO riwayat VALUES('', '$kode', 'Finance', 'Delete', '', '$catat', '$admin')");
				$hasil	= ($dele==true) ? "success" : "error";
				echo($hasil);
			break;
		
		}
	}
	$conn	= $base->close();
	// echo($url);
?>