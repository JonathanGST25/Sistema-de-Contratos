<?php

include('../conexion.php');

if(isset($_POST['numeroContrato'])){

    $numeroContrato = $_POST['numeroContrato'];

    $query_exists_contrato = "SELECT COUNT(*) AS contador FROM contratos WHERE numeroContrato = '$numeroContrato'";
    $result_query_exists_contrato = mysqli_query($conexion,$query_exists_contrato);
    if($result_query_exists_contrato){
        $mostrar_query_exists_contrato = mysqli_fetch_array($result_query_exists_contrato);
        $contador = $mostrar_query_exists_contrato['contador'];
        if($contador>0){
            $query_consultar_contrato = "SELECT * FROM contratos WHERE numeroContrato = '$numeroContrato'";
            $result_query_consultar_contrato = mysqli_query($conexion, $query_consultar_contrato);
            if($result_query_consultar_contrato){
                $consulta_query_contrato = mysqli_fetch_array($result_query_consultar_contrato);
                
                echo json_encode($consulta_query_contrato);
            }
        }
    }
}
