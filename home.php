<?php

session_start();
$idRol = '';
if ($_SESSION['usuarioId']) {
    $usuarioId = $_SESSION['usuarioId'];
    $idRol = $_SESSION['idRol'];
    $revFolio = $_SESSION['revFolio'];
}else{
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
                <div class="container-fluid p-0">
                    <div class="card">
                        <div class="card-body px-5 m-auto">
                            <div class="card mb-3" style="width: 100%;">
                                <div class="card-body">

                                </div>
                            </div>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <script type="text/javascript">
        window.onload = function() {
            $("#home").addClass("active");
        }
    </script>
</body>


</html>