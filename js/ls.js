window.onload = function () {
  $("#registro").addClass("active");
};

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
//EVITAR ENVÍO DE FORMULARIO
(function () {
  "use strict";

  var formRegistro = document.getElementById("formulario_registro");

  formRegistro.addEventListener("submit", function (event) {
    if (!formRegistro.checkValidity()) {
      event.preventDefault();
      event.stopPropagation();
    }

    $("#formulario_registro").addClass("was-validated");

    if (formRegistro.checkValidity()) {
      event.preventDefault();

      event.stopPropagation();

      //CONSULTAR
      let numeroContrato = document.getElementById("numeroContrato").value;
      let ruta = "bandera=" + 2 + "&numeroContrato=" + numeroContrato;
      $.ajax({
        url: "./php/controladores/consultar_contrato.php",
        type: "POST",
        data: ruta,
      })
        .done(function (res) {
          if (res == 3 && document.getElementById("idRegistroContrato") == "") {
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
            //ENVIO PARA CONSULTAR NÚMERO CONSECUTIVO
            let revFolio = "";
            let ruta1 = "bandera=" + 1;
            //CONSULTAR NÚMERO CONSECUTIVO
            $.ajax({
              url: "./php/controladores/consultar_contrato.php",
              type: "POST",
              data: ruta1,
            })
              .done(function (res) {
                if (res == 1) {
                  document.getElementById("idNumeroConsecutivoRegistro").value =
                    "2023_" + 1;
                } else {
                  revFolio = res;
                  let items_separados = revFolio.trim().split("_");
                  let foliConsecutivo = parseInt(items_separados[1]) + 1;

                  document.getElementById("idNumeroConsecutivoRegistro").value =
                    "2023_" + foliConsecutivo;
                }

                var formData = $("#formulario_registro").serialize();

                var filesMultInput = document.getElementById("filesMult");
                var fileInput = document.getElementById("filesSingle");
                var fd = new FormData();

                var file = fileInput.files[0];

                // Agrega los campos serializados al objeto FormData
                fd.append("form_data", formData);

                // Agrega los archivos al objeto FormData
                fd.append("filesSingle", file);

                for (var i = 0; i < filesMultInput.files.length; i++) {
                  fd.append("filesMult[]", filesMultInput.files[i]);
                }

                $.ajax({
                  type: $("#formulario_registro").attr("method"),
                  url: $("#formulario_registro").attr("action"),
                  data: fd,
                  processData: false,
                  contentType: false,
                  success: function (res) {
                    console.log(res);
                    if (parseInt(res) === 1) {
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
                        $("#numeroContrato").prop("disabled", true);
                        $("#fechaContrato").prop("disabled", true);
                        $("#descripcionContrato").prop("disabled", true);
                        document.getElementById("idRegistroContrato").value =
                          document.getElementById(
                            "idNumeroConsecutivoRegistro"
                          ).value;
                        $("#filesMult").val(null);
                        $("#filesSingle").val(null);
                        $("#descripcionArchivo").val(null);
                      }, 3200);
                    } else {
                      var enlace =
                        "fge-sistema-contratos/php/controladores/generarQR.php?ivFolio=" +
                        res;
                      var qrcodeContainer = document.getElementById("qrcode");

                      var qrcode = new QRCode(qrcodeContainer, {
                        text: enlace,
                        width: 128,
                        height: 128,
                      });

                      const divToConvert = document.getElementById("qrcode");

                      html2canvas(divToConvert).then(function (canvas) {
                        const imgData = canvas.toDataURL("image/png");

                        const pdf = new jsPDF();

                        pdf.addImage(imgData, "PNG", 10, 10, 270, 30);
                        let contrato =
                          document.getElementById("numeroContrato").value;

                        pdf.save(contrato + ".pdf");
                      });

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
                        $("#numeroContrato").prop("disabled", true);
                        $("#fechaContrato").prop("disabled", true);
                        $("#descripcionContrato").prop("disabled", true);
                        document.getElementById("idRegistroContrato").value =
                          document.getElementById(
                            "idNumeroConsecutivoRegistro"
                          ).value;
                        $("#filesMult").val(null);
                        $("#filesSingle").val(null);
                        $("#descripcionArchivo").val(null);
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
          console.log("Complete");
        });
    }
  });
})();
