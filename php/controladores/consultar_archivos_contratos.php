<?php

include('../conexion.php');

$revFolio = $_REQUEST['revFolio'];

$query_count_archivos = "SELECT COUNT(*) AS contador FROM archivos WHERE  idRegistroContrato = '$revFolio' AND activo = 1 ORDER BY rutaArchivo ASC";
$result_count_archivos = mysqli_query($conexion, $query_count_archivos);
if ($result_count_archivos) {
    $mostrar_count_archivos = mysqli_fetch_array($result_count_archivos);
    $contador = $mostrar_count_archivos['contador'];

    if ($contador > 0) {
        $query_consultar_archivos = "SELECT * FROM archivos WHERE  idRegistroContrato = '$revFolio' AND activo = 1 ORDER BY rutaArchivo ASC";
        $result_query_consultar_archivos = mysqli_query($conexion, $query_consultar_archivos);
        $contador = 1;
        while ($mostrar_archivos = mysqli_fetch_array($result_query_consultar_archivos)) {
            echo '<tr class="align-items-center text-center">';
            echo '<td hidden>' . $mostrar_archivos['idArchivo'] . '</td>';
            echo '<td hidden>' . $mostrar_archivos['fechaRegistro'] . '</td>';

            $strLenght = strlen($mostrar_archivos['rutaArchivo']);
            echo '<td><img src="' . substr($mostrar_archivos['rutaArchivo'], 4, $strLenght) . '" alt="" width="100px" height="100px"></td>';
            echo '<td>' . $mostrar_archivos['descripcionArchivo'] . '</td>';
            echo '<td><button type="button" style="background-color: transparent; border: none;" id="btnEliminar" onclick="eliminarArchivo();"><img src="./img/icons/delete.png" alt="delete" width="40px" height="40px"></button><button type="button" style="background-color: transparent; border: none;" id="btnEditar" data-bs-target="#exampleModalToggle" data-bs-toggle="modal"><img src="./img/icons/editar.png" width="40px" height="40px" onclick="actualizarArchivo();" alt="editar"></button></td>';
            echo '</tr>';
            $contador++;
        }
    } else {
        echo '<td class="align-items-center text-center" colspan="3">';
        echo 'No se encontró información disponible para mostrar.';
        echo '</td>';
    }
}