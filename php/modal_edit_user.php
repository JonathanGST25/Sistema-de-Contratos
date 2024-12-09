<div class="modal fade" id="exampleModalToggle" aria-hidden="true" data-bs-backdrop="static" aria-labelledby="staticBackdropLabel" tabindex="-1" data-bs-target="#staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Actualizar información del usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="mt-2"><mark>Los campos marcados con <span class="text-danger">*</span> son obligatorios.</mark></h6>
                <form id="formulario_actualizar_usuario" method="POST">
                    <div class="row mt-2 mx-auto form-group">
                        <h6 class="text-secondary">Información general del usuario</h6>
                        <input id="idUsuario" name="idUsuario" type="text" hidden>
                        <div class="col-xxl-6 col-md-6 col-sm-12">
                            <label for="nombreUsuarioEdit" class="form-label">Nombre(s) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control text-center" id="nombreUsuarioEdit" name="nombreUsuarioEdit" required>
                        </div>

                        <div class="col-xxl-6 col-md-6 col-sm-12">
                            <label for="apellidoPaterno" class="form-label">Apellido Paterno <span class="text-danger">*</span></label>
                            <input id="apellidoPaterno" class="col-lg-4 col-sm-12 form-control text-center" type="text" name="apellidoPaterno" required />
                        </div>
                    </div>
                    <div class="row mt-3 mb-3 mx-auto form-group">
                        <div class="col-xxl-6 col-md-12 col-sm-12">
                            <label for="apellidoMaterno" class="form-label">Apellido Materno <span class="text-danger">*</span></label>
                            <input type="text" class="col-lg-4 col-sm-12 form-control text-center" id="apellidoMaterno" name="apellidoMaterno" required />
                        </div>
                    </div>
                    <h6 class="text-secondary">Información de la cuenta</h6>
                    <div class="row mt-3 mb-3 mx-auto form-group">
                        <div class="col-xxl-6 col-md-12 col-sm-12">
                            <label for="usuario" class="form-label">Usuario</label>
                            <input type="text" class="col-lg-4 col-sm-12 form-control text-center" id="usuario" name="usuario" readonly />
                        </div>

                        <div class="col-xxl-6 col-md-12 col-sm-12">
                            <label for="password_actual" class="form-label">Contraseña actual</label>
                            <input type="password" class="col-lg-4 col-sm-12 form-control text-center" id="password_actual" name="password_actual" autocomplete="off" readonly />
                        </div>

                        <div class="col-xxl-6 col-md-12 col-sm-12">
                            <label for="password_new" class="form-label">Nueva contraseña</label>
                            <input type="password" class="col-lg-4 col-sm-12 form-control text-center" id="password_new" name="password_new" autocomplete="off" />
                        </div>

                        <div class="col-xxl-6 col-md-12 col-sm-12">
                            <label for="password_new1" class="form-label">Repita la nueva contraseña</label>
                            <input type="password" class="col-lg-4 col-sm-12 form-control text-center" id="password_new1" name="password_new1" autocomplete="off" />
                        </div>

                        <div class="col-xxl-6 col-md-12 col-sm-12">
                            <label for="rolUsuario" class="form-label">Rol</label>
                            <select class="form-select text-center" data-val="true" name="rolUsuario" id="rolUsuario" required>
                                <?php
                                if ($result_query_consultar_roles) {
                                    while ($mostrar_roles = mysqli_fetch_array($result_query_consultar_roles)) {
                                ?>
                                        <option value="<?php echo $mostrar_roles['idRolUsuario'] ?>"><?php echo $mostrar_roles['descripcion'] ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-xxl-6 col-md-12 col-sm-12">
                            <label for="estatus" class="form-label">Estatus</label>
                            <select class="form-select text-center" data-val="true" name="estatus" id="estatus" required>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>

                    </div>

                    <div class="row mt-5 mb-3 mx-auto form-group justify-content-center">
                        <div class="col-xxl-6 col-md-6 col-sm-12 d-flex justify-content-center mt-2">
                            <button type="button" class="btn btn-secondary col-xxl-5 col-md-3 col-sm-8" class="btn-close" data-bs-dismiss="modal" aria-label="Close">Cerrar</button>
                        </div>
                        <div class="col-xxl-6 col-md-6 col-sm-12 d-flex justify-content-center mt-2">
                            <button class="btn btn-primary col-xxl-5 col-md-3 col-sm-8" type="submit">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>