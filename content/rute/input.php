<div class="content-header">
    <div>
        <!-- <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pengiriman</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pengiriman Kurir</li>
            </ol>
        </nav> -->
        <h4 class="content-title">Input Data - Rute Pengiriman</h4>
    </div>
</div>

<!-- <input type="hidden" name="jumlegal" id="jumlegal" value="0" readonly="readonly" /> -->
<input type="hidden" name="jumlout" id="jumlout" value="0" readonly="readonly" />
<input type="hidden" name="jumlpe" id="jumlpe" value="0" readonly="readonly" />
<input type="hidden" name="jumlfk" id="jumlfk" value="0" readonly="readonly" /> 
<input type="hidden" name="jumitem" id="jumitem" value="0" readonly="readonly" />
<div class="content-body">
    <div class="component-section no-code">
            <h5 id="section1" class="tx-semibold"><?php echo($data->sistem('pt_sis')); ?></h5>
            <!-- <div style="margin-top:10px; margin-bottom:25px;">
                <div>Izin PBF No : <?php echo($data->sistem('pbf_sis')); ?></div>
                <div>NPWP No : <?php echo($data->sistem('npwp_sis')); ?></div>
                <div>Alamat : <?php echo($data->sistem('alamat_sis')); ?></div>
            </div> -->
        <form id="formtransaksi" action="#" method="post"  enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="nmenu" id="nmenu" value="rute" readonly="readonly" />
        <input type="hidden" name="nact" id="nact" value="input" readonly="readonly" />
        <div class="form-row">

        <div class="form-group col-sm-12">
                <label>Tgl. Pengiriman  <span class="tx-danger">*</span></label>
                <input type="text" name="tanggal" class="form-control datepicker" placeholder="9999-99-99" required="required" />
            </div>
            
            <div class="form-group col-sm-12">
                <label>Nama Kurir <span class="tx-danger">*</span></label>
                <select name="nama_pengirim" id="nama_pengirim" class="form-control select2" onchange="" required="required">
                    <option value="">-- Pilih --</option>
                        <?php
                        $master = $conn->prepare("SELECT id_adm, nama_adm,email_adm FROM adminz ORDER BY nama_adm ASC");
                        $master->execute();
                        while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
                        ?>
                    <option value="<?php echo($hasil['id_adm']); ?>"><?php echo("$hasil[nama_adm] ($hasil[email_adm])"); ?></option>
                    <?php } ?>
                </select>
            </div>

           
            <!-- <div class="row"> -->
  
		<!-- </div> -->
            <!-- <div class="form-group col-sm-6">
                <label>Nomor Faktur <span class="tx-danger">*</span></label>
                <select name="nomor_faktur" id="nomor_faktur" class="form-control select2" onchange="" required="required">
                <option value="">-- Pilih --</option>
                <?php
                 $master = $conn->prepare("SELECT id_tfk, kode_tfk, DATE_FORMAT(created_at, '%Y-%m-%d') FROM transaksi_faktur ORDER BY kode_tfk ASC");
                 $master->execute();
                  while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
                ?>
                <option value="<?php echo($hasil['id_tfk']); ?>"><?php echo($hasil['kode_tfk']); ?></option>              
                 <?php } ?>
                </select>
            </div>

            <div class="form-group col-sm-6">
                <label>No Faktur <span class="tx-danger">*</span></label>
                <select name="nomor_faktur_lagi" id="nomor_faktur_lagi" class="form-control select2" onchange="" required="required">
                <option value="">-- Pilih --</option>
                <?php
                 $master = $conn->prepare("SELECT id_tfk, kode_tfk, DATE_FORMAT(created_at, '%Y-%m-%d') FROM transaksi_faktur ORDER BY kode_tfk ASC");
                 $master->execute();
                  while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
                ?>
                <option value="<?php echo($hasil['id_tfk']); ?>"><?php echo($hasil['kode_tfk']); ?></option>              
                 <?php } ?>
                </select>
            </div> -->
            <!-- <div class="form-group col-sm-6"></div> -->
            
            <!-- <div class="form-group col-sm-6">
                <label>Status Pengiriman <span class="tx-danger">*</span></label>
                <select name="status_tfkk" id="status_tfkk" class="form-control select2" required="required">
                    <option value="">-- Pilih --</option>
                    <option value="Diterima">Diterima</option>
                    <option value="Dikembalikan Sebagian">Dikembalikan Sebagian</option>
                    <option value="Dikembalikan Seluruhnya">Dikembalikan Seluruhnya</option>
                </select>
            </div> -->
            
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
					<tbody id="tbllegal2"></tbody>
				</table>
                <a onclick="additem('tbllegal2', 'jumout', 'legaloutlet')"><span class="badge badge-success"><i class="fa fa-plus-circle"></i> Add Data</span></a>
            </div>
        </div>
         <div class="row">
            <div class="form-group col-sm-12">
                <label>Pilih Faktur Pengiriman Barang <span class="tx-danger">*</span></label>
				<table class="table table-hover mg-b-0">
					<thead>
						<tr>
							<th>Nomor Faktur</th>
						
							<th><center>Hapus</center></th>
						</tr>
					</thead>
					<tbody id="tbllegal1"></tbody>
				</table>
                <a onclick="additem('tbllegal1', 'jumlpe', 'legalpe')"><span class="badge badge-success"><i class="fa fa-plus-circle"></i> Add Data</span></a>
            </div>
		</div>
        <div class="row">
            <div class="form-group col-sm-12">
                <label>Tuker Faktur <span class="tx-danger">*</span></label>
				<table class="table table-hover mg-b-0">
					<thead>
						<tr>
							<th>Nomor Faktur</th>
							
							<th><center>Hapus</center></th>
						</tr>
					</thead>
					<tbody id="tbllegal3"></tbody>
				</table>
                <a onclick="additem('tbllegal3', 'jumlfk', 'legalfaktur')"><span class="badge badge-success"><i class="fa fa-plus-circle"></i> Add Data</span></a>
            </div>
		</div>
        <div class="clearfix mg-t-25 mg-b-25"></div>
        <div class="row">
            <div class="col-sm-12">
                <a href="<?php echo("$sistem/finance"); ?>" title="Batal"><button type="button" class="btn btn-secondary btn-xs">Batal</button></a>
                <button type="submit" id="bsave" class="btn btn-dark btn-xs">Simpan</button>
                <div id="imgloading"></div>
            </div>
		</div>
        <!-- <div class="row">
            <div class="textarea col-sm-12">
                 <a href="<?php echo("$sistem/finance"); ?>" title="Batal"><button type="button" class="btn btn-secondary btn-xs">Batal</button></a>

                <button type="submit" id="bsave" class="btn btn-dark">Simpan</button>
                <div id="imgloading"></div>
            </div>
		</div> -->
		</form>
    </div>
</div>
<!-- <script type="text/javascript">
$('.select2').select2({
	placeholder: '-- Pilih Nama Kurir --',
	searchInputPlaceholder: 'Search options'
});
</script> -->

<!-- <div>
    json_encode($_REQUEST_api)
</div> -->