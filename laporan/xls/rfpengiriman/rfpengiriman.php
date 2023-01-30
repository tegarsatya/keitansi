<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
	header("Content-Type: application/force-download");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Laporan"); 
	header("content-disposition:attachment; filename=report_tuker_faktur_a.xls");
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
	$cari	= $secu->injection(@$_GET['key']);
	$secu->validadmin($admin, $kunci);
	if($secu->validadmin($admin, $kunci)==false){ header('location:'.$data->sistem('url_sis').'/signout'); } else {
	$conn	= $base->open();
	$whereClause = '';
	if ($cari != '') {
		$pecah	= explode('_', $cari);
		$cari1	= @$pecah[0];
		$cari2	= @$pecah[1];
		$whereClause = " WHERE tf.status = '$cari1' AND o.nama_out LIKE '%$cari2%' ";
	}
?>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Report Tuker Faktur Kurir</title>
    </head>


    <body>
		<table>
        	<tr>
            	<th colspan="18">REPORT TUKER FAKTUR KURIR</th>
            </tr>
            <tr>
            	<td colspan="18"></td>
            </tr>
        </table>
    	<table border="1">
        	<thead>
                <tr>
                    <th><center>NO.</center></th>
                    <th>NO. FAKTUR</th>
                    <th>TGL. FAKTUR</th>
                    <th>ID. OUTLET</th>
                    <th>NAMA OUTLET</th>
                    <th>NAMA PENGINPUT</th>
                    <th>TGL. INPUT</th>
                    <th>STATUS</th>
                </tr>
    		</thead>
            <tbody>
            <?php
				$nomor	= 1;
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
											tf.created_at DESC";
				$master	= $conn->prepare($qMaster);
				$master->execute();
				while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
			?>
				<tr>
          <td><center><?php echo($nomor); ?></center></td>
          <td><center><?php echo($hasil['kode_tfk']); ?></center></td>
          <td><center><?php echo($hasil['tanggal_tkf']); ?></center></td>
          <td><center><?php echo($hasil['id_kot']); ?></center></td>
          <td><center><?php echo($hasil['nama_out']); ?></center></td>
          <td><center><?php echo($hasil['nama_adm']); ?></center></td>
					<td><center><?php echo($hasil['created_at']); ?></center></td>
					<td><center><?php echo($hasil['status']); ?></center></td>
				</tr>
			<?php $nomor++; } ?>
            </tbody>
        </table>
        <?php $conn	= $base->close(); ?>
    </body>
<?php } ?>
</html>
