<?php

include('../conexion.php');

$formData = $_POST['form_data'];
parse_str($formData, $formArray);

$numeroContrato = $formArray['numeroContrato'];
$idNumeroConsecutivoRegistro = $formArray['idNumeroConsecutivoRegistro'];
$descripcionContrato = $formArray['descripcionContrato'];
$fechaContrato = $formArray['fechaContrato'];
$descripcionArchivo = $formArray['descripcionArchivo'];
$idRegistroContrato = $formArray['idRegistroContrato'];

if (!empty($idRegistroContrato)) {
    $idRegistroContrato = $formArray['idRegistroContrato'];

    if (!empty($_FILES['filesMult']['name'][0])) {
        foreach ($_FILES['filesMult']['tmp_name'] as $key => $value) {
            $numConsArch = 0;
            $numConsecutivoArch = "SELECT numeroConsecutivoArchivo FROM contratos WHERE idRegistroContrato = '$idRegistroContrato'";
            $resultConsecutivoArch = mysqli_query($conexion, $numConsecutivoArch);
            if (mysqli_num_rows($resultConsecutivoArch) != 0) {
                $mostrarConsecutivoArch = mysqli_fetch_array($resultConsecutivoArch);
                $numConsArch = $mostrarConsecutivoArch['numeroConsecutivoArchivo'];
            }
            if (file_exists($_FILES['filesMult']['tmp_name'][$key])) {
                $archivo_name = '../../uploads/wp-content/img/' . $idRegistroContrato . '-C-' . intval($numConsArch) + 1;
                $archivo = $_FILES['filesMult']['name'][$key];
                $extension_archivo = pathinfo($archivo, PATHINFO_EXTENSION);
                $ruta = $archivo_name . '.' . $extension_archivo;
                if (move_uploaded_file($_FILES['filesMult']['tmp_name'][$key], $ruta)) {
                    $fechaRegArchivo = date('y-m-d');
                    $sql2 = "INSERT INTO archivos (rutaArchivo,descripcionArchivo,idRegistroContrato,fechaRegistro,activo,FUA) VALUES ('$ruta','$descripcionArchivo','$idRegistroContrato','$fechaRegArchivo','1',now())";
                    $result = mysqli_query($conexion, $sql2);
                    if ($result) {
                        if ($numConsArch > 0) {
                            $numeroConsecutivoUpdate = intval($numConsArch) + 1;
                            $update = "UPDATE contratos SET numeroConsecutivoArchivo = '$numeroConsecutivoUpdate' WHERE idRegistroContrato = '$idRegistroContrato'";
                            $result = mysqli_query($conexion, $update);
                            if ($result) {
                            }
                        }
                    }
                }
            }
        }
    }

    if (!empty($_FILES['filesSingle']['name'])) {
        $numConsArch = 0;
        $numConsecutivoArch = "SELECT numeroConsecutivoArchivo FROM contratos WHERE idRegistroContrato = '$idRegistroContrato'";
        $resultConsecutivoArch = mysqli_query($conexion, $numConsecutivoArch);
        if (mysqli_num_rows($resultConsecutivoArch) != 0) {
            $mostrarConsecutivoArch = mysqli_fetch_array($resultConsecutivoArch);
            $numConsArch = $mostrarConsecutivoArch['numeroConsecutivoArchivo'];
        }
        if (file_exists($_FILES['filesSingle']['tmp_name'])) {
            $archivo_name = '../../uploads/wp-content/img/' . $idRegistroContrato . '-I-' . (intval($numConsArch) + 1);
            $archivo = $_FILES['filesSingle']['name'];
            $extension_archivo = pathinfo($archivo, PATHINFO_EXTENSION);
            $ruta = $archivo_name . '.' . $extension_archivo;
            if (move_uploaded_file($_FILES['filesSingle']['tmp_name'], $ruta)) {
                $fechaRegArchivo = date('y-m-d');
                $sql2 = "INSERT INTO archivos (rutaArchivo,descripcionArchivo,idRegistroContrato,fechaRegistro,activo,FUA) VALUES ('$ruta','$descripcionArchivo','$idRegistroContrato','$fechaRegArchivo','1',now())";
                $result = mysqli_query($conexion, $sql2);
                if ($result) {
                    if ($numConsArch > 0) {
                        $numeroConsecutivoUpdate = intval($numConsArch) + 1;
                        $update = "UPDATE contratos SET numeroConsecutivoArchivo = '$numeroConsecutivoUpdate' WHERE idRegistroContrato = '$idRegistroContrato'";
                        $result = mysqli_query($conexion, $update);
                        if ($result) {
                        }
                    }
                }
            }
        }
    }
    echo 1;

} else {

    $fechaRegistro = date('y-m-d');
    $sql = "INSERT INTO contratos(idRegistroContrato, numeroContrato, descripcionContrato, fechaContrato, fechaRegistro, numeroConsecutivoArchivo, FUI, FUA) VALUES ('$idNumeroConsecutivoRegistro', '$numeroContrato','$descripcionContrato','$fechaContrato', '$fechaRegistro', 0, now(), now())";
    $resultInsert = mysqli_query($conexion, $sql);
    if ($resultInsert) {
        if (!empty($_FILES['filesMult']['name'][0])) {
            foreach ($_FILES['filesMult']['tmp_name'] as $key => $value) {
                if (file_exists($_FILES['filesMult']['tmp_name'][$key])) {
                    $archivo_name = '../../uploads/wp-content/img/' . strval($idNumeroConsecutivoRegistro) . '-C-' . ($key + 1);
                    $numeroConsecutivo = $key + 1;
                    $archivo = $_FILES['filesMult']['name'][$key];
                    $extension_archivo = pathinfo($archivo, PATHINFO_EXTENSION);
                    $ruta = $archivo_name . '.' . $extension_archivo;
                    if (move_uploaded_file($_FILES['filesMult']['tmp_name'][$key], $ruta)) {
                        $fechaRegArchivo = date('y-m-d');
                        $sql2 = "INSERT INTO archivos (rutaArchivo,descripcionArchivo,idRegistroContrato,fechaRegistro,activo,FUA) VALUES ('$ruta','$descripcionArchivo','$idNumeroConsecutivoRegistro','$fechaRegArchivo','1',now())";
                        $result = mysqli_query($conexion, $sql2);
                        if ($result) {

                            $numConsecutivoArch = "SELECT numeroConsecutivoArchivo FROM contratos WHERE idRegistroContrato = '$idNumeroConsecutivoRegistro'";
                            $resultConsecutivoArch = mysqli_query($conexion, $numConsecutivoArch);
                            if (mysqli_num_rows($resultConsecutivoArch) != 0) {
                                $mostrarConsecutivoArch = mysqli_fetch_array($resultConsecutivoArch);
                                $numConsArch = $mostrarConsecutivoArch['numeroConsecutivoArchivo'];
                                $numeroConsecutivoUpdate = intval($numConsArch) + 1;
                            } else {
                                $numeroConsecutivoUpdate = $numeroConsecutivo;
                            }

                            $update = "UPDATE contratos SET numeroConsecutivoArchivo = '$numeroConsecutivoUpdate' WHERE idRegistroContrato = '$idNumeroConsecutivoRegistro'";
                            $result = mysqli_query($conexion, $update);
                            if ($result) {
                            }
                        }
                    }
                }
            }
        }

        if (!empty($_FILES['filesSingle']['name'])) {
            if (file_exists($_FILES['filesSingle']['tmp_name'])) {
                $archivo_name = '../../uploads/wp-content/img/' . $idNumeroConsecutivoRegistro . '-I-' . 1;
                $archivo = $_FILES['filesSingle']['name'];
                $extension_archivo = pathinfo($archivo, PATHINFO_EXTENSION);
                $ruta = $archivo_name . '.' . $extension_archivo;
                if (move_uploaded_file($_FILES['filesSingle']['tmp_name'], $ruta)) {
                    $fechaRegArchivo = date('y-m-d');
                    $sql2 = "INSERT INTO archivos (rutaArchivo,descripcionArchivo,idRegistroContrato,fechaRegistro,activo,FUA) VALUES ('$ruta','$descripcionArchivo','$idNumeroConsecutivoRegistro','$fechaRegArchivo','1',now())";
                    $result = mysqli_query($conexion, $sql2);
                    if ($result) {
                        $update = "UPDATE contratos SET numeroConsecutivoArchivo = '1' WHERE idRegistroContrato = '$idNumeroConsecutivoRegistro'";
                        $result = mysqli_query($conexion, $update);
                        if ($result) {
                        }
                    }
                }
            }
        }
        echo $idNumeroConsecutivoRegistro;
    }
}
