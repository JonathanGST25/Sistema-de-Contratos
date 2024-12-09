<?php

include('../conexion.php');

//VARIABLES
$usuario = $_POST['usuario'];
$nombreUsuario = $_POST['nombreUsuario'];
$apellidoPaterno = $_POST['apellidoPaterno'];
$apellidoMaterno = $_POST['apellidoMaterno'];
$password = $_POST['password'];
$rolUsuario = $_POST['rolUsuario'];

$query_exists_user = "SELECT COUNT(*) AS contador FROM usuarios WHERE usuario = '$usuario'";
$result_query_exists_user = mysqli_query($conexion, $query_exists_user);
if($result_query_exists_user){
    $mostrar_contador_user = mysqli_fetch_array($result_query_exists_user);
    $contador = $mostrar_contador_user['contador'];

    if($contador > 0){
        echo 0;
    }else{
        $password_hash = md5($password);
        $query_insert_user = "INSERT INTO usuarios (nombreUsuario, apellidoPaterno, apellidoMaterno, usuario, contrasena, idRol, activo, FUA) VALUES ('$nombreUsuario','$apellidoPaterno', '$apellidoMaterno', '$usuario', '$password_hash', '$rolUsuario', 1, now())";
        $result_query_insert_user = mysqli_query($conexion, $query_insert_user);
        if($result_query_insert_user){
            echo 1;
        }
    }

}
