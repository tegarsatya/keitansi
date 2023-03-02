<div class="content-header">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">List Menu</a></li>
                <li class="breadcrumb-item active" aria-current="page">Rute Pengiriman Barang dan Tuker Faktur</li>
            </ol>
        </nav>
        <h4 class="content-title">Edit Data - Rute Pengiriman Barang</h4>
    </div>
</div>
<?php
	$kode	= $secu->injection($_GET['keycode']);
	$read	= $conn->prepare("SELECT A.id_rute, A.tanggal, A.nama_pengirim, B.id_rute, B.nama_outlet, B.ket, C.id_rute, C.barang,E.id_adm, E.nama_adm, F.id_out, F.nama_out, COUNT(B.id_r_o) AS outlet, COUNT(C.id_p_b) AS barang, COUNT(D.id_t_f) AS faktur FROM rute AS A INNER JOIN rute_outlet AS B ON A.id_rute=B.id_rute INNER JOIN rute_pengiriman_barang AS C ON A.id_rute=C.id_rute LEFT JOIN rute_tuker_faktur AS D ON A.id_rute=D.id_rute LEFT JOIN adminz AS E ON A.id_rute=E.id_adm LEFT JOIN outlet AS F ON A.id_rute=F.id_out WHERE A.id_rute=:kode GROUP BY A.id_rute");
	$read->bindParam(':kode', $kode, PDO::PARAM_STR);
	$read->execute();
	$view	= $read->fetch(PDO::FETCH_ASSOC);
