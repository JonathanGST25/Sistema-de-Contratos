<?php

session_start();
$revFolio = '';
if ($_SESSION['usuarioId']) {
    $usuarioId = $_SESSION['usuarioId'];
    $idRol = $_SESSION['idRol'];
    $revFolio = $_SESSION['revFolio'];
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

if ($revFolio == '') {
    $revFolio = '';
}

$query_consultar_contrato = "SELECT * FROM contratos WHERE idRegistroContrato = '$revFolio'";
$result_query_consultar_contrato = mysqli_query($conexion, $query_consultar_contrato);

$query_exists_archivos = "SELECT COUNT(*) AS contador FROM archivos WHERE  idRegistroContrato = '$revFolio' AND activo = 1 ORDER BY rutaArchivo ASC";
$result_query_exists_archivos = mysqli_query($conexion, $query_exists_archivos);
$contador = 0;
if ($result_query_exists_archivos) {
    $mostrar_query_exists_archivos = mysqli_fetch_array($result_query_exists_archivos);
    $contador = $mostrar_query_exists_archivos['contador'];
}

$query_consultar_archivos = "SELECT * FROM archivos WHERE  idRegistroContrato = '$revFolio' AND activo = 1 ORDER BY rutaArchivo ASC";
$result_query_consultar_archivos = mysqli_query($conexion, $query_consultar_archivos);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta del Registro del Contrato | Sistema de Contratos FGE</title>
    <link rel="shortcut icon" href="./img/icons/icon-48x48.png" />
    <link href="./css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <STYLE>
        A {
            text-decoration: none;
        }

        .custom-image {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
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
                <div class="container-fluid p-0 col-xxl-8 col-md-8 col-sm-12">
                    <div class="card col-xxl-11 col-md-12 col-sm mx-auto my-auto" style="border-top: 8px solid #198754;">
                        <div class="card-body px-4 text-center">
                            <h5 class="text-center" style="color: #198754">Información del Contrato</h5>
                            <h6 class="text-secondary text-center">Información general del contrato</h6>

                            <?php
                            if ($revFolio == '') {
                            ?>
                                <form id="formulario_buscar_contrato">
                                    <h6><mark>Los campos marcados con <span class="text-danger">*</span> son obligatorios.</mark></h6>
                                    <div class="row mt-3 mx-auto form-group justify-content-center">
                                        <div class="col-xxl-3 col-md-3 col-sm-12 mt-2">
                                            <label for="numeroContratoBusqueda" class="form-label text-start">Número de contrato <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-xxl-4 col-md-5 col-sm-8 mt-2">
                                            <input id="numeroContratoBusqueda" class="col-lg-4 col-sm-12 form-control" type="text" name="numeroContratoBusqueda" required />
                                        </div>
                                        <div class="col-xxl-3 col-md-4 col-sm-4 mt-2">
                                            <button type="submit" class="btn btn-warning col-xxl-6 col-md-6 col-sm-12">Buscar <span class="ml-2"><i class="bi bi-search"></i></span></button>
                                        </div>
                                    </div>
                                </form>
                                <hr>
                            <?php
                            }
                            ?>

                            <div class="row mt-2 mx-auto form-group justify-content-center">
                                <?php
                                if ($result_query_consultar_contrato) {

                                    $mostrar_contrato = mysqli_fetch_array($result_query_consultar_contrato);

                                ?>
                                    <div class="col-xxl-5 col-md-6 col-sm-12">
                                        <label for="numeroContrato" class="form-label">Número de contrato</label>
                                        <input id="numeroContrato" class="col-lg-4 col-sm-12 form-control" type="text" value="<?php echo isset($mostrar_contrato['numeroContrato']) ? $mostrar_contrato['numeroContrato'] : '' ?>" name="numeroContrato" required readonly />
                                    </div>

                                    <div class="col-xxl-5 col-md-6 col-sm-12">
                                        <label for="fechaContrato" class="form-label">Fecha de contrato</label>
                                        <input id="fechaContrato" class="col-lg-4 col-sm-12 form-control" type="date" name="fechaContrato" value="<?php echo isset($mostrar_contrato['fechaContrato']) ? $mostrar_contrato['fechaContrato'] : '' ?>" required readonly />
                                    </div>
                            </div>

                            <div class="row mt-3 mx-auto form-group justify-content-center">
                                <div class="col-xxl-10 col-md-12 col-sm-12">
                                    <label for="descripcionContrato" class="form-label">Descripción del contrato</label>
                                    <textarea class="form-control" aria-label="With textarea" id="descripcionContrato" name="descripcionContrato" required readonly><?php echo isset($mostrar_contrato['descripcionContrato']) ? $mostrar_contrato['descripcionContrato'] : '' ?></textarea>
                                </div>
                            </div>
                        <?php
                                }
                        ?>
                        <hr>
                        <div class="row mt-3 mb-5 mx-auto form-group justify-content-center">
                            <h6 class="text-secondary text-center">Archivos del contrato</h6>
                            <div class="table-responsive" style="overflow: auto; width: 100%; max-height: 450px;">
                                <table class="table table-hover" id="tabla-archivos">
                                    <thead style="position: sticky; top: 0; background-color: #114ca1; color: white;">
                                        <tr class="text-center">
                                            <th scope="col">Imagen</th>
                                            <th scope="col">Descripción</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabla-archivos-contratos">
                                        <?php
                                        if ($revFolio != '') {
                                            if ($contador > 0) {
                                                while ($mostrar_archivos = mysqli_fetch_assoc($result_query_consultar_archivos)) {
                                        ?>
                                                    <tr class="align-items-center text-center">

                                                        <?php
                                                        $strLenght = strlen($mostrar_archivos['rutaArchivo']);
                                                        ?>
                                                        <td hidden><img src="<?php echo substr($mostrar_archivos['rutaArchivo'], 4, $strLenght) ?>" alt="" width="100px" height="100px"></td>
                                                        <td><button type="button" class="btn btn-info btn-sm col-xxl-3 col-md-4 col-sm-6" data-bs-target="#exampleModalToggle" data-bs-toggle="modal" onclick="mostrarImg();" style="background-color: transparent; border:none;"><img src="<?php echo substr($mostrar_archivos['rutaArchivo'], 4, $strLenght) ?>" alt="" width="100px" height="100px"></button></td>
                                                        <td><?php echo $mostrar_archivos['descripcionArchivo'] ?></td>
                                                    </tr>
                                        <?php
                                                }
                                            } else {
                                                echo '<td class="align-items-center text-center" colspan="3">';
                                                echo 'No se encontró información disponible para mostrar.';
                                                echo '</td>';
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php include('./php/modal_archivo.php') ?>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="./js/app.js"></script>
    <script src="./js/jquery_visualizar_contrato.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>