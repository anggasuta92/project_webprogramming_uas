<?php
    session_start();
    include_once("../../conf/database.php");
    include_once("../../conf/general.php");
    include_once("../../function/func_login.php");
    include_once("../../function/func_pengguna.php");

    if(!cekStatusLogin()){
        header("location:../../");
    }

    $pengguna[] = array();
    $pesan = "";
    if(isset($_POST["simpan"])){
		$pengguna["username"] = amankanInputan($conn, $_POST["txt_username"]);
		$pengguna["nama_lengkap"] = amankanInputan($conn, $_POST["txt_nama_lengkap"]);
		$pengguna["hak_akses"] = amankanInputan($conn, $_POST["txt_hak_akses"]);
		$pengguna["aktif"] = amankanInputan($conn, $_POST["txt_aktif"]);
		
		$pengguna["password"] = amankanInputan($conn, $_POST["txt_password"]);
		$pengguna["password_confirm"] = amankanInputan($conn, $_POST["txt_password_confirm"]);
		$pengguna["tanggal_terdaftar"] = date('Y-m-d');
		
		$simpan["info"] = "";
		$simpan["detail"] = "";
		if($pengguna["password"]==$pengguna["password_confirm"]){
			$pengguna["password"] = md5($pengguna["password"]);
			$simpan = simpanPengguna($conn, $pengguna);
		}else{
			$simpan["info"] = "error";
			$simpan["detail"] = "Gagal disimpan, password tidak sesuai..";
		}
		
        if($simpan["info"]=="sukses"){
            $_SESSION["info"] = $simpan["detail"];
            header("location:./ubah_pengguna.php?idx=" . $simpan["pengguna_id"]);
        }else{
            $pesan = $simpan["detail"];
        }
    }else{
		$pengguna["username"] = "";
		$pengguna["nama_lengkap"] = "";
		$pengguna["hak_akses"] = "";
		$pengguna["aktif"] = "";
		
		$pengguna["password"] = "";
		$pengguna["password_confirm"] = "";
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
                    <li class="active">Kategori Buku</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">
                    <div class="col-xs-6">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-check-square-o"></i> Tambah Kategori Buku</h3>
                            </div>
                            <form class="form-horizontal" method="post" action="">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="txt_nama_kategori" class="col-sm-3 control-label">Username</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="txt_nama_kategori" name="txt_username" placeholder="Username" type="text" value="<?php echo $pengguna["username"]; ?>" required >
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txt_password" class="col-sm-3 control-label">Password</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="txt_password" name="txt_password" placeholder="Password" type="password" value=""  >
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txt_password" class="col-sm-3 control-label">Re-type Password</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="txt_password" name="txt_password_confirm" placeholder="Re-type Password" type="password" value="" >
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txt_nama_kategori" class="col-sm-3 control-label">Nama Lengkap</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="txt_nama_kategori" name="txt_nama_lengkap" placeholder="Nama Lengkap" type="text" value="<?php echo $pengguna["nama_lengkap"]; ?>" required>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txt_nama_kategori" class="col-sm-3 control-label">Hak Akses</label>
                                        <div class="col-sm-9">
											<?php
												$memberselect = "";
												$adminselect = "";
												if($pengguna["hak_akses"]=="admin"){
													$adminselect = "selected";
												}else{
													$memberselect = "selected";
												}
											?>
                                            <select name="txt_hak_akses" class="form-control">
												<option value="admin" <?php echo $adminselect; ?> >Admin</option>
												<option value="member" <?php echo $memberselect; ?> >Member</option>
											</select>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txt_nama_kategori" class="col-sm-3 control-label">Status</label>
                                        <div class="col-sm-9">
											<?php
												$aktif = "";
												$nonaktif = "";
												if($pengguna["aktif"]==1){
													$aktif = "selected";
												}else{
													$nonaktif = "selected";
												}
											?>
                                            <select name="txt_aktif" class="form-control">
												<option value="0"  <?php echo $nonaktif; ?>  >Non Aktif</option>
												<option value="1"  <?php echo $aktif; ?>  >Aktif</option>
											</select>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <a href="./" class="btn btn-default">Kembali</a>
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