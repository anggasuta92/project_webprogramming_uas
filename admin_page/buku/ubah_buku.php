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

    $buku[] = array();
    $pesan = "";
    if(isset($_POST["simpan"])){
        $buku["buku_id"] = amankanInputan($conn, $_POST["buku_id"]);
        $buku["kode_buku"] = amankanInputan($conn, $_POST["txt_kode_buku"]);
        $buku["nama_buku"] = amankanInputan($conn, $_POST["txt_nama_buku"]);
        $buku["barcode"] = amankanInputan($conn, $_POST["txt_barcode"]);
        $buku["isbn"] = amankanInputan($conn, $_POST["txt_isbn"]);
        $buku["kategori_buku_id"] = amankanInputan($conn, $_POST["txt_kategori_buku"]);
        $buku["nama_rak"] = amankanInputan($conn, $_POST["txt_nama_rak"]);
        $buku["stok_buku"] = amankanInputan($conn, $_POST["txt_stok_buku"]);

        $simpan = ubahBuku($conn, $buku);
        if($simpan["info"]=="sukses"){
            $pesan = $simpan["detail"];
        }else{
            $pesan = $simpan["detail"];
        }
        $buku["url_ebook"] = tampilUrlEbookByBukuId($conn, $buku["buku_id"]);
    }else{
        if(isset($_GET["idx"])){    //jika idnya di set
            $data = tampilDataBukuById($conn, $_GET["idx"]);
            if($data["buku_id"]!=0){   // cek apakah id ada di data buku

                if(isset($_SESSION["info"])){ // menangkap pesan sukses saat insert data 
                    $pesan = $_SESSION["info"];
                    unset($_SESSION["info"]);
                }

                $buku["buku_id"] = $data["buku_id"];
                $buku["kode_buku"] = $data["kode_buku"];
                $buku["nama_buku"] = $data["nama_buku"];
                $buku["barcode"] = $data["barcode"];
                $buku["isbn"] = $data["isbn"];
                $buku["kategori_buku_id"] = $data["kategori_buku_id"];
                $buku["stok_buku"] = $data["stok_buku"];
                $buku["nama_rak"] = $data["nama_rak"];
                $buku["url_ebook"] = $data["url_ebook"];
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
    <link rel="stylesheet" href="../../asset/admilte_component/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../../asset/admilte_component/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="../../asset/admilte_component/plugins/iCheck/square/blue.css">

    <script src="../../asset/admilte_component/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="../../asset/admilte_component/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../../asset/admilte_component/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../../asset/admilte_component/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../../asset/admilte_component/bower_components/datatables.net-bs/js/dataTables.buttons.min.js"></script>
    <script src="../../asset/admilte_component/dist/js/adminlte.min.js"></script>
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
                    <li class="active">Buku</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">
                    <div class="col-xs-6">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-check-square-o"></i> Tambah Buku</h3>
                            </div>
                            <form class="form-horizontal" method="post" action="./ubah_buku.php?x=buku&idx=<?php echo $buku["buku_id"] ?>">
                                <input type="hidden" name="buku_id" value="<?php echo $buku["buku_id"] ?>">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="txt_kode_buku" class="col-sm-3 control-label">Kode Buku</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="txt_kode_buku" name="txt_kode_buku" placeholder="Kode Buku" type="text" value="<?php echo $buku["kode_buku"]; ?>" required readOnly >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="txt_nama_buku" class="col-sm-3 control-label">Nama Buku</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="txt_nama_buku" name="txt_nama_buku" placeholder="Nama Buku" type="text" value="<?php echo $buku["nama_buku"]; ?>" required >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="txt_barcode" class="col-sm-3 control-label">Barcode</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="txt_barcode" name="txt_barcode" placeholder="Barcode" type="text" value="<?php echo $buku["barcode"]; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="txt_isbn" class="col-sm-3 control-label">ISBN</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="txt_isbn" name="txt_isbn" placeholder="ISBN" type="text" value="<?php echo $buku["isbn"]; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="txt_nama_rak" class="col-sm-3 control-label">Rak</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="txt_nama_rak" name="txt_nama_rak" placeholder="Rak" type="text" value="<?php echo $buku["nama_rak"]; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="txt_stok_buku" class="col-sm-3 control-label">Stok Buku</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="txt_stok_buku" name="txt_stok_buku" placeholder="Stok Buku" type="text" value="<?php echo $buku["stok_buku"]; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="txt_kategori_buku" class="col-sm-3 control-label">Kategori</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="txt_kategori_buku">
                                                <?php
                                                    $exec = tampilDataKategoriBuku($conn, "","nama_kategori asc");
                                                    while($rkategori = mysqli_fetch_array($exec)){
                                                        $selected = "";
                                                        if($buku["kategori_buku_id"]==$rkategori["kategori_buku_id"]){
                                                            $selected = "selected";
                                                        }
                                                ?>
                                                <option value="<?php echo $rkategori["kategori_buku_id"]; ?>" <?php echo $selected; ?> ><?php echo $rkategori["nama_kategori"]; ?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
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

                    <div class="col-xs-4">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-check-square-o"></i> Lainnya</h3>
                            </div>
                            <div class="box-body">
                                <ul class="nav nav-stacked">
                                    <li><a href="../menulis?x=buku&idx=<?php echo $buku["buku_id"] ?>"><i class="fa fa-check-square"></i> Informasi Penulis</a></li>
                                    <li><a href="../menerbitkan?x=buku&idx=<?php echo $buku["buku_id"] ?>"><i class="fa fa-check-square"></i> Informasi Penerbit</a></li>
                                    <?php
                                        $keteranganupload = "";
                                        if(strlen($buku["url_ebook"])!=0){
                                            $keteranganupload = "<b><i>Ebook tersedia...</i></b>";
                                        }
                                    ?>
                                    <li><a href="./uploadbuku.php?x=buku&idx=<?php echo $buku["buku_id"] ?>"><i class="fa fa-check-square"></i> Upload E-Book <?php echo $keteranganupload; ?></a></li>
                                </ul>
                            </div>
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