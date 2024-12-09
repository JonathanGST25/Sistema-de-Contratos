<?php

include('../conexion.php');

if(isset($_POST['usuarioId']) && $_POST['usuarioId'] != ''){
    $usuarioId = $_POST['usuarioId'];

    $query_consultar_usuario = "SELECT * FROM usuarios WHERE usuarioId = '$usuarioId'";
    $result = mysqli_query($conexion, $query_consultar_usuario);

    if($result){
        $mostrar_usuario = mysqli_fetch_array($result);

        echo json_encode($mostrar_usuario);
    }
}  

?>