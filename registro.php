<?php

session_start();

if ($_SESSION['usuarioId']) {
    $usuarioId = $_SESSION['usuarioId'];
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
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
</head>

<body>
    <STYLE>
        A {
            text-decoration: none;
        }
    </STYLE>
    <div class="wrapper">
        <?php include("dash_mod.php") ?>

        <div class="main">
            <?php include("super_mod.php") ?>

            <main class="content">
                <div class="container-fluid p-0 col-10">
                    <div class="card">
                        <div class="card-body px-4">
                            <form class="needs-validation" novalidate id="formulario_registro" method="POST" action="./php/controladores/registrar_informacion.php" enctype="multipart/form-data">
                                <div class="row mt-3 mx-auto form-group">

                                    <h4 class="text-primary text-center">Registro de Contrato</h4>

                                    <h6>Los campos marcados con <span class="text-danger">*</span> son obligatorios.</h6>
                                    <h6 class="text-secondary">Información del contrato</h6>
                                    <input id="idRegistroContrato" name="idRegistroContrato" type="text" hidden>
                                    <input id="idNumeroConsecutivoRegistro" name="idNumeroConsecutivoRegistro" type="text" hidden>
                                    <div class="col-xxl-5 col-md-6 col-sm-12">
                                        <label for="numeroContrato" class="form-label">Número de contrato <span class="text-danger">*</span></label>
                                        <input id="numeroContrato" class="col-lg-4 col-sm-12 form-control" type="text" name="numeroContrato" required />
                                        <div class="invalid-feedback">
                                            Favor de llenar este campo.
                                        </div>
                                    </div>
                                    <div class="col-xxl-5 col-md-6 col-sm-12">
                                        <label for="fechaContrato" class="form-label">Fecha de contrato <span class="text-danger">*</span></label>
                                        <input id="fechaContrato" class="col-lg-4 col-sm-12 form-control" type="date" name="fechaContrato" required />
                                        <div class="invalid-feedback">
                                            Favor de llenar este campo.
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3 mx-auto form-group">
                                    <div class="col-xxl-12 col-md-6 col-sm-12">
                                        <label for="descripcionContrato" class="form-label">Descripción del contrato <span class="text-danger">*</span></label>
                                        <textarea class="form-control" aria-label="With textarea" id="descripcionContrato" name="descripcionContrato" required></textarea>
                                        <div class="invalid-feedback">
                                            Favor de llenar este campo.
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3 mx-auto form-group">
                                    <label for="opcionesDocumento" class="form-label">Selecciona el tipo de documento</label>
                                    <div class="col-xxl-4 col-md-6 col-sm-12" id="selectContainer">
                                        <select class="form-select text-align-left" data-val="true" name="opcionesDocumento" id="opcionesDocumento" onchange="handleEventSelect();">
                                            <option value="1" selected>Contrato</option>
                                            <option value="2">Imagenes</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3 mx-auto form-group" id="fileMultiple">
                                    <div class="col-xxl-4 col-md-6 col-sm-12">
                                        <label for="filesMult" class="form-label">Subir imagen o archivos <span class="text-danger">*</span></label>
                                        <input type="file" class="form-control" id="filesMult" name="filesMult" multiple required>
                                        <div class="invalid-feedback">
                                            Campo obligatorio.
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3 mx-auto form-group" style="display: none;" id="fileSingle">
                                    <div class="col-xxl-4 col-md-6 col-sm-12">
                                        <label for="filesSingle" class="form-label">Subir imagen o archivos <span class="text-danger">*</span></label>
                                        <input type="file" class="form-control" id="filesSingle" name="filesSingle" required disabled>
                                        <div class="invalid-feedback">
                                            Favor de llenar este campo.
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3 mx-auto form-group">
                                    <div class="col-xxl-12 col-md-6 col-sm-12">
                                        <label for="descripcionArchivo" class="form-label">Descripción del Archivo <span class="text-danger">*</span></label>
                                        <textarea aria-label="With textarea" class="form-control" id="descripcionArchivo" name="descripcionArchivo" required></textarea>
                                        <div class="invalid-feedback">
                                            Favor de llenar este campo.
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-5 mx-auto form-group mb-5">
                                    <div class="col-xxl-12 col-md-6 col-sm-12 d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary col-xxl-3 col-md-4 col-sm-12">Guardar</button>
                                    </div>
                                </div>
                                <div style="display: none;" id="qrcode"></div>
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
    <script src="./js/ls.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>