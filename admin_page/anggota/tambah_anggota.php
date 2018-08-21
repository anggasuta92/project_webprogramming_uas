<?php
    session_start();
    include_once("../../conf/database.php");
    include_once("../../conf/general.php");
    include_once("../../function/func_login.php");
    include_once("../../function/func_anggota.php");
    include_once("../../function/func_kategori.php");

    if(!cekStatusLogin()){
        header("location:../../");
    }

    $anggota[] = array();
    $pesan = "";
    if(isset($_POST["simpan"])){


        $anggota["kode_anggota"] = amankanInputan($conn, $_POST["txt_kode_anggota"]);
        $anggota["nama_anggota"] = amankanInputan($conn, $_POST["txt_nama_anggota"]);
        $anggota["jenis_kelamin_anggota"] = amankanInputan($conn, $_POST["option_jeniskelamin"]);
        $anggota["tempat_lahir_anggota"] = amankanInputan($conn, $_POST["txt_tempat_lahir_anggota"]);
        $anggota["tanggal_lahir_anggota"] = amankanInputan($conn, $_POST["txt_tanggal_lahir_anggota"]);
        $anggota["alamat_anggota"] = amankanInputan($conn, $_POST["txt_alamat_anggota"]);
        $anggota["email_anggota"] = amankanInputan($conn, $_POST["txt_email_anggota"]);
        //$anggota["status"] = amankanInputan($conn, $_POST["txt_status"]);
        $anggota["tgl_menjadi_anggota"] = amankanInputan($conn, $_POST["txt_tgl_menjadi_anggota"]);  
        

        $simpan = simpanAnggota($conn, $anggota);
        if($simpan["info"]=="sukses"){
            $_SESSION["info"] = $simpan["detail"];
            header("location:./ubah_anggota.php?x=anggota&idx=" . $simpan["anggota_id"]);
        }else{
            $pesan = $simpan["detail"];
            
        }
    }else{
        $anggota["kode_anggota"] = kodeAnggotaOtomatis($conn);
        $anggota["nama_anggota"] = "";
        $anggota["jenis_kelamin_anggota"] = "";
        $anggota["tempat_lahir_anggota"] = "";
        $anggota["tanggal_lahir_anggota"] = date("Y-m-d");
        $anggota["alamat_anggota"] = "";
        $anggota["email_anggota"] = "";
        //$anggota["status"] = "";
        $anggota["tgl_menjadi_anggota"] = date("Y-m-d");

    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        <?php echo $app_title; ?>
    </title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="../../asset/admilte_component/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../asset/admilte_component/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../asset/admilte_component/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="../../asset/admilte_component/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="../../asset/admilte_component/bower_components/datatables.net-bs/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="../../asset/admilte_component/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="../../asset/admilte_component/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../../asset/admilte_component/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="../../asset/admilte_component/plugins/iCheck/square/blue.css">

    <script src="../../asset/admilte_component/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="../../asset/admilte_component/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../../asset/admilte_component/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../../asset/admilte_component/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../../asset/admilte_component/bower_components/datatables.net-bs/js/dataTables.buttons.min.js"></script>
    <script src="../../asset/admilte_component/dist/js/adminlte.min.js"></script>
    <script src="../../asset/admilte_component/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php include("../template/navbar.php"); ?>
        <?php include("../template/sidebar.php"); ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    Dashboard
                    <small></small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    <li class="active">Anggota</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">
                    <div class="col-xs-7">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-check-square-o"></i> Tambah Anggota</h3>
                            </div>
                            <form class="form-horizontal" method="post" action="">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="txt_kode_anggota" class="col-sm-3 control-label">Kode Anggota</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="txt_kode_anggota" name="txt_kode_anggota" placeholder="Kode Anggota" type="text" value="<?php echo $anggota["kode_anggota"]; ?>" required readOnly >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="txt_nama_buku" class="col-sm-3 control-label">Nama Anggota</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="txt_nama_anggota" name="txt_nama_anggota" placeholder="Nama Anggota" type="text" value="<?php echo $anggota["nama_anggota"]; ?>" required >
                                        </div>
                                    </div>

                                    <?php
                                        $checkedLaki = "";
                                        $checkedPerempuan = "";
                                        if($anggota["jenis_kelamin_anggota"]=="p"){
                                            $checkedPerempuan = "checked";
                                        }else{
                                            $checkedLaki = "checked";
                                        }
                                    ?>

                                    <div class="form-group">
                                        <label for="txt_jenis_kelamin_anggota" class="col-sm-3 control-label">Jenis Kelamin</label>
                                        <div class="col-sm-9">
                                            <div class="form-group">
                                                <div class="radio">
                                                    <label>
                                                    <input name="option_jeniskelamin" id="jk_laki" value="l" <?php echo $checkedLaki; ?> type="radio">
                                                        Laki - laki
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label>
                                                    <input name="option_jeniskelamin" id="jk_perempuan" value="p" <?php echo $checkedPerempuan; ?> type="radio">
                                                        Perempuan
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="txt_tempat_lahir_anggota" class="col-sm-3 control-label">Tempat Lahir</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="txt_tempat_lahir_anggota" name="txt_tempat_lahir_anggota" placeholder="Tempat Lahir" type="text" value="<?php echo $anggota["tempat_lahir_anggota"]; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="txt_tanggal_lahir_anggota" class="col-sm-3 control-label">Tanggal Lahir</label>
                                        <div class="col-sm-9">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input class="form-control pull-right" name="txt_tanggal_lahir_anggota" id="datepicker" type="text" value="<?php echo $anggota["tanggal_lahir_anggota"]; ?>" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="txt_alamat_anggota" class="col-sm-3 control-label">Alamat</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="txt_alamat_anggota" name="txt_alamat_anggota" placeholder="Alamat" type="text" value="<?php echo $anggota["alamat_anggota"]; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="txt_email_anggota" class="col-sm-3 control-label">Email</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="txt_status" name="txt_email_anggota" placeholder="Email" type="text" value="<?php echo $anggota["email_anggota"]; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="txt_tgl_menjadi_anggota" class="col-sm-3 control-label">Tanggal Gabung</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="txt_tgl_menjadi_anggota" name="txt_tgl_menjadi_anggota" type="text" value="<?php echo $anggota["tgl_menjadi_anggota"]; ?>"  required readOnly>
                                        </div>
                                    </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <a href="./?x=anggota" class="btn btn-default">Kembali</a>
                                    <button type="submit" class="btn btn-primary pull-right" name="simpan" value="">Simpan</button>
                                </div>
                                <!-- /.box-footer -->
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php include("../template/footer.php"); ?>

    </div>

<script>
    $('#datepicker').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd'
    });
</script>

</body>
</html>