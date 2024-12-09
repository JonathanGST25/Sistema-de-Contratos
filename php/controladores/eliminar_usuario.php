<?php

include('../conexion.php');

if (isset($_POST['bandera']) && $_POST['bandera'] == 1) {
    $idUsuario = $_POST['idUsuario'];

    $query_eliminar_usuario = "UPDATE usuarios SET activo = 0 WHERE usuarioId = '$idUsuario'";
    $result_eliminar_usuario = mysqli_query($conexion, $query_eliminar_usuario);
    if ($result_eliminar_usuario) {
        echo 1;
    } else {
        echo 0;
    }
}
