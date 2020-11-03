<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="dist/img/giphy.gif" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light lead"><?php echo $cfg['side_title']; ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <?php
                switch($menu) {
                    case 1:
                        echo'
                        <li class="nav-item">
                            <a href="inicio" class="nav-link active">
                                <i class="fas fa-home nav-icon"></i>
                                <p>In&iacute;cio</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="cliente" class="nav-link">
                                  <i class="fas fa-user-tie nav-icon"></i>
                                <p>Cliente</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="situacao" class="nav-link">
                                <i class="fas fa-tag nav-icon"></i>
                                <p>Situa&ccedil;&atilde;o</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="usuario" class="nav-link">
                                <i class="fas fa-user nav-icon"></i>
                                <p>Usu&aacute;rio</p>
                            </a>
                        </li>';
                        break;
                    case 2:
                        echo'
                        <li class="nav-item">
                            <a href="inicio" class="nav-link">
                                <i class="fas fa-home nav-icon"></i>
                                <p>In&iacute;cio</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="cliente" class="nav-link active">
                                <i class="fas fa-user-tie nav-icon"></i>
                                <p>Cliente</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="situacao" class="nav-link">
                                <i class="fas fa-tag nav-icon"></i>
                                <p>Situa&ccedil;&atilde;o</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="usuario" class="nav-link">
                                <i class="fas fa-user nav-icon"></i>
                                <p>Usu&aacute;rio</p>
                            </a>
                        </li>';
                        break;
                    case 3:
                        echo'
                        <li class="nav-item">
                            <a href="inicio" class="nav-link">
                                <i class="fas fa-home nav-icon"></i>
                                <p>In&iacute;cio</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="cliente" class="nav-link">
                                <i class="fas fa-user-tie nav-icon"></i>
                                <p>Cliente</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="situacao" class="nav-link active">
                                <i class="fas fa-tag nav-icon"></i>
                                <p>Situa&ccedil;&atilde;o</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="usuario" class="nav-link">
                                <i class="fas fa-user nav-icon"></i>
                                <p>Usu&aacute;rio</p>
                            </a>
                        </li>';
                        break;
                    case 4:
                        echo'
                        <li class="nav-item">
                            <a href="inicio" class="nav-link">
                                <i class="fas fa-home nav-icon"></i>
                                <p>In&iacute;cio</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="cliente" class="nav-link">
                                <i class="fas fa-user-tie nav-icon"></i>
                                <p>Cliente</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="situacao" class="nav-link">
                                <i class="fas fa-tag nav-icon"></i>
                                <p>Situa&ccedil;&atilde;o</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="usuario" class="nav-link active">
                                <i class="fas fa-user nav-icon"></i>
                                <p>Usu&aacute;rio</p>
                            </a>
                        </li>';
                        break;
                    default:
                        echo'
                        <li class="nav-item">
                            <a href="inicio" class="nav-link">
                                <i class="fas fa-home nav-icon"></i>
                                <p>In&iacute;cio</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="cliente" class="nav-link">
                                <i class="fas fa-user-tie nav-icon"></i>
                                <p>Cliente</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="situacao" class="nav-link">
                                <i class="fas fa-tag nav-icon"></i>
                                <p>Situa&ccedil;&atilde;o</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="situacao" class="nav-link">
                                <i class="fas fa-user nav-icon"></i>
                                <p>Usu&aacute;rio</p>
                            </a>
                        </li>';
                        break;
              }
            ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>