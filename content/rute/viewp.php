<div class="content-header">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Menu</a></li>
                <li class="breadcrumb-item"><a href="#">Mitra</a></li>
                <li class="breadcrumb-item active" aria-current="page">Rute Pengiriman</li>
            </ol>
        </nav>
        <h4 class="content-title">Detail Data - Rute Tukar Faktur</h4>
    </div>
</div>
<div class="content-body">
    <h1>Rute TUKER  FAKTUR</h1>
    <div class="table-responsive">
            <table>
                    <thead>
                        <tr>
                            <th>Nama Pengirim</th>
                            <th><center>Nomor Faktur</center></th>
                            <!-- <th>Nomor Faktur Tuker Faktur</th> -->
                            <!-- <th>Tanggal</th> -->
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                     	$kode	= $secu->injection($_GET['keycode']);
                        $master	= $conn->prepare("SELECT A.id_rute, A.nama_pengirim, A.tanggal, B.tuker_faktur, B.id_rute FROM rute AS A LEFT JOIN rute_tuker_faktur AS B ON A.id_rute=B.id_rute WHERE A.id_rute=:kode");
                        $master->bindParam(':kode', $kode, PDO::PARAM_STR);
                        $master->execute();
                        while($hasil= $master->fetch(PDO::FETCH_ASSOC)){
                    ?>
                        <tr>
                            <td><?php echo($hasil['nama_pengirim']); ?></td>
                            <!-- <td><center><?php echo($hasil['barang']); ?></center></td> -->
                            <td><?php echo($hasil['tuker_faktur']); ?></td>
                            <!-- <td><?php echo($hasil['tanggal']); ?></td> -->
                            
                        </tr>
                    <?php
                        $nomor++;
                        }
                    ?>
                    </tbody>
                </table>
		<?php $conn	= $base->close(); ?>
    </div>
    
    <div class="clearfix mg-t-25 mg-b-25"></div>
    <div class="row row-sm">
        <div class="col-sm-12">
            <a href="<?php echo("$sistem/rute"); ?>" title="Kembai"><button type="button" class="btn btn-secondary btn-xs"><i class="fa fa-chevron-circle-left"></i> Kembali</button></a>
        </div>
    </div>
    
</div>
