<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
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
	$kode	= $secu->injection(@$_GET['key']);
	$read	= $conn->prepare("SELECT tfkk.*,
										o.nama_out,
                                        o.resmi_out,
										-- c.kode_tfk,
										-- c.total_tfk,
										-- a.nomor_faktur,
										-- c.kode_tfk,
										tfkk.nomor, 
										tfkk.tanggal_faktur
									FROM
										finance tfkk
									LEFT JOIN outlet o ON
										tfkk.nama_outlet = o.id_out
									-- LEFT JOIN transaksi_faktur c ON 
									-- 	tfkk.nomor_faktur = c.id_tfk
									-- LEFT JOIN adminz a ON
									-- 	tfkk.created_by = a.id_adm
										WHERE tfkk.id_finance=:kode");
	$read->bindParam(':kode', $kode, PDO::PARAM_STR);
	$read->execute();
	$view	= $read->fetch(PDO::FETCH_ASSOC);
	//$limit	= $date->oprPeriode("Y-m-d", "+$view[top_odi] DAY", $view['tgl_tfk']);
?>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Untitled Document</title>
        <link href="<?php echo($data->sistem('url_sis')."/config/css/laporan.css"); ?>" rel="stylesheet">
		<style type="text/css" media="print">
          @page { size: portrait; }
        </style>
    </head>


    <body>
		<div>
			<div align="right" style="font-size:10px;"><?php echo($data->sistem('pt_sis')); ?></div>
        	<div style="float:left;  font-size:16px; marging-left:px; border:solid 2px #666666; padding-right:90px; padding-left:90px; padding-top:20px; padding-bottom:20px;" >KWITANSI</div>
        	<div align="right" style="font-size:10px;"><?php echo($data->sistem('alamat_sis')); ?></div>
        	<div align="right" style="font-size:10px;">PHONE <?php echo($data->sistem('telp_sis')); ?></div>
        	<div align="right" style="font-size:10px;">NPWP : <?php echo($data->sistem('npwp_sis')); ?></div>
        	<div align="right" style="font-size:10px;">IZIN PBF : <?php echo($data->sistem('pbf_sis')); ?></div>
        </div>
    	<br />
        <br />
    

		<div style="text-align:center; font-weight:bold; margin-bottom:20px;"></div>

		<?php

			$nomor	= 1;
			$subtot = 0;
			$master	= $conn->prepare("SELECT tfkk.*,
						o.nama_out,
						d.kode_tfk,
						d.total_tfk,
						d.po_tfk,
						d.tgl_tfk,
						-- a.nomor_faktur,
						d.kode_tfk,
						tfkk.nomor,
						tfkk.tanggal_faktur,
						tfkk.keterangan
					FROM
						finance tfkk
					LEFT JOIN outlet o ON
						tfkk.nama_outlet = o.id_out
					LEFT JOIN finance_detail c ON 
						tfkk.id_finance = c.id_finance
					LEFT JOIN transaksi_faktur d ON 
						d.id_tfk = c.no_kwitansi
					-- LEFT JOIN adminz a ON
					-- 	tfkk.created_by = a.id_adm
						WHERE tfkk.id_finance=:kode");
			$master->bindParam(':kode', $kode, PDO::PARAM_STR);
			$master->execute();
			while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
				$subtot	+= $hasil['total_tfk'];
				
				// $stotal	+= $subtot;
		?>
		<?php
				$nomor++;
            	}
		?>

        <table  style="margin-right:10px; margin-right:auto ">
        
        	<tr>
                
            	<td>Nomor</td>
            	<td><center></center></td>
            	<td>: <?php echo($view['nomor']); ?></td>
            </tr>
			
			<tr>
            	<td> </td>
            	<!-- <td><center></center></td> -->
            	<td> </td>
            </tr>
			<tr>
            	<td> </td>
            	<!-- <td><center></center></td> -->
            	<td> </td>
            </tr>
			
			<tr>
            	<td> </td>
            	<!-- <td><center></center></td> -->
            	<td> </td>
            </tr>
			<tr>
            	<td> </td>
            	<!-- <td><center></center></td> -->
            	<td> </td>
            </tr>
            <tr>
            <td> </td>
                <!-- <td>Received Form </td> -->
            	<td><center></center></td>
            	<td></td>
            </tr>

        	<tr>
            	<td><u>Telah Terima Dari<u> </td>
                <!-- <td>Received Form </td> -->
            	<td><center></center></td>
            	<td>: <?php echo($view['resmi_out']); ?></td>
            </tr>
            <td><i>Received Form</i> </td>
            	<td><center></center></td>
            	<td></td>
            </tr>
			<tr>
            	<td> </td>
            	<!-- <td><center></center></td> -->
            	<td> </td>
            </tr>
			<tr>
            	<td> </td>
            	<!-- <td><center></center></td> -->
            	<td> </td>
            </tr>
			
			<tr>
            	<td> </td>
            	<!-- <td><center></center></td> -->
            	<td> </td>
            </tr>
			<tr>
            	<td> </td>
            	<!-- <td><center></center></td> -->
            	<td> </td>
            </tr>
            <tr>
            <td> </td>
                <!-- <td>Received Form </td> -->
            	<td><center></center></td>
            	<td></td>
            </tr>

            <tr>
            <td> </td>
                <!-- <td>Received Form </td> -->
            	<td><center></center></td>
            	<td></td>
            </tr>
            <tr>
            	<td><u>Sejumlah Uang<u> </td>
            	<td><center></center></td>
            	<td>: Rp. <?php echo($data->angka($subtot)); ?></td>
            </tr>
			
            <tr>
            	<td><i>Amount Received </i></td>
            	<td><center></center></td>
            	<td></td>
            </tr>
			<tr>
            	<td> </td>
            	<!-- <td><center></center></td> -->
            	<td> </td>
            </tr>
			<tr>
            	<td> </td>
            	<!-- <td><center></center></td> -->
            	<td> </td>
            </tr>
			
			<tr>
            	<td> </td>
            	<!-- <td><center></center></td> -->
            	<td> </td>
            </tr>
			<tr>
            	<td> </td>
            	<!-- <td><center></center></td> -->
            	<td> </td>
            </tr>
            <tr>
            <td> </td>
                <!-- <td>Received Form </td> -->
            	<td><center></center></td>
            	<td></td>
            </tr>

            <tr>
            <td> </td>
                <!-- <td>Received Form </td> -->
            	<td><center></center></td>
            	<td></td>
            </tr>
            <tr>
                 <td><u>Terbilang </td>
            	<td><center></center></td>
            	<td><b><i>: ## <?php echo($data->terbilang($subtot)); ?> ##</td>
            </tr>
			<tr>
            	<td><i>Amount In Words</i> </td>
            	<td><center></center></td>
            	<td></td>
            </tr>
			<tr>
            	<td> </td>
            	<!-- <td><center></center></td> -->
            	<td> </td>
            </tr>
			<tr>
            	<td> </td>
            	<!-- <td><center></center></td> -->
            	<td> </td>
            </tr>
			
			<tr>
            	<td> </td>
            	<!-- <td><center></center></td> -->
            	<td> </td>
            </tr>
			<tr>
            	<td> </td>
            	<!-- <td><center></center></td> -->
            	<td> </td>
            </tr>
            <tr>
            <td> </td>
                <!-- <td>Received Form </td> -->
            	<td><center></center></td>
            	<td></td>
            </tr>

            <tr>
            <td> </td>
                <!-- <td>Received Form </td> -->
            	<td><center></center></td>
            	<td></td>
            </tr>

            <tr>
            	<td><u>Untuk Pembayaran</u> </td>
            	<td><center></center></td>
            	<td>: </td>
            </tr>
			<tr>
            	<td><i>In Payment For</i></td>
            	<td><center></center></td>
            	<td> </td>
            </tr>

			<tr>
            	<td> </td>
            	<!-- <td><center></center></td> -->
            	<td> </td>
            </tr>
			<tr>
            	<td> </td>
            	<!-- <td><center></center></td> -->
            	<td> </td>
            </tr>
			
			<tr>
            	<td> </td>
            	<!-- <td><center></center></td> -->
            	<td> </td>
            </tr>
			<tr>
            	<td> </td>
            	<!-- <td><center></center></td> -->
            	<td> </td>
            </tr>
            <tr>
            <td> </td>
                <!-- <td>Received Form </td> -->
            	<td><center></center></td>
            	<td></td>
            </tr>

            <tr>
            <td> </td>
                <!-- <td>Received Form </td> -->
            	<td><center></center></td>
            	<td></td>
            </tr>
			<tr>
            	<td><u> Keterangan  </td>
            	<td><center></center></td>
            	<td>: <?php echo($view['keterangan']); ?></td>
            </tr>
			<tr>
            	<td><i> Details  </td>
            	<td><center></center></td>
            	<td></td>
            </tr>


        </table>
		
		<p></p>
    	<table class="tabel" style="border:solid 1px #666666; text-align:center; font-weight:bold; margin-top:10px;  padding:5px; font-size:12px;" >
            <thead>
			<td><center><b>Nomor Faktur<center></td>
			<td><center><b>Nominal<center></td>


			</thead>
			<tbody>
            <?php

				$nomor	= 1;
                $subtot = 0;
				$master	= $conn->prepare("SELECT tfkk.*,
							o.nama_out,
							d.kode_tfk,
							d.total_tfk,
							d.po_tfk,
							d.tgl_tfk,
							-- a.nomor_faktur,
							d.kode_tfk,
							tfkk.nomor,
							tfkk.tanggal_faktur
						FROM
							finance tfkk
						LEFT JOIN outlet o ON
							tfkk.nama_outlet = o.id_out
						LEFT JOIN finance_detail c ON 
							tfkk.id_finance = c.id_finance
						LEFT JOIN transaksi_faktur d ON 
							d.id_tfk = c.no_kwitansi
						-- LEFT JOIN adminz a ON
						-- 	tfkk.created_by = a.id_adm
							WHERE tfkk.id_finance=:kode");
				$master->bindParam(':kode', $kode, PDO::PARAM_STR);
				$master->execute();
				while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
					$subtot	+= $hasil['total_tfk'];
					
					// $stotal	+= $subtot;
			?>
            <tr>
                
            	<td><center><?php echo($hasil['kode_tfk']); ?><center</td>
			
            	<td><center style="float:right;"><?php echo($data->angka($hasil['total_tfk'])); ?></center></td>
            </tr>
			<!-- <tr>				
            	<td align="right"><center style="float:right;"><?php echo($data->angka($subtot)); ?></span></td>
            </tr>
           -->
			<?php
				$nomor++;
            	}
			?>
            </tbody>
        </table>
    	<table class="tabel"  style="min-height:30px; border:solid 1px #666666; text-align:center; font-weight:bold; padding:5px; font-size:12px;"  >
			<thead>
				<tr>
					<td>TOTAL</td>
						<td align="left"><center style="float:right;"><?php echo($data->angka($subtot)); ?></span></td>	
				</tr>
			</thead>
		</table>


		<br>
		
		<div>
			<table style="margin-left:450px ;margin-right:auto">
				<tr>
					<td><center>Jakarta, <?php echo($date->tgl_indo($view['tanggal_faktur'])); ?><center</td>
					<td><center></center></td>
				</tr>
				
				<tr>
					<td> </td>
					<!-- <td>Received Form </td> -->
					<td><center></center></td>
					<td></td>
				</tr>
				<tr>
					<td> </td>
					<!-- <td>Received Form </td> -->
					<td><center></center></td>
					<td></td>
				</tr>
				<tr>
					<td> </td>
					<!-- <td>Received Form </td> -->
					<td><center></center></td>
					<td></td>
				</tr>
				<tr>
					<td> </td>
					<!-- <td>Received Form </td> -->
					<td><center></center></td>
					<td></td>
				</tr>
				<tr>
					<td> </td>
					<!-- <td>Received Form </td> -->
					<td><center></center></td>
					<td></td>
				</tr>
				<tr>
					<td> </td>
					<!-- <td>Received Form </td> -->
					<td><center></center></td>
					<td></td>
				</tr><tr>
					<td> </td>
					<!-- <td>Received Form </td> -->
					<td><center></center></td>
					<td></td>
				</tr><tr>
					<td> </td>
					<!-- <td>Received Form </td> -->
					<td><center></center></td>
					<td></td>
				</tr><tr>
					<td> </td>
					<!-- <td>Received Form </td> -->
					<td><center></center></td>
					<td></td>
				</tr><tr>
					<td> </td>
					<!-- <td>Received Form </td> -->
					<td><center></center></td>
					<td></td>
				</tr><tr>
					<td> </td>
					<!-- <td>Received Form </td> -->
					<td><center></center></td>
					<td></td>
				</tr><tr>
					<td> </td>
					<!-- <td>Received Form </td> -->
					<td><center></center></td>
					<td></td>
				</tr>
				<tr>
					<td> </td>
					<!-- <td>Received Form </td> -->
					<td><center></center></td>
					<td></td>
				</tr>
				<tr>
					<td> </td>
					<!-- <td>Received Form </td> -->
					<td><center></center></td>
					<td></td>
				</tr>
				<tr>
					<td> </td>
					<!-- <td>Received Form </td> -->
					<td><center></center></td>
					<td></td>
				</tr>
				<tr>
					<td> </td>
					<!-- <td>Received Form </td> -->
					<td><center></center></td>
					<td></td>
				</tr>
				<tr>
					<td> </td>
					<!-- <td>Received Form </td> -->
					<td><center></center></td>
					<td></td>
				</tr>
				<tr>
					<td> </td>
					<!-- <td>Received Form </td> -->
					<td><center></center></td>
					<td></td>
				</tr>
				<tr>
					<td> </td>
					<!-- <td>Received Form </td> -->
					<td><center></center></td>
					<td></td>
				</tr>
				<tr>
					<td> </td>
					<!-- <td>Received Form </td> -->
					<td><center></center></td>
					<td></td>
				</tr>
				<tr>
					<td> </td>
					<!-- <td>Received Form </td> -->
					<td><center></center></td>
					<td></td>
				</tr>
				<tr>
					<td> </td>
					<!-- <td>Received Form </td> -->
					<td><center></center></td>
					<td></td>
				</tr>
				<tr>
					<td> </td>
					<!-- <td>Received Form </td> -->
					<td><center></center></td>
					<td></td>
				</tr>
				<tr>
					<td> </td>
					<!-- <td>Received Form </td> -->
					<td><center></center></td>
					<td></td>
				</tr>
				<tr>
					<td><u><b>Saputra Pratama </td>
					<!-- <td><center>Finance</center></td> -->
				</tr>
				<tr>
					<td><b>Finance </td>
					<!-- <td><center>Finance</center></td> -->
				</tr>
			</table>
		<!-- <div style="min-height:30px; height:50; border:solid 1px #666666; text-align:center; font-weight:bold; margin-top:10px; padding:5px; font-size:12px;">Terbilang : # <?php echo($data->terbilang($subtot)); ?> Rupiah #</div> -->
		</div>
		<!-- <div style="height:auto; border:solid 1px #666666; text-align:left; margin-top:10px; padding:5px; font-size:14px;">
					<div style="margin-left:5px; margin-top:10px;">Pembayaran dapat dilakukan dengan cara melakukan transfer ke :</div>
                	<div style="margin-left:25px; margin-top:5px;">BANK <?php echo($data->sistem('bank_sis')); ?></div>
                	<div style="margin-left:25px; margin-top:5px;"><?php echo($data->sistem('norek_sis')); ?></div>
                	<div style="margin-left:25px; margin-top:5px;">An. <?php echo($data->sistem('anam_sis')); ?></div>
         </div> -->
		<br />
        
        
        <!-- <footer>
         
                <div style="float:left; font-size:60px;"><img src="<?php echo("../../../berkas/sistem/".$data->sistem('logo_sis')); ?>" height="70" width="100" /></div>
                <div align="right" style="font-size:10px;"><?php echo($data->sistem('pt_sis')); ?></div>
                <div align="right" style="font-size:10px;"><?php echo($data->sistem('alamat_sis')); ?></div>
                <div align="right" style="font-size:10px;">PHONE <?php echo($data->sistem('telp_sis')); ?></div>
                <div align="right" style="font-size:10px;">NPWP : <?php echo($data->sistem('npwp_sis')); ?></div>
                <div align="right" style="font-size:10px;">IZIN PBF : <?php echo($data->sistem('pbf_sis')); ?></div>
            
        </footer> -->
            <script type="text/javascript">window.print();</script>
    </body>
    
    
    
<?php } ?>
</html>
    