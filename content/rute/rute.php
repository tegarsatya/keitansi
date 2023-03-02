<div class="content-header">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Menu</a></li>
                <li class="breadcrumb-item"><a href="#">Report</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pengiriman Kurir</li>
            </ol>
        </nav>
        <h4 class="content-title">Rute Pengiriman</h4>
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
            <?php echo(($data->akses($admin, $menu, 'A.create_status')==='Active') ? '<a href="'.$sistem.'/rute/i"><button class="btn btn-primary btn-pill btn-xs"><i class="fa fa-plus-circle"></i> Tambah Data</button></a>' : ''); ?>
            <a href="<?php echo("$sistem/rute"); ?>" title="Refresh"><button class="btn btn-info btn-pill btn-xs"><i class="fa fa-spinner"></i> Refresh</button></a>
			<a target="_blank" href="<?php echo($data->sistem('url_sis')."/laporan/xls/rute/rute.php?key=$cari"); ?>" title=".Pengiriman_Barang"><button class="btn btn-success btn-pill btn-xs"><i class="fa fa-print"></i>. Pengiriman_Barang</button></a>
            <a target="_blank" href="<?php echo($data->sistem('url_sis')."/laporan/xls/rute/rutetf.php?key=$cari"); ?>" title=".Pengiriman_Barang"><button class="btn btn-success btn-pill btn-xs"><i class="fa fa-print"></i>. Tuker_Faktur</button></a>

        </div>
        <!-- <div class="col-sm-6">
			<span class="badge badge-pill badge-danger"><i class="fa fa-search"></i> Search : <?php echo(@$pecah[0]." | Periode I : ".@$pecah[1]." | Periode II : ".@$pecah[2]); ?></span>
        </div> -->
    </div>
    <div class="table-responsive">
        <table class="table table-hover mg-b-0">
            <thead>
                <tr>
                    <th><center>#</center></th>
                    <th><center>Nama Kurir</center></th>
                    <!-- <th>Nama Outlet</th> -->
                    <th><center>Tanggal Pengiriman Barang Dan Tuker Faktur</center></th>
                    <!-- <th><center>Print Kwitansi & Tanda Terima</center></th> -->
                    <th><center>Detail Pengiriman Barang Dan Tuker Faktur</center></th>
                    <th><center>Action</center></th>
                    <!-- <th>Tanggal Pengiriman</th>
                    <th>Keterangan</th>
                    <th>Status</th> -->
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