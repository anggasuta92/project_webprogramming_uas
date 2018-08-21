    <?php
        $username_menu = getNamaPengguna($conn, $_SESSION["uid"]);
    ?>    
    <header class="main-header">
        <a href="../home/" class="logo">
            <span class="logo-lg">
                <i class="glyphicon glyphicon-fire"></i>
                <b><?php echo $app_title; ?></b>
            </span>
        </a>
        <nav class="navbar navbar-static-top">
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="hidden-xs">Hi, <?php echo $username_menu; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <p>
                                <?php echo $username_menu; ?>
                            </p>
                        </li>
                        <li class="user-footer">
                                <a href="../logout.php" class="btn btn-default btn-flat">Sign out</a>
                        </li>
                    </ul>
                </li>
                <li>
                <a href="#" data-toggle="control-sidebar">&nbsp;</a>
                </li>
            </ul>
            </div>
        </nav>
    </header>