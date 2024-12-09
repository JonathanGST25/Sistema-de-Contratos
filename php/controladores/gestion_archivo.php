<?php

include('../conexion.php');

if (isset($_POST['bandera']) && $_POST['bandera'] == 1) {
    $idArchivo = $_POST['idArchivo'];
    $query_delete_file = "UPDATE archivos SET activo = '0' WHERE idArchivo = '$idArchivo'";
    $result_query_delete_file = mysqli_query($conexion, $query_delete_file);
    if ($result_query_delete_file) {
        echo 1;
    }
}

?>
