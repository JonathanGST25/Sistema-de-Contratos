<?php
// Mostramos la sesion
session_start();
//Distruimos la sesion
session_destroy();
//Nos lleva al login

session_unset();

header('Location: ../index.php');
?>