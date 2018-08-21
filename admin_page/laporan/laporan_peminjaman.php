<?php
    session_start();
    include_once("../../conf/database.php");
    include_once("../../conf/general.php");
    include_once("../../function/func_login.php");
    include_once("../../function/func_buku.php");
    include_once("../../function/func_kategori.php");

    if(!cekStatusLogin()){
        header("location:../../");
    }

    $start = date('Y-m-d');
    $end = date('Y-m-d');

    if(isset($_POST["btnsimpan"])){
        $start = amankanInputan($conn, $_POST["start"]);
        $end = amankanInputan($conn, $_POST["end"]);
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
                        <li class="active">Laporan Peminjaman</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><i class="fa fa-check-square-o"></i> Laporan Peminjaman</h3>
                                </div>
                                <div class="box-body">
                                    <form method="post" action="">
                                    <div class="row">
                                        <div class="col-xs-5">
                                            <div class="form-group">
                                                <div class="col-sm-6">
                                                    <div class="input-group date">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input class="form-control pull-right" name="start" id="datepicker" type="text" value="<?php echo $start; ?>" >
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="input-group date">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input class="form-control pull-right" name="end" id="datepicker2" type="text" value="<?php echo $end; ?>" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-2">
                                            <button type="submit" class="btn btn-primary" name="btnsimpan" value="">CARI</button>
                                        </div>
                                    </div>

                                    <?php
                                        if(isset($_POST["btnsimpan"])){
                                            $sql = "SELECT a.nama_anggota, p.tanggal_pinjam, b.kode_buku, b.nama_buku, IFNULL(p.tanggal_kembali, \"Belum kembali\") AS tanggal_kembali, p.denda FROM t_peminjaman p
                                                    INNER JOIN m_buku b ON p.buku_id=b.buku_id INNER JOIN m_anggota a ON p.anggota_id=a.anggota_id
                                                    WHERE (TO_DAYS(p.tanggal_pinjam)>=TO_DAYS('".$start."') AND TO_DAYS(p.tanggal_pinjam)<=TO_DAYS('".$end."'))";
                                            $exec = mysqli_query($conn, $sql);
                                    ?>
                                    <br/>
                                    <table id="tblbrg" class="table table-bordered table-hover">
                                        <tr>
                                            <td>Anggota</td>
                                            <td>Tanggal Pinjam</td>
                                            <td>Kode Buku</td>
                                            <td>Nama Buku</td>
                                            <td>Tanggal Kembali</td>
                                            <td>Denda</td>
                                        </tr>
                                        <?php
                                            while($data = mysqli_fetch_array($exec)){
                                        ?>
                                        <tr>
                                            <td><?php echo $data["nama_anggota"] ?></td>
                                            <td><?php echo $data["tanggal_pinjam"] ?></td>
                                            <td><?php echo $data["kode_buku"] ?></td>
                                            <td><?php echo $data["nama_buku"] ?></td>
                                            <td><?php echo $data["tanggal_kembali"] ?></td>
                                            <td><?php echo $data["denda"] ?></td>
                                        </tr>
                                        <?php
                                            }
                                        ?>
                                    </table>
                                    <?php
                                        }
                                    ?>
                                    </form>
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

                $('#datepicker2').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
                });
        </script>

    </body>
</html>