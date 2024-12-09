window.onload = function () {
  $("#gestion_contratos").addClass("active");
};

let formulario_buscar_contrato = document.getElementById(
  "formulario_buscar_contrato"
);

formulario_buscar_contrato.addEventListener("submit", function (e) {
  e.preventDefault();

  let numeroContrato = document.getElementById("numeroContratoBusqueda").value;
  let cadena = "bandera=2" + "&numeroContrato=" + numeroContrato;
  $.ajax({
    url: "./php/controladores/consultar_contrato.php",
    type: "POST",
    data: cadena,
    success: function (data) {
      let estatus = parseInt(data);
      if (estatus == 3) {
        $.ajax({
          url: "./php/controladores/buscar_contrato.php",
          type: "POST",
          data: cadena,
          success: function (data) {
            datos = JSON.parse(data);
            document.getElementById("numeroContrato").value =
              datos["numeroContrato"];
            document.getElementById("fechaContrato").value =
              datos["fechaContrato"];
            document.getElementById("descripcionContrato").value =
              datos["descripcionContrato"];

            let idRegistroContrato = datos["idRegistroContrato"];
            var url =
              "./php/controladores/consultar_archivos_contratos.php?revFolio=" +
              idRegistroContrato;
            $("#body-table").load(url);
          },
        });
      } else {
        Swal.fire({
          position: "center",
          icon: "warning",
          title: "<h5>Sin Coincidencias.</h5>",
          text: "Favor de verificar el número de contrato",
          showConfirmButton: false,
          allowOutsideClick: false,
          timer: 3000,
        });
      }
    },
  });
});

function eliminarArchivo() {
  var rows = document.getElementById("table-files").getElementsByTagName("tr");
  for (i = 0; i < rows.length; i++) {
    rows[i].onclick = function () {
      var cell = this.getElementsByTagName("td")[0].innerHTML;

      Swal.fire({
        title: "<h5>Eliminación de Archivo</h5>",
        text: "¿Está seguro de eliminar el acrhivo?",
        showCancelButton: true,
        confirmButtonColor: "#198754",
        cancelButtonColor: "#dc3545",
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
        showCloseButton: true,
      }).then((result) => {
        if (result.isConfirmed) {
          let cadena = "idArchivo=" + cell + "&bandera=1";
          $.ajax({
            url: "./php/controladores/gestion_archivo.php",
            type: "POST",
            data: cadena,
          })
            .done(function (data) {
              if (parseInt(data) === 1) {
                Swal.fire({
                  position: "center",
                  icon: "success",
                  title: "<h5>Archivo Eliminado!</h5>",
                  text: "El archivo ha sido eliminado exitosamente.",
                  showConfirmButton: false,
                  allowOutsideClick: false,
                  timer: 3000,
                });
              }
            })
            .fail(function () {
              console.log("Error");
            })
            .always(function () {
              console.log("Complete");
            });
          setTimeout(function () {
            window.location.reload();
          }, 3200);
        }
      });
    };
  }
}

function actualizarArchivo() {
  var rows = document.getElementById("table-files").getElementsByTagName("tr");
  for (i = 0; i < rows.length; i++) {
    rows[i].onclick = function () {
      var idArchivo = this.getElementsByTagName("td")[0].innerHTML;
      var fechaRegistro = this.getElementsByTagName("td")[1].innerHTML;
      var descripcion = this.getElementsByTagName("td")[3].innerHTML;
      document.getElementById("idArchivo").value = idArchivo;
      document.getElementById("fechaRegistro").value = fechaRegistro;
      document.getElementById("descripcionArchivo").value = descripcion;
    };
  }
}

let formulario_actualizar_archivo = document.getElementById(
  "formulario_actualizar_archivo"
);
formulario_actualizar_archivo.addEventListener("submit", function (e) {
  e.preventDefault();

  Swal.fire({
    title: "<h5>Actualización del archivo</h5>",
    text: "¿Está seguro de actualizar el acrhivo?",
    showCancelButton: true,
    confirmButtonColor: "#198754",
    cancelButtonColor: "#dc3545",
    confirmButtonText: "Aceptar",
    cancelButtonText: "Cancelar",
    showCloseButton: true,
  }).then((result) => {
    if (result.isConfirmed) {
      let formData = $("#formulario_actualizar_archivo").serialize();
      let fileSingleInput = document.getElementById("filesSingle");
      let fd = new FormData();
      fd.append("form_data", formData);
      let fileSingle = fileSingleInput.files[0];
      fd.append("filesSingle", fileSingle);

      $.ajax({
        type: $("#formulario_actualizar_archivo").attr("method"),
        url: './php/controladores/actualizar_archivo.php',
        data: fd,
        processData: false,
        contentType: false,
        success: function (data) {
          //console.log(data);
          if (parseInt(data) === 1) {
            Swal.fire({
              position: "center",
              icon: "success",
              title: "<h5>Actualizado</h5>",
              text: "La información ha sido actualizada.",
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
    }
  });
});