?>
<div class="content-body">
    <div class="component-section no-code">
        <h5 id="section1" class="tx-semibold">Informasi Pengiriman Barang</h5>
        <!-- <p class="mg-b-25">Informasi data-data dasar outlet.</p> -->
        <input type="hidden" name="jumlout" id="jumlout" value="<?php echo($view['outlet']); ?>" readonly="readonly" />
        <input type="hidden" name="jumlpe" id="jumlpe" value="<?php echo($view['barang']); ?>" readonly="readonly" />
        <input type="hidden" name="jumlfk" id="jumlfk" value="<?php echo($view['faktur']); ?>"" readonly="readonly" /> 
        <!-- <input type="hidden" name="jumlegal" id="jumlegal" value="<?php echo($view['legal']); ?>" readonly="readonly" /> -->
        <input type="hidden" name="jumitem" id="jumitem" value="0" readonly="readonly" />
        <form id="formtransaksi" action="#" method="post" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="nmenu" id="nmenu" value="rute" readonly="readonly" />
        <input type="hidden" name="nact" id="nact" value="update" readonly="readonly" />
        <input type="hidden" name="keycode" id="keycode" value="<?php echo($kode); ?>" readonly="readonly" />
        <div class="row">
            <div class="form-group col-sm-12">
                <label>Tgl. Pengiriman  <span class="tx-danger">*</span></label>
                <input type="text" name="tanggal" class="form-control datepicker" value="<?php echo($view['tanggal']); ?>" placeholder="9999-99-99" required="required" />
            </div>
            <div class="form-group col-sm-12">
                <label>Nama Kurir <span class="tx-danger">*</span></label>
                <select name="nama_pengirim" id="nama_pengirim" class="form-control select2" onchange="" required="required">
                    <option value="">-- Pilih --</option>
                        <?php
                        $master = $conn->prepare("SELECT id_adm, nama_adm,email_adm FROM adminz ORDER BY nama_adm ASC");
                        $master->execute();
                        while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
                            $pilih	= ($hasil['id_adm']==$view['nama_pengirim']) ? 'selected="selected"' : '';
                        ?>
                    <option value="<?php echo($hasil['id_adm']); ?>"><?php echo($pilih); ?><?php echo("$hasil[nama_adm] ($hasil[email_adm])"); ?></option>
                    <?php } ?>
                </select>
            </div>
        </div><!-- row -->
		<div class="row">
            <div class="form-group col-sm-12">
                <label>Legal Outlet <span class="tx-danger">*</span></label>
				<table class="table table-hover mg-b-0">
					<thead>
						<tr>
							<th>Legal</th>
							<th>Ket.</th>
							<th>Expired Date</th>
							<th><center>#</center></th>
						</tr>
					</thead>
					<tbody id="tbllegal">
					<?php
						$no	= 1;
						$master	= $conn->prepare("SELECT id_klg, ket_ole, expired_ole FROM outlet_legal WHERE id_out=:kode");
						$master->bindParam(':kode', $kode, PDO::PARAM_STR);
						$master->execute();
						while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
					?>
                        <tr id="<?php echo("ileg$nomor"); ?>">
                            <td>
                            <select name="legal[]" class="form-control" required="required">
                                <option value="">-- Select Legal --</option>
                            <?php
                                $mlega	= $conn->prepare("SELECT id_klg, nama_klg FROM kategori_legal ORDER BY nama_klg ASC");
                                $mlega->execute();
                                while($hlega= $mlega->fetch(PDO::FETCH_ASSOC)){
									$pilih	= ($hlega['id_klg']===$hasil['id_klg']) ? 'selected="selected"' : '';
                            ?>
                                <option value="<?php echo($hlega['id_klg']); ?>" <?php echo($pilih); ?>><?php echo($hlega['nama_klg']); ?></option>
                            <?php } ?>
                            </select>
                            </td>
                            <td><input type="text" name="ketlegal[]" class="form-control" value="<?php echo($hasil['ket_ole']); ?>" placeholder="Type here..." /></td>
                            <td><input type="text" name="tgllegal[]" class="form-control fortgl" value="<?php echo($hasil['expired_ole']); ?>" placeholder="9999-99-99" /></td>
                            <td>
                            <center>
                                <a onclick="<?php echo("removeitem('jumlegal', 'ileg', $nomor)"); ?>"><span class="badge badge-danger"><i class="fa fa-times-circle"></i></span></a>
                            </center>
                            </td>
                        </tr>
                    <?php $no++; } ?>
                    </tbody>
				</table>
                <a onclick="additem('tbllegal', 'jumlegal', 'legaloutlet')"><span class="badge badge-success"><i class="fa fa-plus-circle"></i> Add Data</span></a>
            </div>
		</div>
        <div class="row">
            <div class="form-group col-sm-12">
                <label>Nama Outlet <span class="tx-danger">*</span></label>
				<table class="table table-hover mg-b-0">
					<thead>
						<tr>
							<th>Nama Outlet</th>
							<th>Ket.</th>
							<!-- <th>Expired Date</th> -->
							<th><center>Hapus</center></th>
						</tr>
					</thead>
					<tbody id="tbllegal2">
                    <?php
                            $no = 1;
                            $master	= $conn->prepare("SELECT id_r_o, id_rute, nama_outlet, ket FROM rute_outlet WHERE id_rute=:kode"); 
                            $master->bindParam(':kode', $kode, PDO::PARAM_STR);
                
                            $master->execute();
                            while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
                     ?>
                    <tr id="<?php echo("outlet$nomor"); ?>">
                        <td>
                        <select name="outlet[]"  id="outlet[]" class="form-control select2" required="required">
                            <option value="">-- Select Data Faktur --</option>
                            <?php
                                    $io	= $conn->prepare("SELECT id_out, nama_out FROM outlet ORDER BY nama_out ASC");                 
                                    $io->execute();
                                    while($po= $io->fetch(PDO::FETCH_ASSOC)){
                                        $pilih	= ($po['id_out']===$hasil['nama_outlet']) ? 'selected="selected"' : '';

                                    ?>
                                    <option value="<?php echo($po['id_out']); ?>"><?php echo($pilih); ?><?php echo($po['nama_out'] ); ?></option>
                            <?php } ?>
                        </select>
                        </td>
                        <td><input type="text" name="ket[]" class="form-control" value="<?php echo($hasil['ket']); ?>" placeholder="Type here..." /></td>
                        <!-- <td><input type="text" name="tgllegal[]" class="form-control fortgl" placeholder="9999-99-99" /></td> -->
                        <td>
                        <center>
                            <a onclick="<?php echo("removeitem('jumlout', 'outlet', $nomor)"); ?>"><span class="badge badge-danger"><i class="fa fa-times-circle"></i></span></a>
                        </center>
                        </td>
                    </tr>
                    <?php $no++; } ?>
                    </tbody>
				</table>
                <a onclick="additem('tbllegal2', 'jumlout', 'legaloutlet')"><span class="badge badge-success"><i class="fa fa-plus-circle"></i> Add Data</span></a>
            </div>
        </div>
        <!-- row -->
        <div class="clearfix mg-t-25 mg-b-25"></div>
        <div class="row">
            <div class="col-sm-12">
                <a href="<?php echo($data->sistem('url_sis').'/rute'); ?>" title="Batal">
                <button type="button" class="btn btn-secondary btn-xs">Batal</button>
				</a>
                <button type="submit" id="bsave" class="btn btn-dark btn-xs">Update</button>
            </div>
		</div>
		</form>
    </div>
</div>
