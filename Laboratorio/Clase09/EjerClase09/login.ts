/// <reference path="./node_modules/@types/jquery/index.d.ts" />

$(document).ready(() => {
  $("#loginBtn").click(e => {
    e.preventDefault();
    Login();
  });

  $("#crearBtn").click(e => {
    e.preventDefault();
    Crear();
  });
});

function Login(): void {
  let legajo = $("#legajoLogin").val();
  let clave = $("#claveLogin").val();
  $.ajax({
    type: "GET",
    url: "./BACKEND/empleados/login" + `?legajo=${legajo}&clave=${clave}`,
    dataType: "json",
    cache: false,
    contentType: false,
    processData: false,
    async: true
  })
    .done(response => {
      if (response.exito) {
        localStorage.setItem("token", response.token);
        location.assign("index.html");
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });
}

function Crear(): void {
  let nombre = $("#nombre").val();
  let apellido = $("#apellido").val();
  let legajo = $("#legajo").val();
  let sueldo = $("#sueldo").val();
  let clave = $("#clave").val();
  let foto: any = $("#foto")[0];

  let empleado: any = {
    nombre: nombre,
    apellido: apellido,
    legajo: legajo,
    sueldo: sueldo,
    clave: clave
  };

  let formData: FormData = new FormData();
  formData.append("datos", JSON.stringify(empleado));
  formData.append("foto", foto.files[0]);

  $.ajax({
    type: "POST",
    url: "./BACKEND/empleados",
    dataType: "json",
    cache: false,
    data: formData,
    contentType: false,
    processData: false,
    async: true
  })
    .done(response => {
      if (response.exito == true) {
        $("#miFormulario").trigger("reset");
        $("#crearModal").modal("hide"); //funciona pero no lo reconoce
        ManejoAlert(response.msg, "alert-success");
      } else {
        ManejoAlert(response.msg, "alert-danger");
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      ManejoAlert(JSON.parse(jqXHR.responseText).msg, "alert-warning");
    });
}

function ManejoAlert(msg: string, tipoAlert: string) {
  $("#msgAlert").html(msg);
  $("#alert").addClass(tipoAlert);
  $("#alert").removeClass("d-none");
  setInterval(() => {
    $("#alert").addClass("d-none");
    $("#alert").removeClass(tipoAlert);
  }, 5000);
}
