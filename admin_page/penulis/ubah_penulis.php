<?php
    session_start();
    include_once("../../conf/database.php");
    include_once("../../conf/general.php");
    include_once("../../function/func_login.php");
    include_once("../../function/func_penulis.php");
    include_once("../../function/func_kategori.php");

    if(!cekStatusLogin()){
        header("location:../../");
    }

    $penulis[] = array();
    $pesan = "";
    if(isset($_POST["simpan"])){
        $penulis["penulis_id"] = amankanInputan($conn, $_POST["penulis_id"]);
        $penulis["nama_penulis"] = amankanInputan($conn, $_POST["txt_nama_penulis"]);
        $penulis["jenis_kelamin"] = amankanInputan($conn, $_POST["option_jeniskelamin"]);
        $penulis["alamat"] = amankanInputan($conn, $_POST["txt_alamat"]);
        $penulis["tanggal_lahir"] = amankanInputan($conn, $_POST["txt_tanggal_lahir"]);

        $simpan = ubahPenulis($conn, $penulis);
        if($simpan["info"]=="sukses"){
            $pesan = $simpan["detail"];
        }else{
            $pesan = $simpan["detail"];
        }
    }else{
        if(isset($_GET["idx"])){    //jika idnya di set
            $data = tampilDataPenulisById($conn, $_GET["idx"]);
            if($data["penulis_id"]!=0){   // cek apakah id ada di data penulis

                if(isset($_SESSION["info"])){ // menangkap pesan sukses saat insert data 
                    $pesan = $_SESSION["info"];
                    unset($_SESSION["info"]);
                }

                $penulis["penulis_id"] = $data["penulis_id"];
                $penulis["nama_penulis"] = $data["nama_penulis"];
                $penulis["jenis_kelamin"] = $data["jenis_kelamin"];
                $penulis["alamat"] = $data["alamat"];
                $penulis["tanggal_lahir"] = $data["tanggal_lahir"];
            }else{      //jika tidak ditemukan redirect ke tampil buku
                header("location:./");
            }
        }
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
                    <li class="active">Penulis</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">
                    <div class="col-xs-6">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-check-square-o"></i> Tambah Penulis</h3>
                            </div>
                            <form class="form-horizontal" method="post" action="">
                                <input type="hidden" name="penulis_id" value="<?php echo $penulis["penulis_id"] ?>">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="txt_nama_penulis" class="col-sm-3 control-label">Nama Penulis</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="txt_nama_penulis" name="txt_nama_penulis" placeholder="Nama Penulis" type="text" value="<?php echo $penulis["nama_penulis"]; ?>" required >
                                        </div>
                                    </div>


                                    <?php
                                        $checkedLaki = "";
                                        $checkedPerempuan = "";
                                        if($penulis["jenis_kelamin"]=="p"){
                                            $checkedPerempuan = "checked";
                                        }else{
                                            $checkedLaki = "checked";
                                        }
                                    ?>
                                    <div class="form-group">
                                        <label for="txt_nama_buku" class="col-sm-3 control-label">Jenis Kelamin</label>
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
                                        <label for="txt_alamat" class="col-sm-3 control-label">Alamat</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="txt_alamat" name="txt_alamat" placeholder="Alamat" type="text" value="<?php echo $penulis["alamat"]; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="txt_alamat" class="col-sm-3 control-label">Alamat</label>
                                        <div class="col-sm-9">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input class="form-control pull-right" name="txt_tanggal_lahir" id="datepicker" type="text" value="<?php echo $penulis["tanggal_lahir"]; ?>" >
                                            </div>
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

                <div class="modal modal-default fade" id="modal-default">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button id="cmdclose" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Informasi</h4>
                            </div>
                            <div class="modal-body">
                                <p>
                                    <?php echo $pesan; ?>
                                </p>
                            </div>
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

    <?php if(!empty($pesan)){ ?>
        <script>
            $('.modal').modal('show');
            setTimeout(function(){
                $("#cmdclose").click();
            }, 1000);
        </script>
    <?php } ?>

</body>
</html>