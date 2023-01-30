<?php
	require_once('../../config/connection/connection.php');
	require_once('../../config/connection/security.php');
	require_once('../../config/function/data.php');
	$secu	= new Security;
	$base	= new DB;
	$data	= new Data;
	$catat	= date('Y-m-d H:i:s');
	$admin	= $secu->injection(@$_COOKIE['adminkuy']);
	$kunci	= $secu->injection(@$_COOKIE['kuncikuy']);
	$act	= $secu->injection(@$_GET['act']);
	$secu->validadmin($admin, $kunci);
	if ($secu->validadmin($admin, $kunci)==false) {
		header('location:'.$data->sistem('url_sis').'/signout');
	} else {
		$conn	= $base->open();
		$id_tfk	= $secu->injection($_POST['id_tfk']);
		$id_out	= $secu->injection($_POST['id_out']);
		$tgl_tfk	= $secu->injection($_POST['tgl_tfk']);
		$ket_tfkk	= $secu->injection($_POST['ket_tfkk']);
		$status_tfkk	= $secu->injection($_POST['status_tfkk']);
		//SAVE
		$save	= $conn->prepare("INSERT INTO tuker_faktur VALUES('', :id_out, :id_tfk, :tgl_tfk, :status_tfkk, :ket_tfkk, :catat, :admin, :catat, :admin)");
		$save->bindParam(':id_out', $id_out, PDO::PARAM_STR);
		$save->bindParam(':id_tfk', $id_tfk, PDO::PARAM_STR);
		$save->bindParam(':tgl_tfk', $tgl_tfk, PDO::PARAM_STR);
		$save->bindParam(':status_tfkk', $status_tfkk, PDO::PARAM_STR);
		$save->bindParam(':ket_tfkk', $ket_tfkk, PDO::PARAM_STR);
		$save->bindParam(':catat', $catat, PDO::PARAM_STR);
		$save->bindParam(':admin', $admin, PDO::PARAM_STR);
		$save->execute();			
		$hasil	= ($save==true) ? "success" : "error";
		echo($hasil);
	}
	$conn	= $base->close();
?>