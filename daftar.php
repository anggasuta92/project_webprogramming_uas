<?php
    session_start();
    include_once("./conf/database.php");
    include_once("./conf/general.php");
    include_once("./function/func_login.php");

	if(cekStatusLogin()){
		header("location:./admin_page/");
	}

	$pesan = "";
	$sukses = 0;

    if(isset($_POST['submit'])){
		$username	=	$_POST['username'];
		$password1	=	md5($_POST['password']);
		$password2	=	md5($_POST['password2']);

		if(empty($username)){
			$pesan = "Username tidak boleh kosong.";
		}
		else{
			if($password1==$password2){
				$query = mysqli_query($conn,"insert into m_pengguna(username,password, hak_akses, aktif) values ('$username','$password1','user','1')");
				$pesan = "Pendaftaran berhasil.<br/>Anda akan diarahkan ke menu login.";
				$sukses = 1;
			}else{
				$pesan = "Password anda tidak sesuai.";
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

    <link rel="stylesheet" href="./asset/admilte_component/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./asset/admilte_component/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="./asset/admilte_component/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="./asset/admilte_component/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="./asset/admilte_component/plugins/iCheck/square/blue.css">

    <script src="./asset/admilte_component/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="./asset/admilte_component/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="./asset/admilte_component/plugins/iCheck/icheck.min.js"></script>

</head>
<body class="hold-transition login-page">

<div class="login-box">
	<div class="login-logo">
		<a href="">
			<i class="glyphicon glyphicon-fire"></i>
			<strong>
				<?php echo $app_title; ?>
			</strong>
		</a>
	</div>
	
	<div class="login-box-body">
		<!-- <p class="login-box-msg">Silahkan masuk untuk memulai sesi</p> -->
		<form action="" method="post" name="">
			<div class="form-group has-feedback">
				<input name="username" type="text" value="" id="username" class="form-control" placeholder="Type Username">
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			</div>
			<div class="form-group has-feedback">
				<input name="password" type="password" value="" id="password" class="form-control" placeholder="Type Password">
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			</div>
			<div class="form-group has-feedback">
				<input name="password2" type="password" value="" id="password2" class="form-control" placeholder="Type Password Again">
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			</div>
			<div class="row">
				<div class="col-xs-8">
				</div>
				<div class="col-xs-4">
				<input type="submit" class="btn btn-primary btn-block btn-flat" name="submit" value="DAFTAR"></input>
				</div>
			</div>
		</form>
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


</div>

    <script>
    $(function () {
        $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' /* optional */
        });
    });
    </script>

    <?php if(!empty($pesan)){ ?>
    <script>
        $('.modal').modal('show');
        setTimeout(function(){
            $("#cmdclose").click();
			<?php
				if($sukses==1){
			?>
				window.location = "./login_member.php";
			<?php
				}
			?>
        }, 3000);
    </script>
    <?php } ?>

</body>
</html>