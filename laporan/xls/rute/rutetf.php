<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
	header("Content-Type: application/force-download");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Laporan"); 
	header("content-disposition:attachment; filename=rute_pengiriman_barang.xls");
	require_once('../../../config/connection/connection.php');
	require_once('../../../config/connection/security.php');
	require_once('../../../config/function/data.php');
	require_once('../../../config/function/date.php');
	$secu	= new Security;
	$base	= new DB;
	$data	= new Data;
	$date	= new Date;
	$tanggal= date('Y-m-d');
	$admin	= $secu->injection(@$_COOKIE['adminkuy']);
	$kunci	= $secu->injection(@$_COOKIE['kuncikuy']);
	$secu->validadmin($admin, $kunci);
	if($secu->validadmin($admin, $kunci)==false){ header('location:'.$data->sistem('url_sis').'/signout'); } else {
	$conn	= $base->open();
	$cari	= $secu->injection(@$_GET['key']);
	$search	= $data->cekcari($cari, '-', ' ');
	$pecah	= explode('_', $cari);
	// $outlet	= empty($pecah[0]) ? "" : "AND B.id_rute='$pecah[0]'"; 
	// $produk	= empty($pecah[1]) ? "" : "AND A.id_rute='$pecah[1]'"; 
?>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Data Pengiriman Barang</title>
    </head>


    <body>
		<table>
        	<tr>
            	<th colspan="26">Rute Pengiriman Barang dan Tuker Faktur</th>
            </tr>
        
            <tr>
            	<td colspan="26"></td>
            </tr>
        </table>
    	<table border="1">
        	<thead>
            	<tr>
                    <th><center>NO</center></th>
                    <th>Nama Pengirim</th>
                    <th>Tuker Faktur Nomor</th>
					<!-- <th>Nomor Faktur Tuker Faktur</th> -->
                    <th>Tanggal</th>
				</tr>
    		</thead>
            <tbody>
			<?php
				$nomor	= 1;
				$master	= $conn->prepare("SELECT A.id_rute, A.nama_pengirim, A.tanggal, B.tuker_faktur, B.id_rute FROM rute AS A LEFT JOIN rute_tuker_faktur AS B ON A.id_rute=B.id_rute WHERE A.id_rute!='' ORDER BY A.id_rute DESC, A.tanggal DESC");
				// $master->bindParam(':tanggal', $tanggal, PDO::PARAM_STR);
				$master->execute();
				while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
			?>
            	<tr>
                	<td><center><?php echo($nomor); ?></center></td>
                	<td><?php echo($hasil['nama_pengirim']); ?></td>
                	<td><?php echo($hasil['tuker_faktur']); ?></td>
					<!-- <td><?php echo($hasil['tuker_faktur']); ?></td> -->
                	<td><?php echo($hasil['tanggal']); ?></td>
                	
                </tr>
			<?php
				$nomor++;
            	}
			?>
            </tbody>
        </table>
		<?php $conn	= $base->close(); ?>

    </body>
<?php } ?>
</html>
