<?php
	require_once('../../config/connection/connection.php');
	require_once('../../config/connection/security.php');
	require_once('../../config/function/data.php');
	$secu	= new Security;
	$base	= new DB;
	$data	= new Data;
	$sistem	= $data->sistem('url_sis');
	$catat	= date('Y-m-d H:i:s');
	$admin	= $secu->injection(@$_COOKIE['adminkuy']);
	$kunci	= $secu->injection(@$_COOKIE['kuncikuy']);
	$valid	= $secu->validadmin($admin, $kunci);
	if($valid==false){ header("location:$sistem/signout"); } else {
	$conn	= $base->open();
	$nomor	= $secu->injection(@$_POST['n']);
?>
<tr id="<?php echo("nokwi$nomor"); ?>">
    <td>
	<select name="nokwi[]"  id="nokwi[]" class="form-control select2" required="required">
    	<option value="">-- Select Data Faktur --</option>
		<?php
                $master	= $conn->prepare("SELECT A.id_tfk, A.kode_tfk, B.nama_out, DATE_FORMAT(A.created_at, '%Y-%m-%d') FROM transaksi_faktur AS A LEFT JOIN outlet AS B ON A.id_out=B.id_out  ORDER BY A.tgl_tfk ASC");                 
                 $master->execute();
                  while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
                ?>
                 <option value="<?php echo($hasil['kode_tfk']); ?>"><?php echo("$hasil[kode_tfk] ($hasil[nama_out])"); ?></option>
       <?php } ?>
    </select>
    </td>
    <td><input type="text" name="ket[]" class="form-control" placeholder="Type here..." /></td>
    <!-- <td><input type="text" name="tgllegal[]" class="form-control fortgl" placeholder="9999-99-99" /></td> -->
    <td>
    <center>
    	<a onclick="<?php echo("removeitem('jumlfk', 'faktur', $nomor)"); ?>"><span class="badge badge-danger"><i class="fa fa-times-circle"></i></span></a>
	</center>
	</td>
</tr>
<!-- <script type="text/javascript">
	$(".fortgl").mask("9999-99-99");
</script> -->
<?php
	$conn	= $base->close();
	}
?>
<script type="text/javascript">
$('.select2').select2({
	placeholder: '-- Pilih Nomer Faktur --',
	searchInputPlaceholder: 'Search options'
});
</script>
