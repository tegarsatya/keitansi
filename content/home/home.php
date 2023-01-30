<div class="content-header">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </nav>
        <h4 class="content-title">Dashboard</h4>
    </div>
</div>
<?php
	$tahun	= date('Y');
	$tiga	= date("Y", strtotime("-2 Year", strtotime($tahun)));
	$tanggal= date('Y-m-d');
	$bulan1	= date('Y-m');
	$bulan2	= date("Y-m", strtotime("-1 Month", strtotime($bulan1)));
	$sumary	= $conn->query("SELECT SUM(total_tfk) AS total FROM transaksi_faktur WHERE YEAR(tgl_tfk)='$tahun'")->fetch(PDO::FETCH_ASSOC);
	$viewse	= $conn->query("SELECT COUNT(B.id_pro) AS total FROM(SELECT id_pro, SUM(sisa_psd) AS jumlah FROM produk_stokdetail GROUP BY id_pro) AS A LEFT JOIN produk AS B ON A.id_pro=B.id_pro LEFT JOIN kategori_produk AS C ON B.id_kpr=C.id_kpr LEFT JOIN satuan_produk AS D ON B.id_spr=D.id_spr WHERE A.jumlah<=B.minstok_pro")->fetch(PDO::FETCH_ASSOC);
	$viewed	= $conn->query("SELECT COUNT(id_psd) AS total FROM produk_stokdetail WHERE TIMESTAMPDIFF(DAY, '$tanggal', tgl_expired)<=".$data->sistem('limit_expired')." OR TIMESTAMPDIFF(DAY, tgl_expired, '$tanggal')>0")->fetch(PDO::FETCH_ASSOC);
	$viewin	= $conn->query("SELECT COUNT(id_tre) AS total FROM transaksi_receive WHERE status_tre!='Lunas' AND (TIMESTAMPDIFF(DAY, '$tanggal', tgl_limit)<=".$data->sistem('limit_supplier')." OR TIMESTAMPDIFF(DAY, tgl_limit, '$tanggal')>0)")->fetch(PDO::FETCH_ASSOC);
	$viewout= $conn->query("SELECT COUNT(id_tfk) AS total FROM transaksi_faktur WHERE status_tfk!='Lunas' AND (TIMESTAMPDIFF(DAY, '$tanggal', tgl_limit)<=".$data->sistem('limit_outlet')." OR TIMESTAMPDIFF(DAY, tgl_limit, '$tanggal')>0)")->fetch(PDO::FETCH_ASSOC);
	$viewsiz= $conn->query("SELECT COUNT(A.id_out) AS total FROM outlet AS A INNER JOIN outlet_legal AS B ON A.id_out=B.id_out INNER JOIN kategori_legal AS C ON B.id_klg=C.id_klg WHERE C.id_klg='KLG01' AND TIMESTAMPDIFF(MONTH, '$tanggal', B.expired_ole)<=C.parameter_klg")->fetch(PDO::FETCH_ASSOC);
	$viewspa= $conn->query("SELECT COUNT(A.id_out) AS total FROM outlet AS A INNER JOIN outlet_legal AS B ON A.id_out=B.id_out INNER JOIN kategori_legal AS C ON B.id_klg=C.id_klg WHERE C.id_klg='KLG02' AND TIMESTAMPDIFF(MONTH, '$tanggal', B.expired_ole)<=C.parameter_klg")->fetch(PDO::FETCH_ASSOC);
	$nietgl	= $conn->query("SELECT COUNT(id_pro) AS total FROM produk WHERE TIMESTAMPDIFF(DAY, '$tanggal', tgl_nie)<=".$data->sistem('limit_expired')." OR TIMESTAMPDIFF(DAY, tgl_nie, '$tanggal')>0")->fetch(PDO::FETCH_ASSOC);


?>
 <div class="signin-sidebar-body">

                    <div class="signin-form">
                        <div class="form-group d-flex mg-b-0">
                            <a href="<?php echo($data->sistem('url_sis').'/pengiriman'); ?>" class="btn btn-info btn-uppercase flex-fill" >Input Faktur Pengiriman barang</a>
                        </div>
                        <div class="form-group d-flex mg-b-0">
                            <a href="<?php echo($data->sistem('url_sis').'/fpengiriman'); ?>" class="btn btn-info btn-uppercase flex-fill" >Input Tuker Faktur</a>
                        </div>
                    </div>
                   
</div>
<script type="text/javascript" src="<?php echo("$sistem/highcart/js/jquery.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo("$sistem/highcart/js/highcharts.js"); ?>"></script>
<script type="text/javascript">
var chart = new Highcharts.Chart({
	chart: {
		renderTo: 'container', //letakan grafik di div id container
		//Type grafik, anda bisa ganti menjadi area,bar,column dan bar
		type: 'line',  
		marginRight: 130,
		marginBottom: 25
	},
	title: {
		text: '<?php echo("GRAFIK TRANSAKSI PENJUALAN"); ?>',
		x: -20 //center
	},
	subtitle: {
		text: '<?php echo("SEPANJANG TAHUN $tiga - $tahun"); ?>',
		x: -20
	},
	xAxis: { //X axis menampilkan data bulan 
		categories: ['Januari','Febuari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember']
	},
	yAxis: {
		title: {  //label yAxis
			text: 'Jumlah Penjualan'
		},
		plotLines: [{
			value: 0,
			width: 1,
			color: '#808080' //warna dari grafik line
		}]
	},
	tooltip: { 
	//fungsi tooltip, ini opsional, kegunaan dari fungsi ini 
	//akan menampikan data di titik tertentu di grafik saat mouseover
		formatter: function() {
				return '<b>'+ this.series.name +'</b><br/>'+
				this.x +': Rp. '+ titik(this.y) +',-';
		}
	},
	legend: {
		layout: 'vertical',
		align: 'right',
		verticalAlign: 'top',
		x: -10,
		y: 100,
		borderWidth: 0
	},
	//series adalah data yang akan dibuatkan grafiknya,

	series: [
	<?php while($tiga<=$tahun){ ?>
	{ 
		name: '<?php echo($tiga); ?>',
		
		data: [
		<?php
			$rbulan			= $conn->prepare("SELECT id_mbu FROM master_bulan ORDER BY id_mbu ASC");
			$rbulan->execute();
			while($vbulan	= $rbulan->fetch(PDO::FETCH_ASSOC)){
					$jual	= $data->jumlahjual($tiga, $vbulan['id_mbu']) * 1;
					echo("$jual,");
			}
		?>
		]
	},
	<?php $tiga++; } ?>
	]
});
</script>