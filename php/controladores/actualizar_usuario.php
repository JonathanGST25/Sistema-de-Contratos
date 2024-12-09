<?php

include('../conexion.php');

$nombreUsuario = $_POST['nombreUsuarioEdit'];
$apellidoPaterno = $_POST['apellidoPaterno'];
$apellidoMaterno = $_POST['apellidoMaterno'];
$password_new = $_POST['password_new'];
$rolUsuario = $_POST['rolUsuario'];
$estatus = $_POST['estatus'];
$idUsuario = $_POST['idUsuario'];

$consulta_base = "UPDATE usuarios SET nombreUsuario = '$nombreUsuario', apellidoPaterno = '$apellidoPaterno', apellidoMaterno = '$apellidoMaterno'";

if($password_new != ''){
    $consulta_base .= ", password = '$password_new'";
}

$consulta_base .= ", idRol = '$rolUsuario', activo = '$estatus' WHERE usuarioId = '$idUsuario'";

$result = mysqli_query($conexion, $consulta_base);

if($result){
    echo 1;
}else{
    echo 2;
}


?>