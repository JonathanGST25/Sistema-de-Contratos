<div class="modal fade" id="exampleModalToggle" aria-hidden="true" data-bs-backdrop="static" aria-labelledby="staticBackdropLabel" tabindex="-1" data-bs-target="#staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Actualizar información del archivo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="mt-2"><mark>Los campos marcados con <span class="text-danger">*</span> son obligatorios.</mark></h6>
                <form id="formulario_actualizar_archivo" method="POST" enctype="multipart/form-data">
                    <div class="row mt-2 mx-auto form-group">
                        <h6 class="text-secondary">Información del archivo</h6>
                        <input id="idArchivo" name="idArchivo" type="text" hidden>
                        <div class="col-xxl-6 col-md-6 col-sm-12" id="fileSingle">
                            <label for="filesSingle" class="form-label">Subir imagen o archivos <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="filesSingle" name="filesSingle" required>
                        </div>

                        <div class="col-xxl-6 col-md-6 col-sm-12">
                            <label for="fechaRegistro" class="form-label">Fecha de registro</label>
                            <input id="fechaRegistro" class="col-lg-4 col-sm-12 form-control text-center" type="date" name="fechaRegistro" readonly />
                        </div>
                    </div>
                    <div class="row mt-3 mb-3 mx-auto form-group">
                        <div class="col-xxl-12 col-md-12 col-sm-12">
                            <label for="descripcionArchivo" class="form-label">Descripción del Archivo <span class="text-danger">*</span></label>
                            <textarea aria-label="With textarea" class="form-control" id="descripcionArchivo" name="descripcionArchivo" required></textarea>
                        </div>
                    </div>
                    <div class="row mt-3 mb-3 mx-auto form-group justify-content-center">
                        <div class="col-xxl-5 col-md-6 col-sm-12 d-flex justify-content-center mt-2">
                            <button type="button" class="btn btn-secondary col-xxl-4 col-md-3 col-sm-8" class="btn-close" data-bs-dismiss="modal" aria-label="Close">Cerrar</button>
                        </div>
                        <div class="col-xxl-5 col-md-6 col-sm-12 d-flex justify-content-center mt-2">
                            <button class="btn btn-primary col-xxl-4 col-md-3 col-sm-8" type="submit">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>