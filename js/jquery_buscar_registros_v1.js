window.onload = function () {
  $("#buscar_registros").addClass("active");
};

//HABILITAR INPUT FILE MULTIPLE O SINGLE
function handleEventSelect() {
  let valueSelect = document.getElementById("opcionesDocumento").value;

  if (valueSelect == 1) {
    document.getElementById("fileMultiple").style.display = "block";
    $("#filesMult").prop("disabled", false);
    document.getElementById("fileSingle").style.display = "none";
    $("#filesSingle").prop("disabled", true);
  } else {
    document.getElementById("fileMultiple").style.display = "none";
    $("#filesMult").prop("disabled", true);
    document.getElementById("fileSingle").style.display = "block";
    $("#filesSingle").prop("disabled", false);
  }
}

//BUSCAR CONTRATO
let formulario_buscar = document.getElementById("formulario_buscar");

formulario_buscar.addEventListener("submit", function (e) {
  e.preventDefault();

  let numeroContrato = document.getElementById("numeroContratoBusqueda").value;

  let cadena = "bandera=2" + "&numeroContrato=" + numeroContrato;

  $.ajax({
    url: "./php/controladores/consultar_contrato.php",
    type: "POST",
    data: cadena,
  })
    .done(function (data) {
      if (parseInt(data) === 3) {
        $("#opcionesDocumento").prop("disabled", false);
        $("#filesMult").prop("disabled", false);
        $("#descripcionArchivo").prop("disabled", false);
        $("#btn-guardar").prop("disabled", false);
        $("#btn-qr").prop("disabled", false);

        let cadena = "numeroContrato=" + numeroContrato;
        $.ajax({
          url: "./php/controladores/buscar_contrato.php",
          type: "POST",
          data: cadena,
        })
          .done(function (data) {
            let datos = [];

            datos = JSON.parse(data);

            document.getElementById("numeroContrato").value =
              datos["numeroContrato"];
            document.getElementById("fechaContrato").value =
              datos["fechaContrato"];
            document.getElementById("descripcionContrato").value =
              datos["descripcionContrato"];
            document.getElementById("idRegistroContrato").value =
              datos["idRegistroContrato"];
          })
          .fail(function () {
            console.log("Error");
          })
          .always(function () {
            console.log("Complete");
          });
      }

      if (parseInt(data) === 0) {
        Swal.fire({
          position: "center",
          icon: "warning",
          title: "<h5>Sin coincidencias en el registro</h5>",
          text:
            "El contrato de número " +
            document.getElementById("numeroContratoBusqueda").value +
            ", no se encuentra registrado",
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
});

//AGREGAR IMAGENES AL CONTRATO
let formulario_agregar = document.getElementById("formulario_agregar");

formulario_agregar.addEventListener("submit", function (e) {
  e.preventDefault();

  Swal.fire({
    title: "<h5>Guardar Información</h5>",
    text: "¿Está seguro de registrar la información?",
    showCancelButton: true,
    confirmButtonColor: "#198754",
    cancelButtonColor: "#dc3545",
    confirmButtonText: "Aceptar",
    cancelButtonText: "Cancelar",
    showCloseButton: true,
  }).then((result) => {
    if (result.isConfirmed) {
      let formData = $("#formulario_agregar").serialize();
      let filesMultInput = document.getElementById("filesMult");
      let fileSingleInput = document.getElementById("filesSingle");
      let fd = new FormData();

      fd.append("form_data", formData);

      let fileSingle = fileSingleInput.files[0];

      fd.append("filesSingle", fileSingle);

      for (var i = 0; i < filesMultInput.files.length; i++) {
        fd.append("filesMult[]", filesMultInput.files[i]);
      }

      $.ajax({
        type: $("#formulario_agregar").attr("method"),
        url: $("#formulario_agregar").attr("action"),
        data: fd,
        processData: false,
        contentType: false,
        success: function (data) {
          console.log("RESULTADO");
          console.log(data);
          console.log("--------------");
          if (parseInt(data) === 1) {
            Swal.fire({
              position: "center",
              icon: "success",
              title: "<h5>Registro completo</h5>",
              text: "Información registrada correctamente.",
              showConfirmButton: false,
              allowOutsideClick: false,
              timer: 3000,
            });
            setTimeout(function () {
              $("#filesMult").val(null);
              $("#filesSingle").val(null);
              $("#descripcionArchivo").val(null);
            }, 3200);
          }
        },
      });
    }
  });
});

function generarQR() {
  Swal.fire({
    title: "<h5>Generar QR</h5>",
    text: "¿Desea generar el código QR del contrato?",
    showCancelButton: true,
    confirmButtonColor: "#198754",
    cancelButtonColor: "#dc3545",
    confirmButtonText: "Aceptar",
    cancelButtonText: "Cancelar",
    showCloseButton: true,
  }).then((result) => {
    if (result.isConfirmed) {
      let revFolio = document.getElementById("idRegistroContrato").value;
      var enlace =
      "10.1.90.194/versiones-sistemas/fge-sistema-contratos-v2/index.php?revFolio=" +
      revFolio

      var qr = new QRious({
        value: enlace,
        size: 128,
      });

      var qrImage = qr.toDataURL("image/png");

      var pdf = new jsPDF();
      pdf.addImage(qrImage, "PNG", 170, 230, 30, 30);
      let contrato = document.getElementById("numeroContrato").value;
      pdf.save(contrato + ".pdf");
    }
  });
}
