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
		<!-- <div>
        	<div style="float:left; font-size:60px;"><img src="<?php echo("../../../berkas/sistem/".$data->sistem('logo_sis')); ?>" height="70" width="100" /></div>
            <div align="right" style="font-size:10px;"><?php echo($data->sistem('pt_sis')); ?></div>
        	<div align="right" style="font-size:10px;"><?php echo($data->sistem('alamat_sis')); ?></div>
        	<div align="right" style="font-size:10px;">PHONE <?php echo($data->sistem('telp_sis')); ?></div>
        	<div align="right" style="font-size:10px;">NPWP : <?php echo($data->sistem('npwp_sis')); ?></div>
        	<div align="right" style="font-size:10px;">IZIN PBF : <?php echo($data->sistem('pbf_sis')); ?></div>
        </div> -->
    	<br />
        <br />
        <br />
        <br />
        <br />
		<!-- <hr class="garis" /> -->
        <div style="text-align:center; font-weight:bold; margin:10px 0px 10px 0px;">KWITANSI</div>
        <br />
        <br />
       
        <!-- <div style="text-align:center; font-weight:bold;"><?php echo($date->tgl_indo($view['tanggal_faktur'])); ?></div>
        <div style="text-align:center; font-weight:bold; margin:10px 0px 10px 0px;"><?php echo($view['nama_out']); ?></div> -->

		<div style="text-align:center; font-weight:bold; margin-bottom:20px;"></div>

        <table  style="margin-right:100px; margin-right:auto">
        	<!-- <tr>
            	<td>Kepada Yth,</td>
            	<td></td>
            	<td></td>
            </tr> -->
        	<tr>
                
            	<td>Nomor</td>
            	<td><center></center></td>
            	<td width="32%">: <?php echo($view['nomor']); ?></td>
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
            <td>Received Form </td>
                <!-- <td>Received Form </td> -->
            	<td><center></center></td>
            	<td>: <?php echo($view['nama_out']); ?></td>
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
            	<td></td>
            </tr>

            <tr>
            	<td>Amount Received </td>
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
            	<td>Untuk Pembayaran </td>
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
            	<td><b> Faktur Nomor : </td>
            	<!-- <td><center></center></td> -->
            	<td> </td>
            </tr>


        </table>
		
		<p></p>
    	<table style="margin-left:120px; margin-right:auto">
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
							tfkk.nomor
						FROM
							finance tfkk
						LEFT JOIN outlet o ON
							tfkk.nama_outlet = o.id_out
						LEFT JOIN finance_detail c ON 
							tfkk.nomor = c.id_finance
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
				<TD></TD>
				<TD></TD>
				<TD></TD>
            	<td><center>Rp. </center></td>
			
			
		
			
            	<td><center> <?php echo($data->angka($hasil['total_tfk'])); ?></center></td>
            </tr>
          
				<?php
				$nomor++;
            	}
			?>
            </tbody>
        </table>

		<br>
		<br>
	
		<table style="margin-left:0px ;margin-right:auto">
			<tr>
            	<td><center><b>Total Faktur<center</td>
            	<td><center></center></td>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				
	
				
				
			
	
			
            	<td><b>Rp. </span><?php echo($data->angka($subtot)); ?></td>
            </tr>
		</table>
		<br>
		<div style="width:45%; display:inline-block; float:left;">
				<div align="right">
                <table width="80%" style="font-size:12px;">
                   
                </table>
                </div>
            	<div style="min-height:30px; height:auto; border:solid 1px #666666; text-align:center; font-weight:bold; margin-top:10px; padding:5px; font-size:12px;">Terbilang : # <?php echo($data->terbilang($subtot)); ?> Rupiah #</div>
            	<!--<div style="min-height:30px; height:auto; border:solid 1px #666666; text-align:center; font-weight:bold; margin-top:10px; line-height:25px; font-size:12px;">Terbilang : # <?php //echo($data->terbilang($gtotal)); ?> Rupiah #</div>-->
            	
         </div>
		<div>
			<table style="margin-left:400px ;margin-right:auto">
				<tr>
					<td><center>Jakarta, <?php echo($date->getHari(date('Y-m-d')).', '.$date->tgl_indo(date('Y-m-d'))); ?><center</td>
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
		<div style="height:auto; border:solid 1px #666666; text-align:left; margin-top:10px; padding:5px; font-size:14px;">
					<div style="margin-left:5px; margin-top:10px;">Pembayaran dapat dilakukan dengan cara melakukan transfer ke :</div>
                	<div style="margin-left:25px; margin-top:5px;">BANK <?php echo($data->sistem('bank_sis')); ?></div>
                	<div style="margin-left:25px; margin-top:5px;"><?php echo($data->sistem('norek_sis')); ?></div>
                	<div style="margin-left:25px; margin-top:5px;">An. <?php echo($data->sistem('anam_sis')); ?></div>
         </div>
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
    