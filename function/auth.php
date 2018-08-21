<?php
include "../conf/database.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}

$masuk		=	mysql_query("SELECT * FROM m_pengguna WHERE username='$username' AND password=md5('".$pass."' AND hak_akses='admin'");
$find		=	mysql_num_rows($masuk);
$r=mysql_fetch_array($masuk);

if ($find > 0){
  session_start();

  $_SESSION['username']     = $r['username'];
  $_SESSION['password']     = $r['password'];
  $_SESSION['login'] 			= 1;
  
  echo '
		<html>
		<head>
		<title>Login Berhasil</title>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<meta HTTP-EQUIV="REFRESH" content="3; url=home">
		<link href="style.css" rel="stylesheet" type="text/css" />
		</head>
		<body>
		<div id="all">
		<div id="main">
		<div class="centerblock">
		<div class="register stepbystep container content-block">
		<div class="body">
		<h2>Login Berhasil</h2>
		<p>Selamat Datang <strong>'.$username.'</strong>. Halaman Akan Redirect Dalam 3 Detik</p>
		</div>
		</div>
		</div>
		</div>
		</div>
		</body>
		</html>
  ';
}
else{
 echo '
		<html>
		<head>
		<title>Login Gagal</title>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<meta HTTP-EQUIV="REFRESH" content="2; url=../login">
		<link href="style.css" rel="stylesheet" type="text/css" />
		</head>
		<body>
		<div id="all">
		<div id="main">
		<div class="centerblock">
		<div class="register stepbystep container content-block">
		<div class="body">
		<h2>Login Gagal</h2>
		<p>Login Gagal! Silahkan Cek Username / Password Anda.</p>
		</div>
		</div>
		</div>
		</div>
		</div>
		</body>
		</html>
  ';
}
?>
