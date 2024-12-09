<?php
include('../conexion.php');

if ($_POST['bandera'] == 1) {
    $consultarExistsFolioGeneral = "SELECT COUNT(*) as contador FROM contratos ORDER BY FUI DESC LIMIT 1";
    $result = mysqli_query($conexion, $consultarExistsFolioGeneral);
    if($result){
        $mostrarconsultarExistsFolioGeneral = mysqli_fetch_array($result);
        $contador = $mostrarconsultarExistsFolioGeneral['contador'];
        if ($contador > 0) {
            $query_folio_general = "SELECT * FROM contratos ORDER BY FUI DESC LIMIT 1";
            $result_query_folio_general = mysqli_query($conexion, $query_folio_general);
            if($result_query_folio_general){
                $mostrarFolio = mysqli_fetch_array($result_query_folio_general);
                $numeroConsecutivo =  $mostrarFolio['idRegistroContrato'];
                echo $numeroConsecutivo;
            }
        } else {
            echo 1;
        }
    }
}

if ($_POST['bandera'] == 2) {
    $numeroContrato = $_POST['numeroContrato'];
    $sqlExistsContrato = "SELECT COUNT(*) contador FROM contratos WHERE numeroContrato = '$numeroContrato'";
    $resultExistsContrato = mysqli_query($conexion, $sqlExistsContrato);
    if ($resultExistsContrato) {
        $mostrarresultExistsContrato = mysqli_fetch_array($resultExistsContrato);
        $contador = $mostrarresultExistsContrato['contador'];
        if ($contador > 0) {
            echo 3;
        } else {
            echo 0;
        }
    }
}
