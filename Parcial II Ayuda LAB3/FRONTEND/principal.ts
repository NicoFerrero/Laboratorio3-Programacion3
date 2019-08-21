/// <reference path="../node_modules/@types/jquery/index.d.ts" />

class Principal{
    public static Verificar(): void{
        let token: string = <string>localStorage.getItem("token");
        $.ajax({
          type: "GET",
          url: "./BACKEND/login/",
          headers: { token: token },
          dataType: "json",
          cache: false,
          contentType: false,
          processData: false,
          async: true
        })
        .done(response => {
            //Principal.ManejoAlert(response.msg, "alert-success");
        })
        .fail((jqXHR) => {
            Principal.ManejoAlert(JSON.parse(jqXHR.responseText).msg, "alert-warning");
            location.assign("login.html");
        });
    }

    public static ManejoAlert(msg: string, tipoAlert: string): void{
        $("#msg").html(msg);
        $("#alert").addClass(tipoAlert);
        $("#alert").removeClass("hidden");
        $("#alert").addClass("show");
        setInterval(() => {
            $("#alert").addClass("hidden");
            $("#alert").removeClass("show");
            $("#alert").removeClass(tipoAlert);
        }, 5000);
    }

    public static ArmarTabla(): void{
        let userActual: any = JSON.parse(<string>localStorage.getItem('usuarioActual'));

        let listaString: string = ` <div class="table-responsive">
        <table class="table table-striped" id="tablaUsers">
            <thead>
                <th>ID</th>
                <th>Correo</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Perfil</th>
                <th>Foto</th>`;

        if (userActual.perfil !== "empleado") {
            listaString += `<th>Acciones</th>`;
        }

        listaString += `</thead><tbody>`;

        for (let user of JSON.parse(<string>localStorage.getItem('usuarios'))) {
            listaString += `<tr>
            <td>`+ user.id + `</td>
            <td>`+ user.correo + `</td>
            <td>`+ user.nombre + `</td>
            <td>`+ user.apellido + `</td>
            <td>`+ user.perfil + `</td>
            <td><img src=${user.foto} height="50px" width="50px"></td>`;

            switch (userActual.perfil) {
                case "encargado": {
                    listaString += `<td><button type="button" class="btn btn-warning" onclick='Principal.Modificar(${JSON.stringify(user)})' data-toggle="modal" data-target="#modificacion">Modificar</button></td>`;
                    break;
                }
                case "propietario": {
                    listaString += `<td><button type="button" class="btn btn-danger" onclick='Principal.Eliminar(${JSON.stringify(user)})' data-toggle="modal" data-target="#eliminar">Eliminar</button></td>`;
                    listaString += `<td><button type="button" class="btn btn-warning" onclick='Principal.Modificar(${JSON.stringify(user)})' data-toggle="modal" data-target="#modificacion">Modificar</button></td>`;
                    break;
                }
                default:
                break;
            }
            listaString += `</tr>`;
        }

        listaString += `</tbody></table></div>`;

        $('#tabla').html(listaString);

        Principal.CambiarAspecto();

        if (userActual.perfil === "empleado") {
            $('#controles').prop('hidden', false);
        }
    }

    public static CargarUsuarios(): void{
        $.ajax({
            type: "GET",
            url: "./BACKEND/",
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            async: true
          })
        .done(response => {
            if (response.exito) {
                localStorage.setItem("usuarios", JSON.stringify(response.usuarios));
                Principal.ArmarTabla();
            }
        })
        .fail((jqXHR, textStatus, errorThrown) => {
            Principal.ManejoAlert(JSON.parse(jqXHR.responseText).msg, "alert-warning");
        });
    }

