<?php
    session_start();
    include_once("../../conf/database.php");
    include_once("../../conf/general.php");
    include_once("../../function/func_login.php");
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

    if(isset($_GET["act"])){
        if($_GET["act"]=="del"){
            $id = amankanInputan($conn, $_GET["idx"]);
            $sudahterpakai = cekPenerbitDiDataBuku($conn, $id);
            if($sudahterpakai==0){
                //jika tidak ada data peminjamannya maka lakukan delete
                if(hapusPenerbit($conn, $id)){
                    $_SESSION["info_delete"]= "Data penerbit telah dihapus.";
                }else{
                    $_SESSION["info_delete"]= "Data penerbit gagal dihapus.";
                }
            }else{
                $_SESSION["info_delete"]= "Data tidak dapat dihapus, <br/>karena sudah terpakai pada data buku.";
            }
        }
        header("location:./?x=buku");
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
                    <li class="active">Penerbit</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-check-square-o"></i> Data Penerbit</h3>
                            </div>
                            <div class="box-body">
                                <input type="hidden" id="tmp_id" value="">
                                <table id="tblbrg" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                            $rpenerbit = daftarPenerbit($conn, "", "nama_penerbit asc");
                                            while($data = mysqli_fetch_array($rpenerbit)){
                                        ?>

                                        <tr>
                                            <td><?php echo $data["nama_penerbit"]; ?></td>
                                            <td><?php echo $data["alamat_penerbit"]; ?></td>
                                            <td>
                                                <a href="./ubah_penerbit.php?x=buku&idx=<?php echo $data["penerbit_id"]; ?>" class="fa fa-pencil"></a> &nbsp;
                                                <a href="#" data-toggle="modal" data-target="#modal-default" class="fa fa-close" onClick="cmdSetTempId('<?php echo $data["penerbit_id"]; ?>')"></a>
                                            </td>
                                        </tr>

                                        <?php
                                            }
                                        ?>

                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>

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
        $(function () {
            $('#tblbrg').DataTable({
                dom: 'Bfrtip',
                buttons       : [
                    {
                        text: 'Tambah Penerbit',
                        action: function ( e, dt, node, config ) {
                            window.location = './tambah_penerbit.php?x=buku';
                        }
                    }
                ],
                'paging'      : true,
                'lengthChange': false,
                'searching'   : true,
                'ordering'    : true,
                'info'        : true,
                'autoWidth'   : false,
                "pageLength"  : 5,
                'aoColumns'   : [
                    { sWidth: '200px'},
                    { sWidth: '350px' },
                    { sWidth: '80px' }
                ]
            });
        });
    </script>

        <script>
            function cmdDelete(){
                oidx = document.getElementById("tmp_id").value;
                window.location = "./?x=buku&act=del&idx=" + oidx;
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