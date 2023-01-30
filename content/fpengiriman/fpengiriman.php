<div class="content-header">
    <div>
        <!-- <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pengiriman</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pengiriman Kurir</li>
            </ol>
        </nav> -->
        <h4 class="content-title">Input Data Tukar Faktur - Pengiriman Kolektor</h4>
    </div>
</div>
<div class="content-body">
    <div class="component-section no-code">
            <!-- <h5 id="section1" class="tx-semibold"><?php echo($data->sistem('pt_sis')); ?></h5>
            <div style="margin-top:10px; margin-bottom:25px;">
                <div>Izin PBF No : <?php echo($data->sistem('pbf_sis')); ?></div>
                <div>NPWP No : <?php echo($data->sistem('npwp_sis')); ?></div>
                <div>Alamat : <?php echo($data->sistem('alamat_sis')); ?></div>
            </div> -->
        <form id="formpengiriman" action="#" method="post" autocomplete="off">
        <input type="hidden" name="nmenu" id="nmenu" value="fpengiriman" readonly="readonly" />
        <div class="form-row">
            <div class="form-group col-sm-6">
                <label>No Faktur <span class="tx-danger">*</span></label>
                <select name="id_tfk" id="id_tfk" class="form-control select2" onchange="cekFaktur()" required="required">
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
            <div class="form-group col-sm-6"></div>
            <div class="form-group col-sm-6">
                <label>Outlet <span class="tx-danger">*</span></label>
                <input type="text" name="nama_out" id="nama_out" class="form-control" value="" required="required" disabled/>
                <input type="hidden" name="id_out" id="id_out"/>
            </div>
            <div class="form-group col-sm-6">
                <label>Tanggal Tuker Faktur<span class="tx-danger">*</span></label>
                <input type="text" name="tgl_tfk" class="form-control datepicker" value="" placeholder="9999-99-99" required="required" />
            </div>
            <div class="form-group col-sm-6">
                <label>Status Tukar Faktur <span class="tx-danger">*</span></label>
                <select name="status_tfkk" id="status_tfkk" class="form-control select2" required="required">
                    <option value="">-- Pilih --</option>
                    <option value="Diterima">Diterima</option>
                    <option value="Dikembalikan">Dikembalikan</option>
                    <option value="Drop">Drop</option>
                    <!-- <option value="Dikembalikan Sebagian">Dikembalikan Sebagian</option>
                    <option value="Dikembalikan Seluruhnya">Dikembalikan Seluruhnya</option> -->
                </select>
            </div>
            <div class="form-group col-sm-6">
                <label>Keterangan</label>
                <textarea type="text" name="ket_tfkk" class="form-control" placeholder="Ketik keterangan di sini..." /></textarea>
            </div>
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