<?php
    session_start();
    include_once("../../conf/database.php");
    include_once("../../conf/general.php");
    include_once("../../function/func_login.php");
    include_once("../../function/func_buku.php");
    include_once("../../function/func_menerbitkan.php");
    include_once("../../function/func_penerbit.php");


    if(!cekStatusLogin()){
        header("location:../../");
    }

    $pesan= "";
    if(isset($_SESSION["info_delete"])){
        if(!empty($_SESSION["info_delete"])){
            $pesan = $_SESSION["info_delete"];
            unset($_SESSION["info_delete"]);
        }
    }  

    $buku = array();
    if(isset($_GET["idx"])){    //jika idnya di set
        $data = tampilDataBukuById($conn, $_GET["idx"]);
        if($data["buku_id"]!=0){   // cek apakah id ada di data buku
            $buku["buku_id"] = $data["buku_id"];
            $buku["kode_buku"] = $data["kode_buku"];
            $buku["nama_buku"] = $data["nama_buku"];
            $buku["barcode"] = $data["barcode"];
            $buku["isbn"] = $data["isbn"];
            $buku["kategori_buku_id"] = $data["kategori_buku_id"];
        }else{      //jika tidak ditemukan redirect ke tampil buku
            header("location:../buku?x=buku");
        }
    }

    $penerbitId = 0;
    $tahunTerbit = date("Y");;
    if(isset($_POST["btnsimpan"])){
        $penerbitId = amankanInputan($conn, $_POST["txt_penerbit_id"]);
        $tahunTerbit = amankanInputan($conn, $_POST["txt_tahun_terbit"]);
        //simpan data 
        if(simpanMenerbitkan($conn, $buku["buku_id"], $penerbitId, $tahunTerbit)){
            $pesan = "Data berhasil disimpan";
        }else{
            $pesan = "Data gagal disimpan";
        }
    }

    if(isset($_GET["act"])){
        if($_GET["act"]=="del"){
            $id = amankanInputan($conn, $_GET["idxdel"]);
            //jika tidak ada data peminjamannya maka lakukan delete
            if(hapusMenerbitkan($conn, $id)){
                $_SESSION["info_delete"]= "Data penerbit telah dihapus.";
            }else{
                $_SESSION["info_delete"]= "Data penerbit gagal dihapus.";
            }
        }
        header("location:./?x=buku&idx=". $buku["buku_id"]);
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
                    <li class="active">Detail Buku - Penerbit</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">
                    <div class="col-xs-6">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-check-square-o"></i> Penerbit</h3>
                            </div>
                            <div class="box-body">
                                <table class="table table-condensed">
                                    <tr>
                                        <td colspan="2"><b>Penerbit untuk buku:</b></td>
                                    </tr>
                                    <tr>
                                        <td width="100px">&nbsp;&nbsp;&nbsp;Kode Buku</td>
                                        <td>: <?php echo $buku["kode_buku"] ?></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp;Nama Buku</td>
                                        <td>: <?php echo $buku["nama_buku"] ?></td>
                                    </tr>
                                </table>
                                <br/>
                                <form method="post" action="">
                                    <input type="hidden" id="tmp_id" value="">
                                    <table class="table table-condensed">
                                        <tr>
                                            <td colspan="2"><b>Daftar Penerbit:</b></td>
                                        </tr>
                                        <?php
                                            $rmenerbitkan = tampilMenerbitkan($conn, $buku["buku_id"]);
                                            while($data = mysqli_fetch_array($rmenerbitkan)){
                                        ?>
                                        <tr>
                                            <td>
                                                &nbsp;&nbsp;&nbsp;<?php echo "<b>[" . $data["tahun_terbit"] . "]</b> : " . $data["nama_penerbit"]; ?>
                                            </td>
                                            <td>
                                                <a href="#" data-toggle="modal" data-target="#modal-default" class="fa fa-close" onclick="cmdSetTempId('<?php echo $data["menerbitkan_id"]; ?>')"></a>
                                            </td>
                                        </tr>
                                        <?php
                                            }
                                        ?>
                                        <tr>
                                            <td colspan="2">
                                                <select class="form-control" name="txt_penerbit_id">
                                                <?php
                                                    $rpenerbit = daftarPenerbit($conn, "", "nama_penerbit asc");
                                                    while($data = mysqli_fetch_array($rpenerbit)){
                                                        $selected = "";
                                                        if($penerbitId==$data["penerbitId"]){
                                                            $selected = "selected";
                                                        }
                                                ?>
                                                    <option value="<?php echo $data["penerbit_id"];?>" <?php echo $selected; ?> > <?php echo $data["nama_penerbit"];?></option>
                                                <?php
                                                    }
                                                ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <input class="form-control" id="txt_tahun_terbit" name="txt_tahun_terbit" placeholder="Tahun Terbit" type="text" value="<?php echo $tahunTerbit; ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <button type="submit" class="btn btn-primary" name="btnsimpan">Simpan</button>
                                                <a href="../buku/ubah_buku.php?x=buku&idx=<?php echo $buku["buku_id"]; ?>" class="btn btn-danger" name="">Kembali</a>
                                            </td>
                                        </tr>
                                    </table>
                                </form>
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
                                    <h4 class="modal-title">Konfirmasi</h4>
                                </div>
                                <div class="modal-body">
                                    <p>
                                        Anda yakin data akan dihapus?
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" onClick="cmdDelete()">Ya</button>
                                    <button type="button" class="btn btn-primary"  data-dismiss="modal">Tidak</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal modal-default fade" id="modal-success">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button id="cmdclose" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Konfirmasi</h4>
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
            function cmdDelete(){
                oidx = document.getElementById("tmp_id").value;
                window.location = "./?x=buku&act=del&idx=<?php echo $buku["buku_id"]; ?>&idxdel=" + oidx;
            }

            function cmdSetTempId(idx){
                document.getElementById("tmp_id").value = idx;
            }
        </script>

        <?php if(!empty($pesan)){ ?>
            <script>
                $("#modal-success").modal('show');
                setTimeout(function(){
                    $("#modal-success").modal('hide');
                }, 2000);
            </script>
        <?php } ?>


</body>
</html>