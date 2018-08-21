<?php
    session_start();
    include_once("../../conf/database.php");
    include_once("../../conf/general.php");
    include_once("../../function/func_login.php");
    include_once("../../function/func_penerbit.php");

    if(!cekStatusLogin()){
        header("location:../../");
    }

    $penerbit[] = array();
    $pesan = "";
    if(isset($_POST["simpan"])){
        $penerbit["nama_penerbit"] = amankanInputan($conn, $_POST["txt_nama_penerbit"]);
        $penerbit["alamat_penerbit"] = amankanInputan($conn, $_POST["txt_alamat_penerbit"]);

        $simpan = simpanPenerbit($conn, $penerbit);
        if($simpan["info"]=="sukses"){
            $_SESSION["info"] = $simpan["detail"];
            header("location:./ubah_penerbit.php?x=buku&idx=" . $simpan["penerbit_id"]);
        }else{
            $pesan = $simpan["detail"];
        }
    }else{
        $penerbit["nama_penerbit"] = "";
        $penerbit["alamat_penerbit"] = "";
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
                    <li class="active">Penerbit</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">
                    <div class="col-xs-6">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-check-square-o"></i> Tambah Penerbit</h3>
                            </div>
                            <form class="form-horizontal" method="post" action="">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="txt_nama_penerbit" class="col-sm-3 control-label">Nama Penulis</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="txt_nama_penerbit" name="txt_nama_penerbit" placeholder="Nama Penulis" type="text" value="<?php echo $penerbit["nama_penerbit"]; ?>" required >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="txt_alamat_penerbit" class="col-sm-3 control-label">Alamat</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="txt_alamat_penerbit" name="txt_alamat_penerbit" placeholder="Alamat" type="text" value="<?php echo $penerbit["alamat_penerbit"]; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <a href="./?x=buku" class="btn btn-default">Kembali</a>
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