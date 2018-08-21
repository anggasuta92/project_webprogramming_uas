    <?php
        $mnbk = "";
        if(isset($_GET['x'])){
            if($_GET["x"]=="buku"){
                $mnbk = "active";
            }
        }
    ?>
    <aside class="main-sidebar">
        <section class="sidebar">
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">MAIN NAVIGATION</li>
                <li>
                    <a href="../home/">
                        <i class="fa fa-home"></i> <span>Home</span>
                    </a>
                </li>
                <li class="header">Data Master</li>
                <li class="treeview <?php echo $mnbk; ?> ">
                    <a href="#">
                        <i class="fa fa-list"></i> <span>Buku</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="../kategori/?x=buku"><i class="fa fa-book"></i> Kategori</a></li>
                        <li><a href="../buku/?x=buku"><i class="fa fa-book"></i> Buku</a></li>
                        <li><a href="../penulis/?x=buku"><i class="fa fa-pencil"></i> Penulis</a></li>
                        <li><a href="../penerbit/?x=buku"><i class="fa fa-truck"></i> Penerbit</a></li>
                    </ul>
                </li>
                <li>
                    <a href="../anggota">
                        <i class="fa fa-user-plus"></i> <span>Anggota</span>
                    </a>
                </li>
                <li>
                    <a href="../pengguna">
                        <i class="fa fa-user"></i> <span>Pengguna</span>
                    </a>
                </li>
                <li class="header">Transaksi</li>
                <li>
                    <a href="../peminjaman">
                        <i class="fa fa-home"></i> <span>Peminjaman</span>
                    </a>
                </li>
                <li>
                    <a href="../pengembalian">
                        <i class="fa fa-home"></i> <span>Pengembalian</span>
                    </a>
                </li>
                <li class="header">Laporan</li>
                <li>
                    <a href="../laporan/laporan_buku.php">
                        <i class="fa fa-report"></i> <span>Laporan Buku</span>
                    </a>
                </li>
                <li>
                    <a href="../laporan/laporan_peminjaman.php">
                        <i class="fa fa-home"></i> <span>Laporan Peminjaman</span>
                    </a>
                </li>
            </ul>
        </section>
    </aside>