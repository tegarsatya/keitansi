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
				$kode	    = $data->basecode('RUTE', 3, 'id_rute', 'rute');	
                // $namap      = $secu->injection($_POST['nomor']);
                $nama	    = $secu->injection($_POST['nama_pengirim']);
                $tgl        = $secu->injection($_POST['tanggal']);
			
				$save	= $conn->prepare("INSERT INTO rute VALUES(:kode, :nama, :tgl, :id, :id, :id, :catat, :admin, :catat, :admin)");
				$save->bindParam(":id", $id, PDO::PARAM_STR);
				$save->bindParam(":kode", $kode, PDO::PARAM_STR);
                // $save->bindParam(":nomorf", $nomorf, PDO::PARAM_STR);
                // $save->bindParam(":nomorfak", $nomorfak, PDO::PARAM_STR);
                // $save->bindParam(":nama", $nama, PDO::PARAM_STR);
				$save->bindParam(":nama", $nama, PDO::PARAM_STR);
                $save->bindParam(":tgl", $tgl, PDO::PARAM_STR);
				$save->bindParam(":outlet", $outlet, PDO::PARAM_STR);
				$save->bindParam(":barang", $barang, PDO::PARAM_STR);
				$save->bindParam(":faktur", $faktur, PDO::PARAM_STR);
				$save->bindParam(":catat", $catat, PDO::PARAM_STR);
				$save->bindParam(":admin", $admin, PDO::PARAM_STR);
				$save->execute();

				//outlet_lengkap save
				$no		= '0';
				$jumlah	= count(@$_POST['outlet']);
				while($no<$jumlah)
				{
					$outlet	= $secu->injection(@$_POST['outlet'][$no]);
					$ket	= $secu->injection(@$_POST['ket'][$no]);
					// Save
					$save	= $conn->prepare("INSERT INTO rute_outlet VALUES(:id, :kode, :outlet,:ket, :catat, :admin, :catat, :admin)");
					$save->bindParam(":id", $id, PDO::PARAM_STR);
					$save->bindParam(":kode", $kode, PDO::PARAM_STR);
					$save->bindParam(":outlet", $outlet, PDO::PARAM_STR);
					$save->bindParam(":ket", $ket, PDO::PARAM_STR);
					$save->bindParam(":catat", $catat, PDO::PARAM_STR);
					$save->bindParam(":admin", $admin, PDO::PARAM_STR);
				
					$save->execute();
					
				$no++;
				}
				// end

				$no		= '0';
				$jumlah	= count(@$_POST['barang']);
				while($no<$jumlah)
				{
					$barang	= $secu->injection(@$_POST['barang'][$no]);
					// $ket	= $secu->injection(@$_POST['ket'][$no]);
					// Save
					$save	= $conn->prepare("INSERT INTO rute_pengiriman_barang VALUES(:id, :kode, :barang, :catat, :admin, :catat, :admin)");
					$save->bindParam(":id", $id, PDO::PARAM_STR);
					$save->bindParam(":kode", $kode, PDO::PARAM_STR);
					$save->bindParam(":barang", $barang, PDO::PARAM_STR);
					// $save->bindParam(":ket", $ket, PDO::PARAM_STR);
					$save->bindParam(":catat", $catat, PDO::PARAM_STR);
					$save->bindParam(":admin", $admin, PDO::PARAM_STR);
				
					$save->execute();
					
				$no++;
				}


				$no		= '0';
				$jumlah	= count(@$_POST['faktur']);
				while($no<$jumlah)
				{
					$faktur	= $secu->injection(@$_POST['faktur'][$no]);
					// $ket	= $secu->injection(@$_POST['ket'][$no]);
					// Save
					$save	= $conn->prepare("INSERT INTO rute_tuker_faktur VALUES(:id, :kode, :faktur, :catat, :admin, :catat, :admin)");
					$save->bindParam(":id", $id, PDO::PARAM_STR);
					$save->bindParam(":kode", $kode, PDO::PARAM_STR);
					$save->bindParam(":faktur", $faktur, PDO::PARAM_STR);
					// $save->bindParam(":ket", $ket, PDO::PARAM_STR);
					$save->bindParam(":catat", $catat, PDO::PARAM_STR);
					$save->bindParam(":admin", $admin, PDO::PARAM_STR);
				
					$save->execute();
					
				$no++;
				}
			
			
				//RIWAYAT
				$riwayat= $conn->query("INSERT INTO riwayat VALUES('', '$kode', 'Rute', 'Create', 'Input Tuker Faktur', '$catat', '$admin')");
				$hasil	= ($save==true) ? "success" : "error";
			
			    echo($hasil);
			break;


			// update
			case "update":
				// Basic
				$kode	= $secu->injection($_POST['id_rute']);
				$nama	= $secu->injection($_POST['nama_pengirim']);
				$tgl	= $secu->injection($_POST['tanggal']);
				$outlet	= $secu->injection($_POST['outlet']);
				$barang	= $secu->injection($_POST['barang']);
				$faktur	= $secu->injection($_POST['faktur']);
				
				// update rute
				$edit	= $conn->prepare("UPDATE rute SET nama=:nama_pengirim, tgl=:tanggal, outlet=:outlet, barang=:barang, faktur=:faktur, updated_at=:catat, updated_by=:admin WHERE id_rute=:kode");
				$edit->bindParam(":kode", $kode, PDO::PARAM_STR);
				$edit->bindParam(":nama", $nama, PDO::PARAM_STR);
				$edit->bindParam(":tgl", $tgl, PDO::PARAM_STR);
				$edit->bindParam(":outlet", $outlet, PDO::PARAM_STR);
				$edit->bindParam(":barang", $barang, PDO::PARAM_STR);
				$edit->bindParam(":faktur", $faktur, PDO::PARAM_STR);
				// $edit->bindParam(":kete", $kete, PDO::PARAM_STR);
				$edit->bindParam(":catat", $catat, PDO::PARAM_STR);
				$edit->bindParam(":admin", $admin, PDO::PARAM_STR);
				$edit->execute();
				
				// Hapus rute outlet
				$remove	= $conn->prepare("DELETE FROM rute_outlet WHERE id_rute=:kode");
				$remove->bindParam(":kode", $kode, PDO::PARAM_STR);
				$remove->execute();
				// Hapus rute pengiriman barang
				$remove	= $conn->prepare("DELETE FROM rute_pengiriman_barang WHERE id_rute=:kode");
				$remove->bindParam(":kode", $kode, PDO::PARAM_STR);
				$remove->execute();
				// Hapus rute tuker faktur
				$remove	= $conn->prepare("DELETE FROM rute_tuker_faktur WHERE id_rute=:kode");
				$remove->bindParam(":kode", $kode, PDO::PARAM_STR);
				$remove->execute();

				// Update rute outlet
				$no		= '0';
				$jumlah	= count(@$_POST['outlet']);
				while($no<$jumlah)
				{
					$outlet	= $secu->injection(@$_POST['outlet'][$no]);
					$ket	= $secu->injection(@$_POST['ket'][$no]);
					// Save
					$save	= $conn->prepare("INSERT INTO rute_outlet VALUES(:id, :kode, :outlet,:ket, :catat, :admin, :catat, :admin)");
					$save->bindParam(":id", $id, PDO::PARAM_STR);
					$save->bindParam(":kode", $kode, PDO::PARAM_STR);
					$save->bindParam(":outlet", $outlet, PDO::PARAM_STR);
					$save->bindParam(":ket", $ket, PDO::PARAM_STR);
					$save->bindParam(":catat", $catat, PDO::PARAM_STR);
					$save->bindParam(":admin", $admin, PDO::PARAM_STR);
				
					$save->execute();
					
				$no++;

				}

				// update rute pengiriman barang	
				$no		= '0';
				$jumlah	= count(@$_POST['barang']);
				while($no<$jumlah)
				{
					$barang	= $secu->injection(@$_POST['barang'][$no]);
					// $ket	= $secu->injection(@$_POST['ket'][$no]);
					// Save
					$save	= $conn->prepare("INSERT INTO rute_pengiriman_barang VALUES(:id, :kode, :barang, :catat, :admin, :catat, :admin)");
					$save->bindParam(":id", $id, PDO::PARAM_STR);
					$save->bindParam(":kode", $kode, PDO::PARAM_STR);
					$save->bindParam(":barang", $barang, PDO::PARAM_STR);
					// $save->bindParam(":ket", $ket, PDO::PARAM_STR);
					$save->bindParam(":catat", $catat, PDO::PARAM_STR);
					$save->bindParam(":admin", $admin, PDO::PARAM_STR);
				
					$save->execute();
					
				$no++;
				}

				// update tuker  faktur
				$no		= '0';
				$jumlah	= count(@$_POST['faktur']);
				while($no<$jumlah)
				{
					$faktur	= $secu->injection(@$_POST['faktur'][$no]);
					// $ket	= $secu->injection(@$_POST['ket'][$no]);
					// Save
					$save	= $conn->prepare("INSERT INTO rute_tuker_faktur VALUES(:id, :kode, :faktur, :catat, :admin, :catat, :admin)");
					$save->bindParam(":id", $id, PDO::PARAM_STR);
					$save->bindParam(":kode", $kode, PDO::PARAM_STR);
					$save->bindParam(":faktur", $faktur, PDO::PARAM_STR);
					// $save->bindParam(":ket", $ket, PDO::PARAM_STR);
					$save->bindParam(":catat", $catat, PDO::PARAM_STR);
					$save->bindParam(":admin", $admin, PDO::PARAM_STR);
				
					$save->execute();
					
				$no++;
				}
			
				//RIWAYAT
				$riwayat= $conn->query("INSERT INTO riwayat VALUES('', '$code', 'Rute Pengiriman Barang', 'Update', '', '$catat', '$admin')");
				$hasil	= ($edit==true) ? "success" : "error";
				echo($hasil);
			break;

			
		
		}
	}
	$conn	= $base->close();
	// echo($url);
?>