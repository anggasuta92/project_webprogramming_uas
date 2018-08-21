<?php
    session_start();
    include_once("../conf/database.php");
    include_once("../conf/general.php");
    include_once("../function/func_login_member.php");
    include_once("../function/func_login.php");
    include_once("../function/func_buku.php");

    $judulMenuLogin = "Login Member";
    if(cekStatusLoginMember() || cekStatusLogin()){
        $judulMenuLogin = "Hi, " . getNamaPengguna($conn, $_SESSION["user"]);
    }

    $total_koleksi_buku = number_format(getJumlahSemuaBuku($conn),0);
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

    <link rel="stylesheet" href="../asset/admilte_component/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../asset/admilte_component/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../asset/admilte_component/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="../asset/admilte_component/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="../asset/admilte_component/bower_components/datatables.net-bs/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="../asset/admilte_component/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../asset/admilte_component/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="../asset/admilte_component/plugins/iCheck/square/blue.css">

    <script src="../asset/admilte_component/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="../asset/admilte_component/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../asset/admilte_component/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../asset/admilte_component/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../asset/admilte_component/bower_components/datatables.net-bs/js/dataTables.buttons.min.js"></script>
    <script src="../asset/admilte_component/dist/js/adminlte.min.js"></script>

</head>
<body class="hold-transition skin-blue layout-boxed">

    <div class="wrapper" style="background-color:#d2d6de;">
        <?php include("./template/navbar.php"); ?>
        <!-- Main content -->
        <section class="content">
            <div class="box">
            <div class="box-header">
              <h3>Koleksi Buku</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <td>Kode Buku</td>
                  <td>Nama Buku</td>
                  <td>Barcode</td>
                  <td>Isbn</td>
                </tr>
                </thead>
                <tbody>

                <?php
              
                    $query = mysqli_query($conn, "SELECT * FROM m_buku");
                    while($data = mysqli_fetch_array($query)) {
                        
                ?>

                <tr>
                  <td><?php echo $data['kode_buku'] ?></td>
                  <td><?php echo $data['nama_buku'] ?></td>
                  <td><?php echo $data['barcode'] ?></td>
                  <td><?php echo $data['isbn'] ?></td>            
                </tr>

                <?php
                }
                ?>
                </tbody> 
              </table>
            </div>
            </div>
        </section>
    </div>
    <script>
        $(function () {
        $('#example1').DataTable({
          'paging'      : true,
          'lengthChange': true,
          'searching'   : true,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : true,
                "pageLength"  : 10,
                'aoColumns'   : [
                    { sWidth: '100px' },
                    { sWidth: '150px' },
                    { sWidth: '300px' },
                    { sWidth: '60px' }
                ]
        });
        });
    </script>
</body>
</html>