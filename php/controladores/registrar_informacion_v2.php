<?php

include('../conexion.php');

$formData = $_POST['form_data'];
parse_str($formData, $formArray);

$numeroContrato = $formArray['numeroContrato'];
$descripcionContrato = $formArray['descripcionContrato'];
$fechaContrato = $formArray['fechaContrato'];
$descripcionArchivo = $formArray['descripcionArchivo'];
$idRegistroContrato = $formArray['idRegistroContrato'];

$query_exists_contrato = "SELECT COUNT(*) AS contador FROM contratos WHERE idRegistroContrato = '$idRegistroContrato'";
$result_exists_contrato = mysqli_query($conexion, $query_exists_contrato);
$mostrar_query_exists_contrato = mysqli_fetch_array($result_exists_contrato);
$existeContrato = $mostrar_query_exists_contrato['contador'];

//SI YA EXISTE REGISTRO SE ASIGNAN LOS ARCHIVOS AL NÚMERO DE CONTRATO
if ($existeContrato > 0) {

    //INSERCIÓN FILES MULTIPLES
    if (!empty($_FILES['filesMult']['name'][0])) {
        foreach ($_FILES['filesMult']['tmp_name'] as $key => $value) {

            $numConsArch = 0;
            $query_count_consecutivo = "SELECT COUNT(numeroConsecutivoArchivo) AS contador FROM contratos WHERE idRegistroContrato = '$idRegistroContrato'";
            $result_query_count_consecutivo = mysqli_query($conexion, $query_count_consecutivo);
            if ($result_query_count_consecutivo) {
                $mostrar_query_count_consecutivo = mysqli_fetch_array($result_query_count_consecutivo);
                $countConsecutivo = $mostrar_query_count_consecutivo['contador'];
                if ($countConsecutivo > 0) {
                    $query_consultar_numero_consecutivo = "SELECT numeroConsecutivoArchivo FROM contratos WHERE idRegistroContrato = '$idRegistroContrato'";
                    $result_query_numero_consecutivo = mysqli_query($conexion, $query_consultar_numero_consecutivo);
                    $mostrar_numero_consecutivo = mysqli_fetch_array($result_query_numero_consecutivo);
                    $numConsArch = $mostrar_numero_consecutivo['numeroConsecutivoArchivo'];
                }
            }

            if (file_exists($_FILES['filesMult']['tmp_name'][$key])) {

                $archivo_name = '../../uploads/wp-content/img/' . $idRegistroContrato . '-C-' . (intval($numConsArch) + 1);
                $archivo = $_FILES['filesMult']['name'][$key];
                $extension_archivo = pathinfo($archivo, PATHINFO_EXTENSION);
                $ruta = $archivo_name . '.' . $extension_archivo;

                if (move_uploaded_file($_FILES['filesMult']['tmp_name'][$key], $ruta)) {

                    $fechaRegArchivo = date('y-m-d');
                    $query_insert_files_multiples = "INSERT INTO archivos (rutaArchivo,descripcionArchivo,idRegistroContrato,fechaRegistro,activo,FUA) VALUES ('$ruta','$descripcionArchivo','$idRegistroContrato','$fechaRegArchivo','1',now())";

                    $result = mysqli_query($conexion, $query_insert_files_multiples);
                    if ($result) {
                        if ($numConsArch > 0) {
                            $numeroConsecutivoUpdate = intval($numConsArch) + 1;
                            $update_numero_consecutivo = "UPDATE contratos SET numeroConsecutivoArchivo = '$numeroConsecutivoUpdate' WHERE idRegistroContrato = '$idRegistroContrato'";
                            $result = mysqli_query($conexion, $update_numero_consecutivo);
                            if ($result) {
                            }
                        }
                    }
                }
            }
        }
    }

    //INSERCIÓN FILE SINGLE
    if (!empty($_FILES['filesSingle']['name'])) {

        $numConsArch = 0;
        $query_count_consecutivo = "SELECT COUNT(numeroConsecutivoArchivo) AS contador FROM contratos WHERE idRegistroContrato = '$idRegistroContrato'";
        $result_query_count_consecutivo = mysqli_query($conexion, $query_count_consecutivo);
        if ($result_query_count_consecutivo) {
            $mostrar_query_count_consecutivo = mysqli_fetch_array($result_query_count_consecutivo);
            $countConsecutivo = $mostrar_query_count_consecutivo['contador'];
            if ($countConsecutivo > 0) {
                $query_consultar_numero_consecutivo = "SELECT numeroConsecutivoArchivo FROM contratos WHERE idRegistroContrato = '$idRegistroContrato'";
                $result_query_numero_consecutivo = mysqli_query($conexion, $query_consultar_numero_consecutivo);
                $mostrarConsecutivoArch = mysqli_fetch_array($result_query_numero_consecutivo);
                $numConsArch = $mostrarConsecutivoArch['numeroConsecutivoArchivo'];
            }
        }

        if (file_exists($_FILES['filesSingle']['tmp_name'])) {

            $archivo_name = '../../uploads/wp-content/img/' . $idRegistroContrato . '-I-' . (intval($numConsArch) + 1);
            $archivo = $_FILES['filesSingle']['name'];
            $extension_archivo = pathinfo($archivo, PATHINFO_EXTENSION);
            $ruta = $archivo_name . '.' . $extension_archivo;

            if (move_uploaded_file($_FILES['filesSingle']['tmp_name'], $ruta)) {

                $fechaRegArchivo = date('y-m-d');
                $query_insert_file_single = "INSERT INTO archivos (rutaArchivo,descripcionArchivo,idRegistroContrato,fechaRegistro,activo,FUA) VALUES ('$ruta','$descripcionArchivo','$idRegistroContrato','$fechaRegArchivo','1',now())";
                $result = mysqli_query($conexion, $query_insert_file_single);

                if ($result) {

                    if ($numConsArch > 0) {

                        $numeroConsecutivoUpdate = intval($numConsArch) + 1;
                        $update_numero_consecutivo = "UPDATE contratos SET numeroConsecutivoArchivo = '$numeroConsecutivoUpdate' WHERE idRegistroContrato = '$idRegistroContrato'";
                        $result = mysqli_query($conexion, $update_numero_consecutivo);

                        if ($result) {
                        }
                    }
                }
            }
        }
    }

    echo 1;

    //REGISTRO NUEVO
} else {
    $idNumeroConsecutivoRegistro = $formArray['idNumeroConsecutivoRegistro'];
    $fechaRegistro = date('y-m-d');
    $query_insert_new_contrato = "INSERT INTO contratos(idRegistroContrato, numeroContrato, descripcionContrato, fechaContrato, fechaRegistro, numeroConsecutivoArchivo, FUI, FUA) VALUES ('$idNumeroConsecutivoRegistro', '$numeroContrato','$descripcionContrato','$fechaContrato', '$fechaRegistro', 0, now(), now())";
    $result_query_insert_new_contrato = mysqli_query($conexion, $query_insert_new_contrato);

    if ($result_query_insert_new_contrato) {

        //INSERCIÓN DE ARCHIVOS MULTIPLES
        if (!empty($_FILES['filesMult']['name'][0])) {

            foreach ($_FILES['filesMult']['tmp_name'] as $key => $value) {

                if (file_exists($_FILES['filesMult']['tmp_name'][$key])) {

                    $archivo_name = '../../uploads/wp-content/img/' . $idNumeroConsecutivoRegistro . '-C-' . ($key + 1);
                    $numeroConsecutivo = $key + 1;
                    $archivo = $_FILES['filesMult']['name'][$key];
                    $extension_archivo = pathinfo($archivo, PATHINFO_EXTENSION);
                    $ruta = $archivo_name . '.' . $extension_archivo;

                    if (move_uploaded_file($_FILES['filesMult']['tmp_name'][$key], $ruta)) {

                        $fechaRegArchivo = date('y-m-d');
                        $query_insert_files_multiples = "INSERT INTO archivos (rutaArchivo,descripcionArchivo,idRegistroContrato,fechaRegistro,activo,FUA) VALUES ('$ruta','$descripcionArchivo','$idNumeroConsecutivoRegistro','$fechaRegArchivo','1',now())";
                        $result = mysqli_query($conexion, $query_insert_files_multiples);

                        if ($result) {

                            $numConsArch = 0;
                            $query_count_consecutivo = "SELECT COUNT(numeroConsecutivoArchivo) AS contador FROM contratos WHERE idRegistroContrato = '$idNumeroConsecutivoRegistro'";
                            $result_query_count_consecutivo = mysqli_query($conexion, $query_count_consecutivo);
                            if ($result_query_count_consecutivo) {
                                $mostrar_query_count_consecutivo = mysqli_fetch_array($result_query_count_consecutivo);
                                $countConsecutivo = $mostrar_query_count_consecutivo['contador'];
                                if ($countConsecutivo > 0) {
                                    $query_consultar_numero_consecutivo = "SELECT numeroConsecutivoArchivo FROM contratos WHERE idRegistroContrato = '$idNumeroConsecutivoRegistro'";
                                    $result_query_consultar_numero_consecutivo = mysqli_query($conexion, $query_consultar_numero_consecutivo);
                                    $mostrar_query_numero_consecutivo = mysqli_fetch_array($result_query_consultar_numero_consecutivo);
                                    $numConsArch = $mostrar_query_numero_consecutivo['numeroConsecutivoArchivo'];
                                    $numeroConsecutivoUpdate = intval($numConsArch) + 1;
                                } else {
                                    $numeroConsecutivoUpdate = $numeroConsecutivo;
                                }
                            }

                            $query_update_numero_consecutivo = "UPDATE contratos SET numeroConsecutivoArchivo = '$numeroConsecutivoUpdate' WHERE idRegistroContrato = '$idNumeroConsecutivoRegistro'";
                            $result = mysqli_query($conexion, $query_update_numero_consecutivo);
                            if ($result) {
                            }
                        }
                    }
                }
            }
        }

        //INSERCIÓN ARCHIVOS SINGLE
        if (!empty($_FILES['filesSingle']['name'])) {

            if (file_exists($_FILES['filesSingle']['tmp_name'])) {

                $archivo_name = '../../uploads/wp-content/img/' . $idNumeroConsecutivoRegistro . '-I-' . 1;
                $archivo = $_FILES['filesSingle']['name'];
                $extension_archivo = pathinfo($archivo, PATHINFO_EXTENSION);
                $ruta = $archivo_name . '.' . $extension_archivo;

                if (move_uploaded_file($_FILES['filesSingle']['tmp_name'], $ruta)) {

                    $fechaRegArchivo = date('y-m-d');
                    $query_insert_file_single = "INSERT INTO archivos (rutaArchivo,descripcionArchivo,idRegistroContrato,fechaRegistro,activo,FUA) VALUES ('$ruta','$descripcionArchivo','$idNumeroConsecutivoRegistro','$fechaRegArchivo','1',now())";
                    $result = mysqli_query($conexion, $query_insert_file_single);

                    if ($result) {

                        $query_update_numero_consecutivo = "UPDATE contratos SET numeroConsecutivoArchivo = '1' WHERE idRegistroContrato = '$idNumeroConsecutivoRegistro'";
                        $result = mysqli_query($conexion, $query_update_numero_consecutivo);
                        if ($result) {
                        }
                    }
                }
            }
        }

        echo 2;
    }
}
