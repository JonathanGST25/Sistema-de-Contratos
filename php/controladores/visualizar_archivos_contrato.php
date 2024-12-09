<?php

include('../conexion.php');
$revFolio = $_REQUEST['revFolio'];

$query_exists_archivos = "SELECT COUNT(*) AS contador FROM archivos WHERE  idRegistroContrato = '$revFolio' ORDER BY rutaArchivo ASC";
$result_query_exists_archivos = mysqli_query($conexion, $query_exists_archivos);
$contador = 0;
if ($result_query_exists_archivos) {
    $mostrar_query_exists_archivos = mysqli_fetch_array($result_query_exists_archivos);
    $contador = $mostrar_query_exists_archivos['contador'];
}

if($contador>0){
    $query_consultar_archivos = "SELECT * FROM archivos WHERE  idRegistroContrato = '$revFolio' ORDER BY rutaArchivo ASC";
    $result_query_consultar_archivos = mysqli_query($conexion, $query_consultar_archivos);

    while ($mostrar_archivos = mysqli_fetch_assoc($result_query_consultar_archivos)) {

                    echo '<tr class="align-items-center text-center">';   
                    $strLenght = strlen($mostrar_archivos['rutaArchivo']);
                    echo '<td hidden><img src="'.substr($mostrar_archivos['rutaArchivo'], 4, $strLenght).'" alt="" width="100px" height="100px"></td>';
                    echo '<td><button type="button" class="btn btn-info btn-sm col-xxl-3 col-md-4 col-sm-6" data-bs-target="#exampleModalToggle" data-bs-toggle="modal" onclick="mostrarImg();" style="background-color: transparent; border:none;"><img src="'.substr($mostrar_archivos['rutaArchivo'], 4, $strLenght).'" alt="" width="100px" height="100px"></button></td>';
                    echo '<td>'.$mostrar_archivos['descripcionArchivo'].'</td>';
                    echo '</tr>';
      
                }
}else {
    echo '<td class="align-items-center text-center" colspan="3">';
    echo 'No se encontró información disponible para mostrar.';
    echo '</td>';
}

?>