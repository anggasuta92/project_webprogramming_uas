<?php
    session_start();
    include_once("../../conf/database.php");
    include_once("../../conf/general.php");
    include_once("../../function/func_login.php");
    include_once("../../function/func_buku.php");
    include_once("../../function/func_anggota.php");
    include_once("../../function/func_peminjaman.php");

    if(!cekStatusLogin()){
        header("location:../../");
    }

    $pesan = "";
    $anggotaKetemu = 0;
    $kodeAnggota = "";
    $tanggalKembali = date('Y-m-d');
    if(isset($_POST["btncari"])){
        if(isset($_POST["txt_kode_anggota"])){
            $kodeAnggota = amankanInputan($conn, $_POST["txt_kode_anggota"]);
            $anggota = findAnggotaByKode($conn, $kodeAnggota);
            if($anggota["anggota_id"]!=0){  //anggota ketemu
                $anggotaKetemu = 1;
                if(isset($_POST["txt_peminjaman_id"]) && !empty($_POST["txt_peminjaman_id"])){  //jika isi buku maka simpan peminjaman
                    $pj = getInfoPinjam($conn, amankanInputan($conn, $_POST["txt_peminjaman_id"]));

                    if($pj["peminjaman_id"]!=0){
                        $tanggalKembali = amankanInputan($conn, $_POST["txt_tanggal_kembali"]);
                        $lamapinjam = selisihtanggal($tanggalKembali, $pj["tanggal_pinjam"]);
                        $terlambat = $lamapinjam - $max_pinjam;
                        $denda = 0;
                        if($terlambat>0){
                            $denda = $total_denda * $terlambat;
                        }else{
                            $terlambat = 0;
                        }
                        $peminjaman["peminjaman_id"] = $pj["peminjaman_id"];
                        $peminjaman["tanggal_kembali"] = $tanggalKembali;
                        $peminjaman["denda"] = $denda;
                        $peminjaman["kembali_pengguna_id"] = $_SESSION["uid"];

                        simpanPengembalian($conn, $peminjaman);
                        ubahStokBuku($conn, 1, $pj["buku_id"]);

                        $bk = tampilDataBukuById($conn, $pj["buku_id"]);
                        $pesan = "
                            <table class=\"table table-condensed\">
                                <tr>
                                    <td colspan=\"2\">Buku telah dikembalikan</td>
                                </tr>
                                <tr>
                                    <td>Kode</td>
                                    <td>: ".$bk["kode_buku"]."</td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td>: ".$bk["nama_buku"]."</td>
                                </tr>
                                <tr>
                                    <td>Lama Peminjaman</td>
                                    <td>: ".$lamapinjam." hari</td>
                                </tr>
                                <tr>
                                    <td>Keterlambatan</td>
                                    <td>: ".$terlambat." hari dari ".$max_pinjam ." hari</td>
                                </tr>
                                <tr>
                                    <td>Denda</td>
                                    <td>: Rp. ".$denda."</td>
                                </tr>
                            </table>
                        ";
                    }
                }
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
                    <small>Peminjaman</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    <li class="active">Peminjaman</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-check-square-o"></i> Input Pengembalian</h3>
                            </div>
                            <div class="box-body">
                                <form id="frmpinjam" name="frmpinjam" action="" method="post">
                                    <input type="hidden" name="txt_peminjaman_id" id="txt_peminjaman_id" value="">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <div class="input-group margin">
                                                <input type="text" class="form-control" name="txt_kode_anggota" placeholder="Masukkan kode anggota" value="<?php echo $kodeAnggota; ?>" required>
                                                    <span class="input-group-btn">
                                                        <button type="submit" class="btn btn-info btn-flat" id="btncari" name="btncari" value="sbmtkdanggota">Cari!</button>
                                                    </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- ini muncul ketika sudah klik search dan kode anggota ketemu -->


                                    <?php if($anggotaKetemu==1){ ?>
                                    <div class="row">
                                        <div class="col-xs-12"><hr/></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <table class="table table-condensed">
                                                <tr>
                                                    <td>Kode Anggota</td>
                                                    <td>: <?php echo $anggota["kode_anggota"]; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Nama Anggota</td>
                                                    <td>: <?php echo $anggota["nama_anggota"]; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Anggota Sejak</td>
                                                    <td>: <?php echo $anggota["tgl_menjadi_anggota"]; ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-xs-8">
                                            <div class="col-xs-4"></div>
                                            <div class="col-xs-8">
                                                <div class="form-group">
                                                    <label for="txt_tanggal_kembali" class="col-sm-4 control-label">Tanggal Kembali</label>
                                                    <div class="col-sm-8">
                                                        <div class="input-group date">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-calendar"></i>
                                                            </div>
                                                            <input class="form-control pull-right" name="txt_tanggal_kembali" id="datepicker" type="text" value="<?php echo $tanggalKembali; ?>" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">&nbsp;</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <table id="tblbrg" class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Kode</th>
                                                        <th>Nama Buku</th>
                                                        <th>Tgl Pinjam</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                        $rpinjam = daftarPeminjaman($conn, "tanggal_kembali is null", "tanggal_pinjam asc");
                                                        while($data = mysqli_fetch_array($rpinjam)){
                                                            $buku = tampilDataBukuById($conn, $data["buku_id"]);
                                                    ?>

                                                    <tr>
                                                        <td><?php echo $buku["kode_buku"]; ?></td>
                                                        <td><?php echo $buku["nama_buku"]; ?></td>
                                                        <td><?php echo $data["tanggal_pinjam"]; ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary btn-block btn-flat" onClick="kembalikan('<?php echo $data["peminjaman_id"]; ?>')">Kembalikan!</button>
                                                        </td>
                                                    </tr>

                                                    <?php
                                                        }
                                                    ?>

                                                </tbody>

                                                <tfoot>
                                                    <tr>
                                                        <th>Kode</th>
                                                        <th>Nama</th>
                                                        <th>Tgl Pinjam</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>

                                    <?php } ?>
                                </form>
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
        $('#datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
        });

            $(function () {
                $('#tblbrg').DataTable({
                    dom: 'Bfrtip',
                    buttons       : [
                    ],
                    'paging'      : true,
                    'lengthChange': false,
                    'searching'   : true,
                    'ordering'    : true,
                    'info'        : true,
                    'autoWidth'   : false,
                    "pageLength"  : 5,
                    'aoColumns'   : [
                        { sWidth: '100px', "className": "text-center" },
                        { sWidth: '300px' },
                        { sWidth: '100' },
                        { sWidth: '60px' }
                    ]
                });
            });
    </script>

    <script>
        function kembalikan(idx){
            document.getElementById("txt_peminjaman_id").value=idx;
            document.getElementById("btncari").click();
        }
    </script>

        <?php if(!empty($pesan)){ ?>
            <script>
                $("#modal-success").modal('show');
                //setTimeout(function(){
                //    $("#modal-success").modal('hide');
                //}, 3000);
            </script>
        <?php } ?>

</body>
</html>