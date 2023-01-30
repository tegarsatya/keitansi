<div class="content-header">
    <div>
        <!-- <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pengiriman</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pengiriman Kurir</li>
            </ol>
        </nav> -->
        <h4 class="content-title">Input Data - Tanda Terima Tuker Faktur</h4>
    </div>
</div>
<?php
        $unik	= "/KWT/DFM/".$data->romawi(date('m')).'/'.date('Y');
        $kode	= $data->transcodetfw($unik, "nomor", "finance");
        // $apls   = $data->get_apl();

?>
<div class="content-body">
    <div class="component-section no-code">
            <h5 id="section1" class="tx-semibold"><?php echo($data->sistem('pt_sis')); ?></h5>
            <!-- <div style="margin-top:10px; margin-bottom:25px;">
                <div>Izin PBF No : <?php echo($data->sistem('pbf_sis')); ?></div>
                <div>NPWP No : <?php echo($data->sistem('npwp_sis')); ?></div>
                <div>Alamat : <?php echo($data->sistem('alamat_sis')); ?></div>
            </div> -->
        <form id="formtransaksi" action="#" method="post"  enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="nmenu" id="nmenu" value="finance" readonly="readonly" />
        <input type="hidden" name="nact" id="nact" value="input" readonly="readonly" />
        <div class="form-row">

        <div class="form-group col-sm-12">
                <label>Tgl. Tanda Terima <span class="tx-danger">*</span></label>
                <input type="text" name="tanggal_faktur" class="form-control datepicker" placeholder="9999-99-99" required="required" />
            </div>
            <div class="form-group col-sm-12">
                    <label>Nomor Tanda Terima / Kwitansi <span class="tx-danger">*</span></label>
                    <input type="text" name="nomor" class="form-control" value="<?php echo($kode); ?>" placeholder="-" required="required" />
            </div>
            <div class="form-group col-sm-12">
                <label>Nama Outlet <span class="tx-danger">*</span></label>
                <select name="nama_outlet" id="nama_outlet" class="form-control select2" onchange="" required="required">
                <option value="">-- Pilih --</option>
                <?php
                $master	= $conn->prepare("SELECT id_out, nama_out FROM outlet ORDER BY nama_out ASC");                 
                $master->execute();
                  while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
                ?>
                 <option value="<?php echo($hasil['id_out']); ?>"><?php echo($hasil['nama_out'] ); ?></option>
                <?php } ?>
                </select>
            </div>

            <div class="form-group col-sm-6">
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
            </div>
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
            <div class="textarea col-sm-12">
                <button type="submit" id="bsave" class="btn btn-dark">Simpan</button>
                <div id="imgloading"></div>
            </div>
		</div>
		</form>
    </div>
</div>

<!-- <div>
    json_encode($_REQUEST_api)
</div> -->