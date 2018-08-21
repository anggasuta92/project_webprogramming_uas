<?php
    session_start();
    include_once("./conf/database.php");
    include_once("./conf/general.php");
    include_once("./function/func_login_member.php");
    include_once("./function/func_login.php");
    include_once("./function/func_buku.php");

    $judulMenuLogin = "Login Member";
    $logedin = 0;
    if(cekStatusLoginMember() || cekStatusLogin()){
        $judulMenuLogin = "Hi, " . getNamaPengguna($conn, $_SESSION["user"]);
        $logedin  =1;
    }

    $total_koleksi_buku = number_format(getJumlahSemuaBuku($conn),0);
?>
<!DOCTYPE html>
<html>
<head>
    <title>
        <?php echo $app_title; ?>
    </title>
     <!-- Mobile Specific Meta -->
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="css/atriun.css">
    <link href='http://fonts.googleapis.com/css?family=Ruda' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
    
    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
    <noscript><link rel="stylesheet" href="css/no-js.css"></noscript>
    
    <!-- Favicons -->
    <link rel="shortcut icon" href="images/favicon.ico">
    
    <!-- JavaScript -->
    <script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
    <script type='text/javascript' src='js/bootstrap.min.js'></script>
    <script type="text/javascript" src="js/jquery-easing.js"></script>
    <script type='text/javascript' src='js/jquery.placeholder.min.js'></script>
    <script type='text/javascript' src='js/jquery.flexslider-min.js'></script>
    <script type="text/javascript" src="js/main.js"></script>
</head>
<body class="hold-transition skin-blue layout-boxed">
    <div class="wrapper" style="background-color:#d2d6de;">
        <?php include("./template/navbar.php"); ?>
    <div id="slider">
  <div class="slider-overlay">
   <div class="flexslider loading">
    <ul class="slides">
    <?php if($logedin==0){ ?>
     <li>
      <p>
       <a href="daftar.php" class="btn-link btn-link-half">Daftar</a>
       <a href="login_member.php" class="btn-link btn-link-half">Login</a>
      </p>
     </li>
    <?php }else{ ?>
    <li>
      <p>
       <a href="logout.php" class="btn-link btn-link-half">Log Out</a>
      </p>
     </li>
    <?php } ?>

    </ul>
   </div> <!-- End Flexslider -->
  </div> <!-- End Slider-Overlay -->
 </div> <!-- End Slider -->
 
 <div id="main">
  
  <div class="features" id="fitur">
   <div class="container">
    
    <div class="header">
     <div class="base-header">
      <h2>Fitur SipLine</h2>
     </div>
     <p>Kami akan berusaha memberikan pelayanan terbaik untuk kenyamanan dan pengalaman peminjaman buku anda</p>
    </div> <!-- End Header -->
    
    <div class="flexslider loading">
     <ul class="slides">
    
      <li class="row-fluid">
       <div class="span4 item"> <!-- One -->
        <img src="images/features/application.png" alt="Feature" />
        <h4>Koleksi Buku</h4>
        <p>Tersedia berbagai daftar buku yang dapat anda pinjam di Sistem Informasi Perpustakaan Online (SIPLINE)</p>
       </div>
       <div class="span4 item"> <!-- Two -->
        <img src="images/features/security_lock.png" alt="Feature" />
        <h4>Koleksi E-book</h4>
        <p>Bagi anda yang tidak ingin repot dengan beratnya buku-buku yang kami sediakan, anda bisa download kumpulan E-book Disini</p>
        </div>
       <div class="span4 item"> <!-- Three -->
        <img src="images/features/load_download.png" alt="Feature" />
        <h4>Peminjaman Buku</h4>
        <p>Fitur utama kami yang memungkinkan bagi anda untuk meminjam buku di Sistem Informasi Perpustakaan Online (SIPLINE)</p>
        </div>
      </li> <!-- End Row-Fluid -->
      </ul>
     </div> <!-- End Flexslider -->
   </div> <!-- End Container -->
  </div> <!-- End Features -->

  <div class="contact" id="contact">
   <div class="container">
    
    <h2>Hubungi Kami</h2>
    <p>Jika anda mengalami masalah terkait ujian online silahkan hubungi kami.</p>
    
    <form id="contact-form" method="post" action="#">
    
     <div class="row-fluid">
      <div class="span5">
       <input type="text" name="name" maxlength="80" required="required" placeholder="Masukan Nama Anda" />
       <input type="text" name="email" maxlength="255" required="required" placeholder="Masukan Email Anda" />
       <input type="text" name="subject" placeholder="Tulis Subyek Pesan" required="required" />
      </div>
      <div class="span7">
       <textarea name="message" placeholder="Tulis Pesan Disini Untuk Dikirim Kepada Kami" required="required"></textarea>
      </div>
     </div> <!-- End Row-Fluid -->
     
     <input type="submit" name="submit" value="Send Message" class="btn pull-right" />
     <div class="data-status" style="display:none;"></div> <!-- data submit status -->
     
    </form>
   </div> <!-- End Container -->
  </div> <!-- End Contact -->
  
  <div class="tweets">
  </div> <!-- End Tweets -->
  
 </div> <!-- End Main -->
</body>
</html>