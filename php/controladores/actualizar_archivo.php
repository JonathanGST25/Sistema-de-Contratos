<?php
include('../conexion.php');

$formData = $_POST['form_data'];
parse_str($formData, $formArray);

$idArchivo = $formArray['idArchivo'];
$descripcionArchivo = $formArray['descripcionArchivo'];

if (!empty($_FILES['filesSingle']['name'])) {

    $query_consultar_archivo = "SELECT rutaArchivo FROM archivos WHERE idArchivo = '$idArchivo'";
    $result_query = mysqli_query($conexion, $query_consultar_archivo);

    if ($result_query) {

        $mostrar_ruta_archivo = mysqli_fetch_array($result_query);
        $ruta_archivo = $mostrar_ruta_archivo['rutaArchivo'];

        if (file_exists($_FILES['filesSingle']['tmp_name'])) {

            if (file_exists($ruta_archivo)) {
                if (unlink($ruta_archivo)) {
                    $informacion_archivo = pathinfo($ruta_archivo);
                    $ruta_sin_extension = $informacion_archivo['dirname'] . '/' . $informacion_archivo['filename'];
                    $archivo = $_FILES['filesSingle']['name'];
                    $extension_archivo = pathinfo($archivo, PATHINFO_EXTENSION);
                    $ruta = $ruta_sin_extension . '.' . $extension_archivo;

                    if (move_uploaded_file($_FILES['filesSingle']['tmp_name'], $ruta)) {

                        $update_archivo = "UPDATE archivos SET rutaArchivo = '$ruta', descripcionArchivo = '$descripcionArchivo' WHERE idArchivo = '$idArchivo'";
                        $result_update = mysqli_query($conexion, $update_archivo);

                        if ($result_update) {

                            echo 1;
                        }
                    }
                }else{
                    echo 0;
                }
            }else{
                echo 0;
            }
        }
    }
}
