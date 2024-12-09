<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="#">
            <center>
                <span><img src="./img/icons/fge-icon.png" width="100"></span>
                <span class="align-middle">
                    <h4 style="font-weight: bold; color:white ">Fiscalía General del Estado de Guerrero</h4>
                </span>
            </center>
        </a>
        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Menú
            </li>
            <li class="sidebar-item" id="home">
                <a class="sidebar-link" href="#">
                    <i class="align-middle" data-feather="airplay"></i> <span class="align-middle">Inicio</span>
                </a>
            </li>

            <div class="dropdown-divider"></div>
            <?php
            if ($idRol == 1) {
            ?>
                <li class="sidebar-item" id="registro">
                    <a class="dropdown-item sidebar-link" href="registro_v2.php">
                        <i class="align-middle" data-feather="folder-plus"></i><span class="align-middle">Registrar contrato</span>
                    </a>
                </li>

                <li class="sidebar-item" id="buscar_registros">
                    <a class="dropdown-item sidebar-link" href="buscar_registros.php">
                        <i class="align-middle" data-feather="search"></i><span class="align-middle">Buscar contrato</span>
                    </a>
                </li>

                <li class="sidebar-item" id="consultar_contrato">
                    <a class="dropdown-item sidebar-link" href="visualizador_contratos.php">
                        <i class="align-middle" data-feather="file-text"></i><span class="align-middle">Información del Contrato</span>
                    </a>
                </li>

                <li class="sidebar-item" id="registrar_usuarios">
                    <a class="dropdown-item sidebar-link" href="registrar_usuarios.php">
                        <i class="align-middle" data-feather="user-plus"></i><span class="align-middle">Registrar usuario</span>
                    </a>
                </li>

                <li class="sidebar-item" id="gestion_contratos">
                    <a class="dropdown-item sidebar-link" href="gestion_contratos.php">
                        <i class="align-middle" data-feather="list"></i><span class="align-middle">Gestión de Contratos</span>
                    </a>
                </li>

                <li class="sidebar-item" id="gestion_usuarios">
                    <a class="dropdown-item sidebar-link" href="gestion_usuarios.php">
                        <i class="align-middle" data-feather="users"></i><span class="align-middle">Gestión de Usuarios</span>
                    </a>
                </li>
            <?php
            }
            ?>
            <?php
            if ($idRol == 2) {
            ?>
                <li class="sidebar-item" id="registro">
                    <a class="dropdown-item sidebar-link" href="registro_v2.php">
                        <i class="align-middle" data-feather="folder-plus"></i><span class="align-middle">Registrar contrato</span>
                    </a>
                </li>

                <li class="sidebar-item" id="buscar_registros">
                    <a class="dropdown-item sidebar-link" href="buscar_registros.php">
                        <i class="align-middle" data-feather="search"></i><span class="align-middle">Buscar contrato</span>
                    </a>
                </li>
            <?php
            }
            ?>

            <?php
            if ($idRol == 3) {
            ?>
                <li class="sidebar-item" id="consultar_contrato">
                    <a class="dropdown-item sidebar-link" href="visualizador_contratos.php">
                        <i class="align-middle" data-feather="file-text"></i><span class="align-middle">Información del Contrato</span>
                    </a>
                </li>
            <?php
            }
            ?>
            <li class="sidebar-item">
                <a class="dropdown-item sidebar-link" href="./php/cerrar_sesion.php">
                    <i class="align-middle" data-feather="arrow-left"></i><span class="align-middle">Salir</span>
                </a>
            </li>
        </ul>
    </div>
</nav>

<script>
    let btn1 = document.getElementById("btn1");
    let btn2 = document.getElementById("btn2");
    btn1.onclick = seleccion1;
    btn2.onclick = seleccion2;

    function seleccion1(evento) {
        let clase = btn1.className;
        if (clase == "sidebar-item") {
            btn1.className = "sidebar-item active";
        } else {
            btn1.className = "sidebar-item";
        }
    }

    function seleccion2(evento) {
        let clase = btn2.className;
        if (clase == "sidebar-item") {
            btn2.className = "sidebar-item active";
        } else {
            btn2.className = "sidebar-item";
        }
    }
</script>