    <header class="main-header">
        <a href="../" class="logo">
            <i class="fa fa-thumbs-o-up"></i>
            <span class="logo-lg"><b><?php echo $app_title; ?></b></span>
        </a>
        <nav class="navbar navbar-static-top">
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class=""><a href="../index.php">Beranda</a></li>
                    <li><a href="./Koleksi_buku.php">Koleksi Buku</a></li>
                    <li><a href="./Koleksi_ebook.php">Koleksi Ebook</a></li>
                    <li><a href="../login_member.php"><?php echo $judulMenuLogin; ?></a></li>

                    <?php
                    if(cekStatusLogin()){
                    ?>

                    <li><a href="../Logout.php">Sign out</a></li>

                    <?php
                    }
                    ?>
                    <!--
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                            <li class="divider"></li>
                            <li><a href="#">One more separated link</a></li>
                        </ul>
                    </li>
                    -->
                </ul>
            </div>
        </nav>
    </header>