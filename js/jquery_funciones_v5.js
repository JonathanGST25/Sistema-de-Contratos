window.onload = function () {
  $("#registro").addClass("active");
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

//ENVIO DE FORMULARIO
let formulario_registro = document.getElementById("formulario_registro");

formulario_registro.addEventListener("submit", function (e) {
  e.preventDefault();

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
      let numeroContrato = document.getElementById("numeroContrato").value;

      let cadenaConsulta = "bandera=" + 2 + "&numeroContrato=" + numeroContrato;

      $.ajax({
        url: "./php/controladores/consultar_contrato.php",
        type: "POST",
        data: cadenaConsulta,
      })
        .done(function (data) {
          let idRegistroContrato =
            document.getElementById("idRegistroContrato").value;
          if (parseInt(data) === 3 && idRegistroContrato === "") {
            Swal.fire({
              position: "center",
              icon: "warning",
              title: "<h5>Registro existente</h5>",
              text:
                "El contrato de número " +
                document.getElementById("numeroContrato").value +
                ", ya se encuentra registrado",
              showConfirmButton: false,
              allowOutsideClick: false,
              timer: 3000,
            });
            setTimeout(function () {
              window.location.reload();
            }, 3200);
          } else {
            let revFolio = "";
            let cadenaConsultaNumeroConsecutivo = "bandera=" + 1;
            //CONSULTAR NÚMERO CONSECUTIVO
            $.ajax({
              url: "./php/controladores/consultar_contrato.php",
              type: "POST",
              data: cadenaConsultaNumeroConsecutivo,
            })
              .done(function (data) {
                if (data == 1) {
                  document.getElementById("idNumeroConsecutivoRegistro").value =
                    "2023_" + 1;
                } else {
                  let banderaNumeroConsecutivo = document.getElementById(
                    "idNumeroConsecutivoRegistro"
                  ).value;
                  if (banderaNumeroConsecutivo === "") {
                    revFolio = data;
                    let items_separados = revFolio.trim().split("_");
                    let foliConsecutivo = parseInt(items_separados[1]) + 1;
                    document.getElementById(
                      "idNumeroConsecutivoRegistro"
                    ).value = "2023_" + foliConsecutivo;
                  }
                }

                let formData = $("#formulario_registro").serialize();
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
                  type: $("#formulario_registro").attr("method"),
                  url: $("#formulario_registro").attr("action"),
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
                        $("#numeroContrato").prop("readonly", true);
                        $("#fechaContrato").prop("readonly", true);
                        $("#descripcionContrato").prop("readonly", true);
                        document.getElementById("idRegistroContrato").value =
                          document.getElementById(
                            "idNumeroConsecutivoRegistro"
                          ).value;
                        $("#filesMult").val(null);
                        $("#filesSingle").val(null);
                        $("#descripcionArchivo").val(null);
                      }, 3200);
                    }

                    if (parseInt(data) === 2) {
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
                        $("#numeroContrato").prop("readonly", true);
                        $("#fechaContrato").prop("readonly", true);
                        $("#descripcionContrato").prop("readonly", true);
                        document.getElementById("idRegistroContrato").value =
                          document.getElementById(
                            "idNumeroConsecutivoRegistro"
                          ).value;
                        $("#filesMult").val(null);
                        $("#filesSingle").val(null);
                        $("#descripcionArchivo").val(null);

                        let revFolio = document.getElementById(
                          "idNumeroConsecutivoRegistro"
                        ).value;
                        var enlace =
                          "192.168.1.207/versiones-sistemas/fge-sistema-contratos-v2/visualizador_contratos.php?revFolio=" +
                          revFolio;

                        var qr = new QRious({
                          value: enlace,
                          size: 128,
                        });

                        var qrImage = qr.toDataURL("image/png");

                        var pdf = new jsPDF();
                        pdf.addImage(qrImage, "PNG", 170, 230, 30, 30);
                        let contrato =
                          document.getElementById("numeroContrato").value;
                        pdf.save(contrato + ".pdf");
                      }, 3200);
                    }
                  },
                });
              })
              .fail(function () {
                console.log("Error");
              })
              .always(function () {
                console.log("Complete");
              });
          }
        })
        .fail(function () {
          console.log("Error");
        })
        .always(function () {
          console.log("Complete;");
        });
    }
  });
});
