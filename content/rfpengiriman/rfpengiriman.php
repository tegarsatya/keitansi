<div class="content-header">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Menu</a></li>
                <li class="breadcrumb-item"><a href="#">Report</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tukar Faktur Kurir</li>
            </ol>
        </nav>
        <h4 class="content-title">Tukar Faktur Kurir</h4>
    </div>
</div>
<?php
	$cari	= $secu->injection(@$_GET['cari']);
?>
<input type="hidden" name="caridata" id="caridata" value="<?php echo($cari); ?>" readonly="readonly" />
<input type="hidden" name="halaman" id="halaman" value="0" readonly="readonly" />
<input type="hidden" name="maximal" id="maximal" value="15" readonly="readonly" />
<div class="content-body">
	<div class="row mg-b-10">
        <div class="col-sm-6">
			<a href="#modal1" onclick="<?php echo("caridata('carirfpengiriman', 'rfpengiriman', '$cari')"); ?>" data-toggle="modal"><button class="btn btn-warning btn-pill btn-xs"><i class="fa fa-search"></i> Cari Data</button></a>
			<a href="<?php echo("$sistem/rfpengiriman"); ?>" title="Refresh"><button class="btn btn-info btn-pill btn-xs"><i class="fa fa-spinner"></i> Refresh</button></a>
        	<?php echo(($data->akses($admin, $menu, 'A.read_status')==='Active') ? '<a target="_blank" href="'.$sistem.'/laporan/xps/rfpengiriman/rfpengiriman.php?key='.$cari.'" title="XPS"><button class="btn btn-danger btn-pill btn-xs"><i class="fa fa-print"></i> XPS</button></a>' : ''); ?>
        	<?php echo(($data->akses($admin, $menu, 'A.read_status')==='Active') ? '<a target="_blank" href="'.$sistem.'/laporan/xls/rfpengiriman/rfpengiriman.php?key='.$cari.'" title="XLS"><button class="btn btn-success btn-pill btn-xs"><i class="fa fa-print"></i> XLS</button></a>' : ''); ?>
        </div>
        <div class="col-sm-6">
			<span class="badge badge-pill badge-danger"><i class="fa fa-search"></i> Search : <?php echo(@$pecah[0]." | Periode I : ".@$pecah[1]." | Periode II : ".@$pecah[2]); ?></span>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mg-b-0">
            <thead>
                <tr>
                    <th><center>#</center></th>
                    <th>No. Faktur</th>
                    <th>Tgl. Tuker Faktur</th>
                    <th>Name Outlet</th>
                    <th>Nama Kurir</th>
                    <th>Tanggal Tuker faktur</th>
                     <th>Keterangan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="isitabel"></tbody>
        </table>
        <div class="mg-t-10">
            <nav aria-label="Page navigation example">
                <ul class="pagination pagination-circle mg-b-0" id="paginasi"></ul>
            </nav>
		</div>
    </div>
</div>