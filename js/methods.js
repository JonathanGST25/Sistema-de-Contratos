window.onload = function () {
  $("#registrar_usuarios").addClass("active");
};

let formulario_registrar_user = document.getElementById(
  "formulario_agregar_usuario"
);

formulario_registrar_user.addEventListener("submit", function (e) {
  e.preventDefault();

  let password1 = document.getElementById("password").value;
  let password2 = document.getElementById("password1").value;

  if (password1 === password2) {
    Swal.fire({
      title: "<h5>Guardar información</h5>",
      text: "¿Desea guardar la información?",
      showCancelButton: true,
      confirmButtonColor: "#198754",
      cancelButtonColor: "#dc3545",
      confirmButtonText: "Aceptar",
      cancelButtonText: "Cancelar",
      showCloseButton: true,
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: $("#formulario_agregar_usuario").attr("action"),
          type: $("#formulario_agregar_usuario").attr("method"),
          data: $("#formulario_agregar_usuario").serialize(),
          success: function (data) {
            if (parseInt(data) === 1) {
              Swal.fire({
                position: "center",
                icon: "success",
                title: "<h5>Registro completo</h5>",
                text: "Usuario registrado correctamente.",
                showConfirmButton: false,
                allowOutsideClick: false,
                timer: 3000,
              });
              setTimeout(function () {
                window.location.reload();
              }, 3200);
            }

            if (parseInt(data) === 0) {
              Swal.fire({
                position: "center",
                icon: "warning",
                title: "<h5>Usuario no disponible.</h5>",
                text: "Ya existe un registro con ese nombre de usuario.",
                showConfirmButton: false,
                allowOutsideClick: false,
                timer: 3000,
              });
            }
          },
        });
      }
    });
  } else {
    Swal.fire({
      position: "center",
      icon: "warning",
      title: "<h5>Las contraseñas no coinciden..</h5>",
      text: "Favor de verificar que las contraseñas coincidan.",
      showConfirmButton: false,
      allowOutsideClick: false,
      timer: 3000,
    });
  }
});

