<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>
    <h1 class="h3 d-inline align-middle"></h1>
    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">
            <li class="nav-item dropdown">
                <div class="row">
                    <a class="nav-link d-none d-sm-inline-block" data-bs-toggle="dropdown">
                        <span class="text-dark"><?php echo $usuario ?></span>
                        <i class="align-middle" data-feather="chevron-down"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="../help.php"><i class="align-middle me-1" data-feather="help-circle"></i> Ayuda</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="./php/cerrar_sesion.php"><i class="align-middle me-1" data-feather="log-out"></i>Cerrar sesión</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>