<?php

session_start();

if ($_SESSION['usuarioId']) {
    $usuarioId = $_SESSION['usuarioId'];
    $idRol = $_SESSION['idRol'];
} else {
    echo '<script type="text/javascript">
    alert("Sesión no iniciada");
    window.location.href="./index.php";
    </script>';
}


include("./php/conexion.php");
$sql = "SELECT * FROM usuarios WHERE usuarioId = '$usuarioId'";
$result = mysqli_query($conexion, $sql);
$mostrar = mysqli_fetch_array($result);

$usuario = $mostrar['nombreUsuario'] . " " . $mostrar['apellidoPaterno'] . " " . $mostrar['apellidoMaterno'];

$query_consultar_roles = "SELECT * FROM cat_rol_usuarios";
$result_query_consultar_roles = mysqli_query($conexion, $query_consultar_roles);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios | Sistema Contratos FHE</title>
    <link rel="shortcut icon" href="./img/icons/icon-48x48.png" />
    <link href="./css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrious@4.0.2/dist/qrious.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>

<body>
    <STYLE>
        A {
            text-decoration: none;
        }

        .fondo-pantalla {
            background-image: url('./img/icons/fondo.png') !important; 
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
    </STYLE>
    <div class="wrapper">
        <?php include("dash_mod.php") ?>
        <div class="main fondo-pantalla">
            <?php include("super_mod.php") ?>
            <main class="content">
                <div class="container-fluid p-0 col-10">
                    <div class="card col-xxl-10 col-md-12 col-sm mx-auto my-auto" style="border-top: 8px solid #0d6efd;">
                        <div class="card-body px-4 text-center">
                            <h5 class="text-center" style="color:  #0d6efd;">Gestión de Usuarios</h5>
                            <h6><mark>Los campos marcados con <span class="text-danger">*</span> son obligatorios.</mark></h6>
                            <form method="GET" action="">
                                <div class="row mt-3 mx-auto form-group justify-content-center">
                                    <div class="col-xxl-3 col-md-3 col-sm-12 mt-2">
                                        <label for="nombreUsuario" class="form-label text-start">Nombre del Usuario<span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-xxl-4 col-md-5 col-sm-8 mt-2">
                                        <input id="nombreUsuario" class="col-lg-4 col-sm-12 form-control" type="text" name="nombreUsuario" value="<?php echo isset($_GET['nombreUsuario']) ? $_GET['nombreUsuario'] : ''; ?>" required />
                                    </div>
                                    <div class="col-xxl-3 col-md-4 col-sm-4 mt-2">
                                        <button type="submit" class="btn btn-warning col-xxl-6 col-md-6 col-sm-12">Buscar <span class="ml-2"><i class="bi bi-search"></i></span></button>
                                    </div>
                                </div>
                            </form>
                            <hr>

                            <div class="row mt-3 mx-auto form-group mb-5" style="display: block;" id="tabla-ejemplo">
                                <div class="table-responsive mt-2">

                                    <?php
                                    echo '<table class="table" id="tabla_usuarios">';
                                    echo "<thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Apellido Paterno</th>
                                                <th>Apellido Materno</th>
                                                <th>Estatus</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>";


                                    if (isset($_GET['nombreUsuario']) && !empty($_GET['nombreUsuario'])) {
                                        $pagina_actual = isset($_GET["pagina"]) ? $_GET["pagina"] : 1;
                                        $registros_por_pagina = 7; // Cambia esto según tus necesidades
                                        $offset = ($pagina_actual - 1) * $registros_por_pagina;
                                        $nombreUsuario = '';
                                        $nombreUsuario = $_GET['nombreUsuario'];
                                        $query_count_registros = "SELECT count(*) as contador FROM usuarios WHERE nombreUsuario LIKE '%$nombreUsuario%' OR apellidoPaterno LIKE '%$nombreUsuario%' OR apellidoPaterno LIKE '%$nombreUsuario%' OR usuario LIKE '%$nombreUsuario%'";
                                        $result_count_total_registros = mysqli_query($conexion, $query_count_registros);
                                        if ($result_count_total_registros) {
                                            $mostrar_count_registros = mysqli_fetch_array($result_count_total_registros);
                                            $count = $mostrar_count_registros['contador'];
                                            if ($count > 0) {
                                                $consultaBase = "SELECT * FROM usuarios";
                                                $consultaBase .= " WHERE nombreUsuario LIKE '%$nombreUsuario%' OR apellidoPaterno LIKE '%$nombreUsuario%' OR apellidoMaterno LIKE '%$nombreUsuario%' OR usuario LIKE '%$nombreUsuario%'";

                                                $consultaCompleta = $consultaBase . " LIMIT $registros_por_pagina OFFSET $offset";

                                                $result = mysqli_query($conexion, $consultaCompleta);

                                                if ($result) {
                                                    echo '<tbody class="table-group-divider">';

                                                    while ($mostrar_usuarios = mysqli_fetch_array($result)) {
                                                        echo '<tr class="align-items-center text-center">';
                                                        echo '<td>' . $mostrar_usuarios['usuarioId'] . '</td>';
                                                        echo '<td>' . $mostrar_usuarios['nombreUsuario'] . '</td>';
                                                        echo '<td>' . $mostrar_usuarios['apellidoPaterno'] . '</td>';
                                                        echo '<td>' . $mostrar_usuarios['apellidoMaterno'] . '</td>';
                                                        if ($mostrar_usuarios['activo'] == 1) {
                                                            echo ' <td>
                                                    <a href="#" class="btn btn-sm btn-success" style="width: 130px; font-size: 12px; pointer-events: none;">Activo</a>
                                                </td>';
                                                        } elseif ($mostrar_usuarios['activo'] == 0) {
                                                            echo '<td>
                                                    <a href="#" class="btn btn-sm btn-secondary" style="width: 130px; font-size: 12px; pointer-events: none;">Inactivo</a>
                                                </td>';
                                                        }

                                                        if ($mostrar_usuarios['activo'] == 1) {
                                                            echo '<td><button type="button" style="background-color: transparent; border: none;" id="btnEliminar" onclick="deleteUser();"><img src="./img/icons/delete.png" alt="delete" width="40px" height="40px"></button><button type="button" style="background-color: transparent; border: none;" id="btnEditar" onclick="selectUserUpdate();" data-bs-target="#exampleModalToggle" data-bs-toggle="modal"><img src="./img/icons/editar.png" width="40px" height="40px" alt="editar"></button></td>';
                                                        }elseif ($mostrar_usuarios['activo'] == 0){
                                                            echo '<td><button type="button" style="background-color: transparent; border: none;" id="btnEliminar" disabled onclick="deleteUser();"><img src="./img/icons/delete.png" alt="delete" width="40px" height="40px"></button><button type="button" style="background-color: transparent; border: none;" id="btnEditar" onclick="selectUserUpdate();" data-bs-target="#exampleModalToggle" data-bs-toggle="modal"><img src="./img/icons/editar.png" width="40px" height="40px" alt="editar"></button></td>';
                                                        }
                                                        echo '</tr>';
                                                    }

                                                    echo "</tbody>";
                                                    echo "</table>";

                                                    $query_total_registros = "SELECT count(*) as contador FROM usuarios WHERE nombreUsuario LIKE '%$nombreUsuario%' OR apellidoPaterno LIKE '%$nombreUsuario%' OR apellidoPaterno LIKE '%$nombreUsuario%' OR usuario LIKE '%$nombreUsuario%'";
                                                    $result_query_total_registros = mysqli_query($conexion, $query_total_registros);
                                                    if ($result_query_total_registros) {
                                                        $mostrar_total_registros = mysqli_fetch_array($result_query_total_registros);
                                                        $totalResultados = $mostrar_total_registros['contador'];
                                                        $totalPaginas = ceil($totalResultados / $registros_por_pagina);

                                                        echo '<div class="col-lg-12 col-md-4 col-sm-6 alig-items-center">';
                                                        echo '<nav aria-label="Page navigation example">';
                                                        echo '<ul class="pagination justify-content-center">';


                                                        //MUESTRA EL BOTÓN ANTERIOR
                                                        if ($pagina_actual > 1) {
                                                            $anterior = $pagina_actual - 1;
                                                            echo '<li class="page-item">';
                                                            echo '<a class="page-link" href="?pagina=' . $anterior . '&nombreUsuario=' . $nombreUsuario . '" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>';
                                                            echo '</li>';
                                                        }

                                                        //LIMITAR A 10 CUADROS DE PAGINACIÓN
                                                        $numeroInicio = 1;

                                                        if (($pagina_actual - 4) > 1) {
                                                            $numeroInicio = $pagina_actual - 4;
                                                        }

                                                        $numeroFin = $numeroInicio + 9;

                                                        if ($numeroFin > $totalPaginas) {
                                                            $numeroFin = $totalPaginas;
                                                        }

                                                        //NÚMERACIÓN DE PÁGINAS
                                                        for ($i = $numeroInicio; $i <= $numeroFin; $i++) {
                                                            if ($pagina_actual == $i) {
                                                                echo '<li class="page-item active"><a class="page-link" href="?pagina=' . $i . '&nombreUsuario=' . $nombreUsuario . '">' . $i . '</a></li>';
                                                            } else {
                                                                echo '<li class="page-item"><a class="page-link" href="?pagina=' . $i . '&nombreUsuario=' . $nombreUsuario . '">' . $i . '</a></li>';
                                                            }
                                                        }

                                                        //MUESTRA EL BOTÓN SIGUIENTE
                                                        if ($pagina_actual < $totalPaginas) {
                                                            $siguiente = $pagina_actual + 1;
                                                            echo '<li class="page-item">';
                                                            echo '<a class="page-link" href="?pagina=' . $siguiente . '&nombreUsuario=' . $nombreUsuario . '" aria-label="Previous">
                                                <span aria-hidden="true">&raquo;</span></a>';
                                                            echo '</li>';
                                                        }

                                                        echo '</ul>';
                                                        echo '</nav>';
                                                        echo '</div>';
                                                    }
                                                }
                                            } else {
                                                echo '<td class="align-items-center text-center" colspan="6">';
                                                echo 'No se encontró información disponible para mostrar.';
                                                echo '</td>';
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php include('./php/modal_edit_user.php') ?>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="./js/app.js"></script>
    <script src="./js/jquery_gestion_usuarios.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>