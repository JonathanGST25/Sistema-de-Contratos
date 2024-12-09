window.onload = function () {
  $("#gestion_usuarios").addClass("active");
};

function deleteUser() {
  var rows = document
    .getElementById("tabla_usuarios")
    .getElementsByTagName("tr");
  for (i = 0; i < rows.length; i++) {
    rows[i].onclick = function () {
      var idUser = this.getElementsByTagName("td")[0].innerHTML;
      Swal.fire({
        title: "<h5>Eliminación de usuario</h5>",
        text: "¿Está seguro de eliminar el usuario?",
        showCancelButton: true,
        confirmButtonColor: "#198754",
        cancelButtonColor: "#dc3545",
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
        showCloseButton: true,
      }).then((result) => {
        if (result.isConfirmed) {
          let cadena = "idUsuario=" + idUser + "&bandera=1";
          $.ajax({
            url: "./php/controladores/eliminar_usuario.php",
            type: "POST",
            data: cadena,
          })
            .done(function (data) {
              if (parseInt(data) === 1) {
                Swal.fire({
                  position: "center",
                  icon: "success",
                  title: "<h5>Usuario Eliminado!</h5>",
                  text: "El usuario ha sido eliminado exitosamente.",
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
                  icon: "error",
                  title: "<h5>Usuario no eliminado!</h5>",
                  text: "Ha surgido un problema, el usuario no ha podido ser eliminado",
                  showConfirmButton: false,
                  allowOutsideClick: false,
                  timer: 3000,
                });
                setTimeout(function () {
                  window.location.reload();
                }, 3200);
              }
            })
            .fail(function () {
              console.log("Error");
            })
            .always(function () {
              console.log("Complete");
            });
        }
      });
    };
  }
}

function selectUserUpdate() {
  var rows = document
    .getElementById("tabla_usuarios")
    .getElementsByTagName("tr");
  for (i = 0; i < rows.length; i++) {
    rows[i].onclick = function () {
      var usuarioId = this.getElementsByTagName("td")[0].innerHTML;
      let cadena = "usuarioId=" + usuarioId;
      $.ajax({
        url: "./php/controladores/consultar_usuario.php",
        type: "POST",
        data: cadena,
        success: function (data) {
          var datos = [];
          datos = JSON.parse(data);
          document.getElementById("idUsuario").value = usuarioId;
          document.getElementById("nombreUsuarioEdit").value =
            datos["nombreUsuario"];
          document.getElementById("apellidoPaterno").value =
            datos["apellidoPaterno"];
          document.getElementById("apellidoMaterno").value =
            datos["apellidoMaterno"];
          document.getElementById("usuario").value = datos["usuario"];
          document.getElementById("password_actual").value = datos["password"];

          let selectRol = document.getElementById("rolUsuario");
          let rol = datos["idRol"];
          for (let indexr = 0; indexr < selectRol.options.length; indexr++) {
            let option = selectRol.options[indexr];
            if (option.value == rol) {
              option.selected = true;
              break;
            }
          }

          let selectEstatus = document.getElementById("estatus");
          let datosActivo = datos["activo"];
          for (let index = 0; index < selectEstatus.options.length; index++) {
            let option = selectEstatus.options[index];
            if (option.value == datosActivo) {
              option.selected = true;
              break;
            }
          }
        },
      });
    };
  }
}

let formulario_actualizar_usuario = document.getElementById(
  "formulario_actualizar_usuario"
);

formulario_actualizar_usuario.addEventListener("submit", function (e) {
  e.preventDefault();

  Swal.fire({
    title: "<h5>Actualización de usuario</h5>",
    text: "¿Está seguro de actualizar el usuario?",
    showCancelButton: true,
    confirmButtonColor: "#198754",
    cancelButtonColor: "#dc3545",
    confirmButtonText: "Aceptar",
    cancelButtonText: "Cancelar",
    showCloseButton: true,
  }).then((result) => {
    if (result.isConfirmed) {
      let password1 = document.getElementById("password_new").value;
      let password2 = document.getElementById("password_new1").value;

      if (password1 == password2 || (password1 == "" && password2 == "")) {
        $.ajax({
          url: "./php/controladores/actualizar_usuario.php",
          type: "POST",
          data: $("#formulario_actualizar_usuario").serialize(),
          success: function (data) {
            if (parseInt(data) === 1) {
              Swal.fire({
                position: "center",
                icon: "success",
                title: "<h5>Información actualizada!</h5>",
                text: "La información del usuario ha sido actualizada correctamente.",
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
                icon: "error",
                title: "<h5>Error al actualizar!</h5>",
                text: "Ha surgido un problema, la información del usuario no ha podido ser actualizada",
                showConfirmButton: false,
                allowOutsideClick: false,
                timer: 3000,
              });
              setTimeout(function () {
                window.location.reload();
              }, 3200);
            }
          },
        });
      } else {
        Swal.fire({
          position: "center",
          icon: "warning",
          title: "<h5>Contraseña Inválida</h5>",
          text: "Favor de confirmar que las contraseñas sean iguales",
          showConfirmButton: false,
          allowOutsideClick: false,
          timer: 3000,
        });
        setTimeout(function () {
          document.getElementById("password_new").value = "";
          document.getElementById("password_new1").value = "";
        }, 3200);
      }
    }
  });
});
