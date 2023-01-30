<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
	header("Content-Type: application/force-download");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Laporan"); 
	header("content-disposition:attachment; filename=inventory.xls");
	require_once('../../../config/connection/connection.php');
	require_once('../../../config/connection/security.php');
	require_once('../../../config/function/data.php');
	require_once('../../../config/function/date.php');
	$secu	= new Security;
	$base	= new DB;
	$data	= new Data;
	$date	= new Date;
	$admin	= $secu->injection(@$_COOKIE['adminkuy']);
	$kunci	= $secu->injection(@$_COOKIE['kuncikuy']);
	$secu->validadmin($admin, $kunci);
	if($secu->validadmin($admin, $kunci)==false){ header('location:'.$data->sistem('url_sis').'/signout'); } else {
	$conn	= $base->open();
	$cari	= $secu->injection(@$_GET['key']);
	$search	= $data->cekcari($cari, '-', ' ');
	$active	= 'Active';
?>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Inventory</title>
    </head>


    <body>
		<table>
        	<tr>
            	<th colspan="10">INVENTORY ANALISIS</th>
            </tr>
            <tr>
            	<td colspan="10"></td>
            </tr>
        </table>
    	<table border="1">
        	<thead>
            	<tr>
                    <th><center>#</center></th>
                    <th>NAMA PRODUK</th>
                    <th><div align="right">HARGA</div></th>
                    <th><div align="right">KUANTITAS</div></th>
                    <th>KETERANGAN</th>
					<th><div align="right">Total 1</div></th>
				</tr>
    		</thead>
            <tbody>
			<?php
				$nomor	= 1;
				$jumlah	= 0;
				$subtot	= 0;
				$stotal	= 0;
				$master	= $conn->prepare("SELECT A.no_bcode, A.tgl_expired,A.gudang, A.tgl_psd, A.sisa_psd,B.kategori_obat,B.kode_produk_jadi, B.nama_pro, B.berat_pro,B.minstok_pro, C.harga_phg, C.hargap_phg, D.nama_kpr, E.nama_spr FROM produk_stokdetail AS A LEFT JOIN produk AS B ON A.id_pro=B.id_pro LEFT JOIN produk_harga AS C ON B.id_pro=C.id_pro LEFT JOIN kategori_produk AS D ON B.id_kpr=D.id_kpr LEFT JOIN satuan_produk AS E ON B.id_spr=E.id_spr WHERE A.sisa_psd>0 AND B.nama_pro LIKE '%$search%' AND C.status_phg=:active ORDER BY B.nama_pro ASC");
				$master->bindParam(':active', $active, PDO::PARAM_STR);
				$master->execute();
				while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
					$status	= empty($hasil['sisa_psd']) ? 'Kosong' : (($hasil['sisa_psd']<50) ? 'Order Ulang' : 'Cukup');
					$subtot	= $hasil['harga_phg'] * $hasil['sisa_psd'];
					// $diskon	= ($subtot * $hasil['diskon_tfd']) / 100;
					$jumlah	+= $subtot;
					// $total += $row['total'];
			?>
                <tr>
                    <td><center><?php echo($nomor); ?></center></td>
                    <td><?php echo($hasil['nama_pro']); ?></td>
                    <td><div align="right"><?php echo($hasil['harga_phg']); ?></div></td>
                    <td><div align="right"><?php echo($hasil['sisa_psd']); ?></div></td>
                    <td><?php echo($status); ?></td>
					<td><?php echo($subtot);?></td>
                </tr>
				

			<?php
				$nomor++;
            	}
			?>
            </tbody>
			
        </table>
		<table border="1">
			<thead>
				<tr>
					<td colspan="5">TOTAL</td>
					<td><?php echo($jumlah);?></td>	
				</tr>
			</thead>
		</table>

				
    </body>
<?php } ?>
</html>
