<?php
$server ="10.1.90.243:3306";
$user = "Admin";
$password= "x7inxj4a7k";
$db = "contratos";

$conexion = new mysqli($server,$user,$password,$db);

if($conexion->connect_errno){
    die("La conexión ha fallado".$conexion->connect_errno);
}

/*$server ="hostname";
$user = "usuario";
$password= "contrasena";
$db = "base";*/
?>