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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Contratos | Sistemas Contratos FGE</title>
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
                    <div class="card col-xxl-10 col-md-12 col-sm mx-auto my-auto" style="border-top: 8px solid #198754;">
                        <div class="card-body px-4 text-center">
                            <h5 class="text-center" style="color:  #198754;">Gestión de Contratos</h5>
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

                            <form action="">
                                <div class="row mt-3 mx-auto form-group justify-content-center">
                                    <h6 class="text-secondary text-center">Información del contrato</h6>
                                    <input id="idRegistroContrato" name="idRegistroContrato" type="text" hidden>
                                    <div class="col-xxl-5 col-md-6 col-sm-12">
                                        <label for="numeroContrato" class="form-label">Número de contrato</label>
                                        <input id="numeroContrato" class="col-lg-4 col-sm-12 form-control" type="text" name="numeroContrato" required readonly />
                                    </div>

                                    <div class="col-xxl-5 col-md-6 col-sm-12">
                                        <label for="fechaContrato" class="form-label">Fecha de contrato</label>
                                        <input id="fechaContrato" class="col-lg-4 col-sm-12 form-control" type="date" name="fechaContrato" required readonly />
                                    </div>
                                </div>

                                <div class="row mt-3 mx-auto form-group justify-content-center">
                                    <div class="col-xxl-10 col-md-12 col-sm-12">
                                        <label for="descripcionContrato" class="form-label">Descripción del contrato</label>
                                        <textarea class="form-control" aria-label="With textarea" id="descripcionContrato" name="descripcionContrato" required readonly></textarea>
                                    </div>
                                </div>
                            </form>
                            <hr>

                            <div class="row mt-3 mx-auto form-group mb-5">
                                <h6 class="text-secondary">Archivos del Contrato</h6>
                                <div class="table-responsive mt-2" style="overflow: auto; width: 100%; max-height: 350px;">
                                    <table class="table table-hover" id="table-files">
                                        <thead class="text-center" style="position: sticky; top: 0; background-color: #114ca1; color: white;">
                                            <tr>
                                                <th scope="col">Imagen</th>
                                                <th scope="col">Descripcion</th>
                                                <th scope="col" colspan="2">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="body-table">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php include('./php/modal_edit_archivo.php') ?>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="./js/app.js"></script>
    <script src="./js/jquery_gestion_contratos_v1.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>