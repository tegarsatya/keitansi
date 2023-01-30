<div class="content-header">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">List Menu</a></li>
                <li class="breadcrumb-item active" aria-current="page">Cash & Bank</li>
            </ol>
        </nav>
        <h4 class="content-title">Input Data - Rute Kurir</h4>
    </div>
</div>
<!--
<input type="hidden" name="caridata" id="caridata" value="-" readonly="readonly" />
<input type="hidden" name="halaman" id="halaman" value="1" readonly="readonly" />
<input type="hidden" name="maximal" id="maximal" value="15" readonly="readonly" />
-->
<!-- <input type="hidden" name="jumlegal" id="jumlegal" value="0" readonly="readonly" />
<input type="hidden" name="jumitem" id="jumitem" value="0" readonly="readonly" /> -->
<div class="content-body">
    <div class="component-section no-code">
        <h5 id="section1" class="tx-semibold">Input Data Pengiriman Hari ini</h5>
        <p class="mg-b-25">Input Data Pengiriman Hari ini</p>
        <form id="formtransaksi" action="#" method="post" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="nmenu" id="nmenu" value="rutek" readonly="readonly" />
        <input type="hidden" name="nact" id="nact" value="input" readonly="readonly" />
        <div class="row">

        <!-- <div class="form-group col-sm-6">
                <label>Id Rute<span class="tx-danger">*</span></label>
                <input type="text" name="id_rute" class="form-control datepicker" value="" placeholder="9999-99-99" required="required" />
            </div> -->

        <div class="form-group col-sm-3">
                <label>Nama Team Pengirim <span class="tx-danger">*</span></label>
                <select name="nama" id="nama" class="form-control select2" onchange="" required="required">
                <option value="">-- Pilih --</option>
                <?php
                  $master = $conn->prepare("SELECT id_adm, nama_adm FROM adminz ORDER BY id_adm ASC");
                  $master->execute();
                  while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
                ?>
                <option value="<?php echo($hasil['nama_adm']); ?>"><?php echo($hasil['nama_adm']); ?></option>
                <?php } ?>
                </select>
            </div>
           
            <div class="form-group col-sm-6">
                <label>Rute Pengiriman 1 <span class="tx-danger">*</span></label>
                <select name="rute_satu" id="rute_satu" class="form-control select2" onchange="" required="required">
                <option value="">-- Pilih --</option>
                <?php
                 $master	= $conn->prepare("SELECT A.id_tfk, A.kode_tfk, B.nama_out, DATE_FORMAT(A.created_at, '%Y-%m-%d') FROM transaksi_faktur AS A LEFT JOIN outlet AS B ON A.id_out=B.id_out WHERE DATE(tgl_tfk) = CURDATE()  ORDER BY A.tgl_tfk ASC");                 
                 $master->execute();
                  while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
                ?>
                 <option value="<?php echo($hasil['id_tfk']); ?>"><?php echo("$hasil[kode_tfk] ($hasil[nama_out])"); ?></option>
                <?php } ?>
                </select>
            </div>
          
            <div class="form-group col-sm-6">
                <label>Rute Pengiriman 2 <span class="tx-danger">*</span></label>
                <select name="rute_dua" id="rute_dua" class="form-control select2" onchange="" required="required">
                <option value="">-- Pilih --</option>
                <?php
                 $master	= $conn->prepare("SELECT A.id_tfk, A.kode_tfk, B.nama_out, DATE_FORMAT(A.created_at, '%Y-%m-%d') FROM transaksi_faktur AS A LEFT JOIN outlet AS B ON A.id_out=B.id_out WHERE DATE(tgl_tfk) = CURDATE()  ORDER BY A.tgl_tfk ASC");                 
                 $master->execute();
                  while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
                ?>
                 <option value="<?php echo($hasil['id_tfk']); ?>"><?php echo("$hasil[kode_tfk] ($hasil[nama_out])"); ?></option>
                <?php } ?>
                </select>
            </div>

            <div class="form-group col-sm-6">
                <label>Rute Pengiriman 3 <span class="tx-danger">*</span></label>
                <select name="rute_tiga" id="rute_tiga" class="form-control select2" onchange="" required="required">
                <option value="">-- Pilih --</option>
                <?php
                 $master	= $conn->prepare("SELECT A.id_tfk, A.kode_tfk, B.nama_out, DATE_FORMAT(A.created_at, '%Y-%m-%d') FROM transaksi_faktur AS A LEFT JOIN outlet AS B ON A.id_out=B.id_out WHERE DATE(tgl_tfk) = CURDATE()  ORDER BY A.tgl_tfk ASC");                 
                 $master->execute();
                  while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
                ?>
                 <option value="<?php echo($hasil['id_tfk']); ?>"><?php echo("$hasil[kode_tfk] ($hasil[nama_out])"); ?></option>
                <?php } ?>
                </select>
            </div>

            <div class="form-group col-sm-6">
                <label>Rute Pengiriman 4 <span class="tx-danger">*</span></label>
                <select name="rute_empat" id="rute_empat" class="form-control select2" onchange="" required="required">
                <option value="">-- Pilih --</option>
                <?php
                 $master	= $conn->prepare("SELECT A.id_tfk, A.kode_tfk, B.nama_out, DATE_FORMAT(A.created_at, '%Y-%m-%d') FROM transaksi_faktur AS A LEFT JOIN outlet AS B ON A.id_out=B.id_out WHERE DATE(tgl_tfk) = CURDATE()  ORDER BY A.tgl_tfk ASC");                 
                 $master->execute();
                  while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
                ?>
                 <option value="<?php echo($hasil['id_tfk']); ?>"><?php echo("$hasil[kode_tfk] ($hasil[nama_out])"); ?></option>
                <?php } ?>
                </select>
            </div>

            <div class="form-group col-sm-6">
                <label>Rute Pengiriman 5 <span class="tx-danger">*</span></label>
                <select name="rute_lima" id="rute_lima" class="form-control select2" onchange="" required="required">
                <option value="">-- Pilih --</option>
                <?php
                 $master	= $conn->prepare("SELECT A.id_tfk, A.kode_tfk, B.nama_out, DATE_FORMAT(A.created_at, '%Y-%m-%d') FROM transaksi_faktur AS A LEFT JOIN outlet AS B ON A.id_out=B.id_out WHERE DATE(tgl_tfk) = CURDATE()  ORDER BY A.tgl_tfk ASC");                 
                 $master->execute();
                  while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
                ?>
                 <option value="<?php echo($hasil['id_tfk']); ?>"><?php echo("$hasil[kode_tfk] ($hasil[nama_out])"); ?></option>
                <?php } ?>
                </select>
            </div>

            <div class="form-group col-sm-6">
                <label>Rute Pengiriman 6 <span class="tx-danger">*</span></label>
                <select name="rute_enam" id="rute_enam" class="form-control select2" onchange="" required="required">
                <option value="">-- Pilih --</option>
                <?php
                 $master	= $conn->prepare("SELECT A.id_tfk, A.kode_tfk, B.nama_out, DATE_FORMAT(A.created_at, '%Y-%m-%d') FROM transaksi_faktur AS A LEFT JOIN outlet AS B ON A.id_out=B.id_out WHERE DATE(tgl_tfk) = CURDATE()  ORDER BY A.tgl_tfk ASC");                 
                 $master->execute();
                  while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
                ?>
                 <option value="<?php echo($hasil['id_tfk']); ?>"><?php echo("$hasil[kode_tfk] ($hasil[nama_out])"); ?></option>
                <?php } ?>
                </select>
            </div>

            <div class="form-group col-sm-6">
                <label>Rute Pengiriman 7 <span class="tx-danger">*</span></label>
                <select name="rute_tujuh" id="rute_tujuh" class="form-control select2" onchange="" required="required">
                <option value="">-- Pilih --</option>
                <?php
                 $master	= $conn->prepare("SELECT A.id_tfk, A.kode_tfk, B.nama_out, DATE_FORMAT(A.created_at, '%Y-%m-%d') FROM transaksi_faktur AS A LEFT JOIN outlet AS B ON A.id_out=B.id_out WHERE DATE(tgl_tfk) = CURDATE()  ORDER BY A.tgl_tfk ASC");                 
                 $master->execute();
                  while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
                ?>
                 <option value="<?php echo($hasil['id_tfk']); ?>"><?php echo("$hasil[kode_tfk] ($hasil[nama_out])"); ?></option>
                <?php } ?>
                </select>
            </div>

            <div class="form-group col-sm-6">
                <label>Rute Pengiriman 8 <span class="tx-danger">*</span></label>
                <select name="rute_delapan" id="rute_delapan" class="form-control select2" onchange="" required="required">
                <option value="">-- Pilih --</option>
                <?php
                 $master	= $conn->prepare("SELECT A.id_tfk, A.kode_tfk, B.nama_out, DATE_FORMAT(A.created_at, '%Y-%m-%d') FROM transaksi_faktur AS A LEFT JOIN outlet AS B ON A.id_out=B.id_out WHERE DATE(tgl_tfk) = CURDATE()  ORDER BY A.tgl_tfk ASC");                 
                 $master->execute();
                  while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
                ?>
                 <option value="<?php echo($hasil['id_tfk']); ?>"><?php echo("$hasil[kode_tfk] ($hasil[nama_out])"); ?></option>
                <?php } ?>
                </select>
            </div>

            <div class="form-group col-sm-6">
                <label>Rute Pengiriman 9 <span class="tx-danger">*</span></label>
                <select name="rute_sembilan" id="rute_sembilan" class="form-control select2" onchange="" required="required">
                <option value="">-- Pilih --</option>
                <?php
                 $master	= $conn->prepare("SELECT A.id_tfk, A.kode_tfk, B.nama_out, DATE_FORMAT(A.created_at, '%Y-%m-%d') FROM transaksi_faktur AS A LEFT JOIN outlet AS B ON A.id_out=B.id_out WHERE DATE(tgl_tfk) = CURDATE()  ORDER BY A.tgl_tfk ASC");                 
                 $master->execute();
                  while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
                ?>
                 <option value="<?php echo($hasil['id_tfk']); ?>"><?php echo("$hasil[kode_tfk] ($hasil[nama_out])"); ?></option>
                <?php } ?>
                </select>
            </div>

            <div class="form-group col-sm-6">
                <label>Rute Pengiriman 10 <span class="tx-danger">*</span></label>
                <select name="rute_sepuluh" id="rute_sepuluh" class="form-control select2" onchange="" required="required">
                <option value="">-- Pilih --</option>
                <?php
                 $master	= $conn->prepare("SELECT A.id_tfk, A.kode_tfk, B.nama_out, DATE_FORMAT(A.created_at, '%Y-%m-%d') FROM transaksi_faktur AS A LEFT JOIN outlet AS B ON A.id_out=B.id_out WHERE DATE(tgl_tfk) = CURDATE()  ORDER BY A.tgl_tfk ASC");                 
                 $master->execute();
                  while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
                ?>
                 <option value="<?php echo($hasil['id_tfk']); ?>"><?php echo("$hasil[kode_tfk] ($hasil[nama_out])"); ?></option>
                <?php } ?>
                </select>
            </div>
            <div class="form-group col-sm-6">
                <label>Rute Pengiriman 11 <span class="tx-danger">*</span></label>
                <select name="rute_sebelas" id="rute_sebelas" class="form-control select2" onchange="" required="required">
                <option value="">-- Pilih --</option>
                <?php
                 $master	= $conn->prepare("SELECT A.id_tfk, A.kode_tfk, B.nama_out, DATE_FORMAT(A.created_at, '%Y-%m-%d') FROM transaksi_faktur AS A LEFT JOIN outlet AS B ON A.id_out=B.id_out WHERE DATE(tgl_tfk) = CURDATE()  ORDER BY A.tgl_tfk ASC");                 
                 $master->execute();
                  while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
                ?>
                 <option value="<?php echo($hasil['id_tfk']); ?>"><?php echo("$hasil[kode_tfk] ($hasil[nama_out])"); ?></option>
                <?php } ?>
                </select>
            </div>
            <div class="form-group col-sm-6">
                <label>Rute Pengiriman 12 <span class="tx-danger">*</span></label>
                <select name="rute_duabelas" id="rute_duabelas" class="form-control select2" onchange="" required="required">
                <option value="">-- Pilih --</option>
                <?php
                 $master	= $conn->prepare("SELECT A.id_tfk, A.kode_tfk, B.nama_out, DATE_FORMAT(A.created_at, '%Y-%m-%d') FROM transaksi_faktur AS A LEFT JOIN outlet AS B ON A.id_out=B.id_out WHERE DATE(tgl_tfk) = CURDATE()  ORDER BY A.tgl_tfk ASC");                 
                 $master->execute();
                  while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
                ?>
                 <option value="<?php echo($hasil['id_tfk']); ?>"><?php echo("$hasil[kode_tfk] ($hasil[nama_out])"); ?></option>
                <?php } ?>
                </select>
            </div>

            <div class="form-group col-sm-6">
                <label>Rute Pengiriman 13 <span class="tx-danger">*</span></label>
                <select name="rute_tigabelas" id="rute_tigabelas" class="form-control select2" onchange="" required="required">
                <option value="">-- Pilih --</option>
                <?php
                 $master	= $conn->prepare("SELECT A.id_tfk, A.kode_tfk, B.nama_out, DATE_FORMAT(A.created_at, '%Y-%m-%d') FROM transaksi_faktur AS A LEFT JOIN outlet AS B ON A.id_out=B.id_out WHERE DATE(tgl_tfk) = CURDATE()  ORDER BY A.tgl_tfk ASC");                 
                 $master->execute();
                  while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
                ?>
                 <option value="<?php echo($hasil['id_tfk']); ?>"><?php echo("$hasil[kode_tfk] ($hasil[nama_out])"); ?></option>
                <?php } ?>
                </select>
            </div>

            <div class="form-group col-sm-6">
                <label>Tanggal Pengiriman<span class="tx-danger">*</span></label>
                <input type="text" name="tanggal_kirim" class="form-control datepicker" value="" placeholder="9999-99-99" required="required" />
            </div>


        </div><!-- row -->

        <div class="row">
            <div class="col-sm-12">
                <a href="<?php echo("$sistem/rutek"); ?>" title="Batal"><button type="button" class="btn btn-secondary btn-xs">Batal</button></a>
                <button type="submit" id="bsave" class="btn btn-dark btn-xs">Simpan</button>
                <div id="imgloading"></div>
            </div>
		</div>
		</form>
    </div>
</div>