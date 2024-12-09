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
    <title>Registrar Usuario | Sistema Contratos FGE</title>
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
                <div class="container-fluid p-0 col-10 d-flex justify-content-center">
                    <div class="card col-xxl-8 mt-2" style="border-top: 8px solid #0d6efd;">
                        <div class="card-body px-4 justify-content-center">
                            <h5 class="text-center" style="color: #0d6efd">Registrar Usuario</h5>
                            <form id="formulario_agregar_usuario" action="./php/controladores/registrar_new_user.php" method="POST">
                                <h6 class="text-center"><mark>Los campos marcados con <span class="text-danger">*</span> son obligatorios.</mark></h6>
                                <div class="row mt-2 mx-auto form-group justify-content-center">
                                    <h6 class="text-secondary text-center">Información general</h6>
                                    <div class="col-xxl-4 col-md-4 col-sm-12">
                                        <label for="nombreUsuario" class="form-label">Nombre(s)<span class="text-danger">*</span></label>
                                        <input id="nombreUsuario" class="form-control" type="text" name="nombreUsuario" required />
                                    </div>

                                    <div class="col-xxl-4 col-md-4 col-sm-12">
                                        <label for="apellidoPaterno" class="form-label">Apellido Paterno<span class="text-danger">*</span></label>
                                        <input id="apellidoPaterno" class="form-control" type="text" name="apellidoPaterno" required />
                                    </div>

                                    <div class="col-xxl-4 col-md-4 col-sm-12">
                                        <label for="apellidoMaterno" class="form-label">Apellido Materno<span class="text-danger">*</span></label>
                                        <input id="apellidoMaterno" class="form-control" type="text" name="apellidoMaterno" required />
                                    </div>
                                </div>

                                <div class="row mt-3 mx-auto form-group justify-content-center">
                                    <h6 class="text-secondary text-center">Información para la cuenta</h6>
                                    <div class="col-xxl-6 col-md-6 col-sm-12">
                                        <label for="usuario" class="form-label">Usuario<span class="text-danger">*</span></label>
                                        <input id="usuario" class="form-control" type="text" name="usuario" required />
                                    </div>

                                    <div class="col-xxl-6 col-md-6 col-sm-12">
                                        <label for="password" class="form-label">Contraseña<span class="text-danger">*</span></label>
                                        <input id="password" class="form-control" type="password" name="password" autocomplete="off" required />
                                    </div>
                                </div>

                                <div class="row mt-3 mx-auto form-group justify-content-center">
                                    <div class="col-xxl-6 col-md-6 col-sm-12">
                                        <label for="password" class="form-label">Repita la Contraseña<span class="text-danger">*</span></label>
                                        <input id="password1" class="form-control" type="password" name="password1" autocomplete="off" required />
                                    </div>

                                    <div class="col-xxl-6 col-md-6 col-sm-12" id="selectContainer">
                                        <label for="rolUsuario" class="form-label">Rol del usuario</label>
                                        <select class="form-select text-align-left" data-val="true" name="rolUsuario" id="rolUsuario">
                                            <option value="" selected>-Selecciona-</option>
                                            <?php
                                            if ($result_query_consultar_roles) {
                                                while ($mostrar_roles = mysqli_fetch_array($result_query_consultar_roles)) {
                                            ?>
                                                    <option value="<?php echo $mostrar_roles['idRolUsuario'] ?>"><?php echo $mostrar_roles['descripcion'] ?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-5 mx-auto form-group mb-5">
                                    <div class="col-xxl-12 col-md-12 col-sm-12 d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary col-xxl-6 col-md-6 col-sm-12">Guardar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="./js/app.js"></script>
    <script src="./js/methods.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>