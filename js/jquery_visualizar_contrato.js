window.onload = function () {
  $("#consultar_contrato").addClass("active");
};

function mostrarImg() {
  var rows = document
    .getElementById("tabla-archivos")
    .getElementsByTagName("tr");
  for (i = 0; i < rows.length; i++) {
    rows[i].onclick = function () {
      var result = this.getElementsByTagName("td")[0];
      if (result.querySelector("img")) {
        var src = result.querySelector("img").src;
        $('#imagen-archivo').attr('src',src);
      }
    };
  }
}

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
              "./php/controladores/visualizar_archivos_contrato.php?revFolio=" +
              idRegistroContrato;
            $("#tabla-archivos-contratos").load(url);
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
