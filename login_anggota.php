<?php
    session_start();
    include_once("./conf/database.php");
    include_once("./conf/general.php");
    include_once("./function/func_login.php");

	if(cekStatusLogin()){
		header("location:./admin_page/");
	}

    if(isset($_POST['submit'])){
		$username = $_POST["username"];
		$password = $_POST["password"];
		$result = cekLogin($conn, $username, $password);
		if($result["info"]=="sukses"){
			header("location:./admin_page/");
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
				<input type="text" name="username" class="form-control" placeholder="Username">
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			</div>
			<div class="form-group has-feedback">
				<input type="password" name="password" class="form-control" placeholder="Password">
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			</div>
			<div class="row">
				<div class="col-xs-8">
				</div>
				<div class="col-xs-4">
				<input type="submit" class="btn btn-primary btn-block btn-flat" name="submit" value="Masuk"></input>
				</div>
			</div>
		</form>
		<a href="./">
			<i class="fa fa-mail-reply"></i>
			Kembali ke halaman utama.
		</a>
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
</body>
</html>