<?php

include("./conexion.php");

$user = $_POST['usuario'];
$password = $_POST['password'];
$revFolio = $_POST['revFolio'];
$idRol = '';
$sql = "SELECT * FROM usuarios";
$result = mysqli_query($conexion,$sql);

$bandera = FALSE;

if($result){
    while($consulta = mysqli_fetch_array($result)){
        if($user == $consulta['usuario'] && md5($password) == $consulta['contrasena']){
        //if($user == $consulta['usuario'] && $password == $consulta['contrasena']){
            session_start(); 
            $_SESSION['usuarioId']=$consulta['usuarioId'];
            $_SESSION['idRol']=$consulta['idRol'];
            $idRol = $consulta['idRol'];
            $_SESSION['revFolio'] = $revFolio;
            $bandera = TRUE;
        }
    }

    if($bandera){  
        
        if($idRol == 1 || $idRol == 2){
            header('Location: ../registro_v2.php');
        }else if($idRol == 3){
            header('Location: ../visualizador_contratos.php');
        }
    }else{
        header('Location: ../index.php?login=false');
    }

}else{
    header('Location: ../index.php?login=false');
}


?>