/// <reference path="./node_modules/@types/jquery/index.d.ts" />

$(document).ready(() => {
  if (!localStorage.getItem("token")) {
    location.assign("login.php");
  } else {
    Verificar();
  }

  MostrarLista();

  $("#agregarBtn").on("click", e => {
    e.preventDefault();
    AgregarEmpleado();
  });

  $("#foto").on("change", event => {
    var reader = new FileReader();
    reader.onload = function() {
      var output: any = document.getElementById("imgFoto");
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  });

  $("#cancelar").on("click", () => {
    $("#span").html("Crear");
  });
});

function AgregarEmpleado(): void {
  let nombre = $("#nombre").val();
  let apellido = $("#apellido").val();
  let legajo = $("#legajo").val();
  let sueldo = $("#sueldo").val();
  let clave = $("#clave").val();
  let foto: any = $("#foto")[0];
  let token: string =
    <string>localStorage.getItem("token") !== null
      ? <string>localStorage.getItem("token")
      : "";

  let empleado: any = {
    nombre: nombre,
    apellido: apellido,
    legajo: legajo,
    sueldo: sueldo,
    clave: clave
  };

  let url = "./BACKEND/empleados";
  let hacer = true;

  if ($("#span").html() === "Modificar") {
    if (
      confirm(
        "Esta seguro que quiere modificar a " +
          $("#oldName").val() +
          ", legajo: " +
          legajo +
          "?"
      )
    ) {
      url = "./BACKEND/empleados/modificar";
      empleado.id = $("#idEmpleado").val();
      empleado.token = token;
    } else {
      hacer = false;
    }
  }

  let formData: FormData = new FormData();
  formData.append("datos", JSON.stringify(empleado));
  formData.append("foto", foto.files[0]);

  if (hacer) {
    $.ajax({
      type: "POST",
      url: url,
      dataType: "json",
      cache: false,
      data: formData,
      contentType: false,
      processData: false,
      async: true
    })
      .done(response => {
        if (response.exito == true) {
          Alerta(response.msg, "alert-success");
          MostrarLista();
          $("#miFormulario").trigger("reset");
          $("#span").html("Crear");
          (<HTMLImageElement>document.getElementById("imgFoto")).src =
            "BACKEND/usr_default.jpg";
        } else {
          Alerta(response.msg, "alert-danger");
        }
      })
      .fail((jqXHR, textStatus, errorThrown) => {
        Alerta(JSON.parse(jqXHR.responseText).msg, "alert-warning");
      });
  }
}

function MostrarLista(): void {
  $.ajax({
    type: "GET",
    url: "./BACKEND/empleados",
    dataType: "json",
    cache: false,
    contentType: false,
    processData: false,
    async: true
  })
    .done(response => {
      if (Array.isArray(response)) {
        let empleados: Array<any> = response;
        let tabla =
          "<table class='table table-light table-striped'><thead><tr><th class='text-center'>ID</th><th class='text-center'>Nombre</th><th class='text-center'>Apellido</th><th class='text-center'>Sueldo</th><th class='text-center'>Foto</th><th class='text-center'>Legajo</th><th class='text-center'>Acciones</th></tr></thead><tbody>";
        empleados.forEach(empleado => {
          tabla += `<tr>
                            <td class='text-center align-middle'>${
                              empleado.id
                            }</td>
                            <td class='text-center align-middle'>${
                              empleado.nombre
                            }</td>
                            <td class='text-center align-middle'>${
                              empleado.apellido
                            }</td>
                            <td class='text-center align-middle'>${
                              empleado.sueldo
                            }</td>
                            <td class='text-center align-middle'><img height="42" width="42" src=${
                              empleado.foto
                            }></td>
                            <td class='text-center align-middle'>${
                              empleado.legajo
                            }</td>
                            <td class='text-center align-middle'>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <button type="button" id="eliminar" onclick='Eliminar(${JSON.stringify(
                                          empleado
                                        )})' class="btn btn-outline-danger btn-block mb-1"><i class="fas fa-trash"></i></button>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <button type="button" id="modificar" onclick='Modificar(${JSON.stringify(
                                          empleado
                                        )})' class="btn btn-outline-warning btn-block"><i class="fas fa-edit"></i></button>
                                    </div>
                                </div>
                            </td>
                        </tr>`;
        });
        tabla += "</tbody></tabla>";
        $("#tabla").html(tabla);
      } else {
        alert(response.msg);
        $("#tabla").html("");
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      console.log(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });
}

function Eliminar(obj: any): void {

  if (confirm("Esta seguro que quiere eliminar a " + obj.nombre + ", legajo: " + obj.legajo + "?")){

    let token: string = <string>localStorage.getItem("token") !== null ? <string>localStorage.getItem("token") : "";

    $.ajax({
      type: "DELETE",
      url: "./BACKEND/empleados/" + obj.id,
      headers: { token: token },
      dataType: "json",
      cache: false,
      contentType: false,
      processData: false,
      async: true
    })
    .done(response => {
      if (response.exito == true) {
        Alerta(response.msg, "alert-success");
        MostrarLista();
      } else {
        Alerta(response.msg, "alert-danger");
        if (response.tipo === "token"){
          location.assign("login.php");
        }
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      Alerta(JSON.parse(jqXHR.responseText).msg, "alert-warning");
    });
  }
}

function Modificar(obj: any): void {
  $("#nombre").val(obj.nombre);
  $("#apellido").val(obj.apellido);
  $("#legajo").val(obj.legajo);
  $("#legajo").prop("readonly", true);
  $("#sueldo").val(obj.sueldo);
  $("#clave").val(obj.clave);
  $("#imgFoto").prop("src", obj.foto);
  $("#idEmpleado").val(obj.id);
  $("#oldName").val(obj.nombre);
  $("#span").html("Modificar");
}

function Verificar() {
  let token = <string>localStorage.getItem("token");
  $.ajax({
    type: "GET",
    url: "./BACKEND/empleados/verificar",
    headers: { token: token },
    dataType: "json",
    cache: false,
    contentType: false,
    processData: false,
    async: true
  })
    .done(response => {
      if (!response.exito) {
        location.assign("login.php");
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });
}

function Alerta(msg: string, tipoAlert: string) {
  $("#msgAlert").html(msg);
  $("#alert").addClass(tipoAlert);
  $("#alert").removeClass("d-none");
  setInterval(() => {
    $("#alert").addClass("d-none");
    $("#alert").removeClass(tipoAlert);
  }, 5000);
}