    public static Eliminar(usuario: any) {

        $("#confirmarTexto").html("Desea eliminar el usuario con correo " + usuario.correo + "?");

        $("#modal-btn-si").off('click').on("click", () =>{
            $.ajax({
                method: "DELETE",
                url: "./BACKEND/usuarios/",
                data: { "id": usuario.id },
                headers: { "token": <string>localStorage.getItem("token") },
                async: true
            })
            .done(response => {
                if (response.exito) {
                    Principal.CargarUsuarios();
                    Principal.ManejoAlert(response.msg, "alert-success");
                } else {
                    Principal.ManejoAlert(response.msg, "alert-danger");
                }
            })
            .fail((jqXHR, textStatus, errorThrown) => {
                Principal.ManejoAlert(JSON.parse(jqXHR.responseText).msg, "alert-warning");
                location.assign("./login.html");
            });
        });
    }

    public static Modificar(obj: any) {
        $("#nombre").val(obj.nombre);
        $("#apellido").val(obj.apellido);
        $("#mail").val(obj.correo);
        $("#password").val(obj.clave);
        $("#confirm").val(obj.clave);
        $("#perfil").val(obj.perfil);
        $("#id").val(obj.id);

        $("#registroForm").off('submit').submit(function (event) {
            event.preventDefault();

            Principal.verificarModificacion();
        });
    }

    public static verificarModificacion(): void{
        let nombre: string = <string>$("#nombre").val();
        let apellido: string = <string>$("#apellido").val();
        let correo: string = <string>$("#mail").val();
        let clave: string = <string>$("#password").val();
        let perfil: string = <string>$("#perfil").val();
        let id: string = <string>$("#id").val();
        let foto: any = $("#foto")[0];

        let usuario = {
            id: id,
            nombre: nombre,
            apellido: apellido,
            correo: correo,
            perfil: perfil,
            clave: clave
        }

        let formData: FormData = new FormData();
        formData.append("datos", JSON.stringify(usuario));
        formData.append("foto", foto.files[0]);

        $("#btnEnviar").off('click').on("click", () =>{
            $.ajax({
                method: "POST",
                url: "./BACKEND/usuarios/modificar",
                data: formData,
                contentType: false,
                processData: false,
                headers: { "token": <string>localStorage.getItem("token") }
            })
            .done(response => {
                if (response.exito == true) {
                    Principal.CargarUsuarios();
                    $("#modificacion").modal("hide");
                    Principal.ManejoAlert(response.msg, "alert-success");
                } else {
                    Principal.ManejoAlert(response.msg, "alert-danger");
                }
            })
            .fail((jqXHR, textStatus, errorThrown) => {
                alert(jqXHR.responseText + textStatus + errorThrown)
                Principal.ManejoAlert(JSON.parse(jqXHR.responseText).msg, "alert-warning");
            });
        });
    }

    public static GuardarCambios() {
        Principal.Verificar();
        let userActual: any = JSON.parse(<string>localStorage.getItem('usuarioActual'));
        let colorFondo = $('#colorFondo').val();
        let colorFuente = $('#colorFuente').val();
        let estiloFoto = $('#marcoImagen').val();

        let opciones: any = {
            "fondo": colorFondo,
            "fuente": colorFuente,
            "estilo": estiloFoto
        };

        localStorage.setItem("op_" + userActual.id, JSON.stringify(opciones));
        Principal.ArmarTabla();
    }

    private static CambiarAspecto() {
        let userActual: any = JSON.parse(<string>localStorage.getItem('usuarioActual'));

        if (localStorage.getItem('op_' + userActual.id) != null) {
            let opciones = JSON.parse(<string>localStorage.getItem('op_' + userActual.id));
            $('#tablaUsers').css({ 'background-color': opciones.fondo, 'color': opciones.fuente });

            $('#colorFondo').val(opciones.fondo);
            $('#colorFuente').val(opciones.fuente);
            $('#marcoImagen').val(opciones.estilo);

            $("#tablaUsers tbody tr").each(function () {
                $(this).children("td").each(function () {
                    if (opciones.estilo != "") {
                        $(this).children('img').addClass('img-' + opciones.estilo);
                    }
                });
            });
        }
    }
}

$(document).ready(() => {
    Principal.CargarUsuarios();
    if (!localStorage.getItem("token")) {
        location.assign("login.html");
    } else {
        Principal.Verificar();
    }

    $('#btnGuardarCambios').off('click').click(function (event) {
        Principal.GuardarCambios();
    });
});
