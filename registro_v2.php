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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Contratos | FGE</title>
    <link rel="shortcut icon" href="./img/icons/icon-48x48.png" />
    <link href="./css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrious@4.0.2/dist/qrious.min.js"></script>
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
                    <div class="card col-xxl-8 col-md-12 col-sm mx-auto my-auto" style="border-top: 8px solid #198754;">
                        <div class="card-body px-4 text-center">
                            <h5 class="text-center" style="color: #198754;">Registro de Contrato</h5>
                            <form id="formulario_registro" method="POST" action="./php/controladores/registrar_informacion_v2.php" enctype="multipart/form-data">
                                <div class="row mt-3 mx-auto form-group justify-content-center">

                                    <h6><mark>Los campos marcados con <span class="text-danger">*</span> son obligatorios.</mark></h6>
                                    <h6 class="text-secondary">Información del contrato</h6>
                                    <input id="idRegistroContrato" name="idRegistroContrato" type="text" hidden>
                                    <input id="idNumeroConsecutivoRegistro" name="idNumeroConsecutivoRegistro" type="text" hidden>
                                    <div class="col-xxl-6 col-md-6 col-sm-12">
                                        <label for="numeroContrato" class="form-label">Número de contrato <span class="text-danger">*</span></label>
                                        <input id="numeroContrato" class="col-lg-4 col-sm-12 form-control" type="text" name="numeroContrato" required />
                                    </div>
                                    <div class="col-xxl-6 col-md-6 col-sm-12">
                                        <label for="fechaContrato" class="form-label">Fecha de contrato <span class="text-danger">*</span></label>
                                        <input id="fechaContrato" class="col-lg-4 col-sm-12 form-control" type="date" name="fechaContrato" required />
                                    </div>
                                </div>
                                <div class="row mt-3 mx-auto form-group justify-content-center">
                                    <div class="col-xxl-12 col-md-12 col-sm-12">
                                        <label for="descripcionContrato" class="form-label">Descripción del contrato <span class="text-danger">*</span></label>
                                        <textarea class="form-control" aria-label="With textarea" id="descripcionContrato" name="descripcionContrato" required></textarea>
                                    </div>
                                </div>
                                <div class="row mt-3 mx-auto form-group justify-content-center">
                                    <div class="col-xxl-6 col-md-6 col-sm-12" id="selectContainer">
                                        <label for="opcionesDocumento" class="form-label">Selecciona el tipo de documento</label>
                                        <select class="form-select text-align-center" data-val="true" name="opcionesDocumento" id="opcionesDocumento" onchange="handleEventSelect();">
                                            <option value="1" selected>Contrato</option>
                                            <option value="2">Imagenes</option>
                                        </select>
                                    </div>

                                    <div class="col-xxl-6 col-md-6 col-sm-12" id="fileMultiple">
                                        <label for="filesMult" class="form-label">Subir imagen o archivos <span class="text-danger">*</span></label>
                                        <input type="file" class="form-control" accept=".jpg, .jpeg, .png, .gif" id="filesMult" name="filesMult" multiple required>
                                    </div>

                                    <div class="col-xxl-6 col-md-6 col-sm-12" style="display: none;" id="fileSingle">
                                        <label for="filesSingle" class="form-label">Subir imagen o archivos <span class="text-danger">*</span></label>
                                        <input type="file" class="form-control" accept=".jpg, .jpeg, .png, .gif" id="filesSingle" name="filesSingle" required disabled>
                                    </div>

                                </div>

                                <div class="row mt-3 mx-auto form-group justify-content-center">
                                    <div class="col-xxl-12 col-md-12 col-sm-12">
                                        <label for="descripcionArchivo" class="form-label">Descripción del Archivo <span class="text-danger">*</span></label>
                                        <textarea aria-label="With textarea" class="form-control" id="descripcionArchivo" name="descripcionArchivo" required></textarea>
                                    </div>
                                </div>

                                <div class="row mt-5 mx-auto form-group mb-5">
                                    <div class="col-xxl-12 col-md-12 col-sm-12 d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary col-xxl-4 col-md-4 col-sm-12">Guardar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
            <div class="text-muted text-center text-secondary">
                Copyright © 2023 <br />
                Todos los derechos reservados
            </div>
        </div>
    </div>
    <script src="./js/app.js"></script>
    <script src="./js/jquery_funciones_v5.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>