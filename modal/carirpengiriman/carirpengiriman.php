<?php
	require_once('../../config/connection/connection.php');
	require_once('../../config/connection/security.php');
	require_once('../../config/function/data.php');
	$secu	= new Security;
	$base	= new DB;
	$data	= new Data;
	$conn	= $base->open();
	$sistem	= $data->sistem('url_sis');
	$menu	= $secu->injection(@$_POST['menu']);
	$cari	= $secu->injection(@$_POST['cari']);
	$pecah	= explode('_', $cari);
?>
    <link rel="stylesheet" href="<?php echo("$sistem/zebrapicker/zebra_datepicker.min.css"); ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo("$sistem/sumoselect/sumoselect.min.css"); ?>" type="text/css" />
    <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel">Pencarian</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><i class="fa fa-times-circle"></i></span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="form-group col-md-6">
                <label>Status Pengiriman <span class="tx-danger">*</span></label>
                <select type="text" name="cari1" id="cari1" class="form-control sumoselect" required="required">
									<option value="Diterima">Diterima</option>
                                    <option value="Dikembalikan Sebagian">Dikembalikan Sebagian</option>
                                    <option value="Dikembalikan Seluruhnya">Dikembalikan Seluruhnya</option>
                </select>
            </div>
						<div class="form-group col-md-6">
                <label>Nama Outlet</label>
                <input type="text" name="cari2" id="cari2" class="form-control"/>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-xs" data-dismiss="modal">Batal</button>
        <button type="button" id="btncari" class="btn btn-dark btn-xs">Cari</button>
        <div id="imgloading"></div>
    </div>
<?php
	$conn	= $base->close();
?>
	<script type="text/javascript" src="<?php echo("$sistem/zebrapicker/zebra_datepicker.min.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo("$sistem/sumoselect/jquery.sumoselect.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo("$sistem/config/js/searching.js"); ?>"></script>
	<script type="text/javascript">
		$('.sumoselect').SumoSelect({
			csvDispCount: 3,
			search: true,
			searchText:'Enter here.'
		});
		$("#btncari").click(function(){
			var cari1	= $("#cari1").val();
			var cari2 	= $("#cari2").val();
			var gabung	= "cari="+cari1+"_"+cari2;
			window.location.href = "<?php echo("$sistem/$menu/"); ?>"+gabung;
		});
  </script>