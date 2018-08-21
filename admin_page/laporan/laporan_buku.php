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
                        <li class="active">Laporan Buku</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><i class="fa fa-check-square-o"></i> Laporan Buku</h3>
                                </div>
                                <div class="box-body">
                                    <form method="post" action="">
                                    <div class="row">
                                        
                                    </div>

                                    <?php
                                        if(true){
                                            $sql = "SELECT b.kode_buku, b.nama_buku, b.stok_buku,
													(SELECT COUNT(*) FROM t_peminjaman p WHERE p.buku_id=b.buku_id AND p.tanggal_kembali IS NULL) AS terpinjam
													FROM m_buku b";
                                            $exec = mysqli_query($conn, $sql);
                                    ?>
                                    <br/>
                                    <table id="tblbrg" class="table table-bordered table-hover">
                                        <tr>
                                            <td>Kode Buku</td>
                                            <td>Nama Buku</td>
                                            <td>Stok Tersedia</td>
                                            <td>Masih Terpinjam</td>
                                            <td>Total Buku</td>
                                        </tr>
                                        <?php
                                            while($data = mysqli_fetch_array($exec)){
                                        ?>
                                        <tr>
                                            <td><?php echo $data["kode_buku"] ?></td>
                                            <td><?php echo $data["nama_buku"] ?></td>
                                            <td><?php echo $data["stok_buku"] ?></td>
                                            <td><?php echo $data["terpinjam"] ?></td>
                                            <td><?php echo ($data["stok_buku"] + $data["terpinjam"]) ?></td>
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