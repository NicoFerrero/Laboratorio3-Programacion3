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

        listaString += `</thead><tbody>`;

        for (let user of JSON.parse(<string>localStorage.getItem('usuarios'))) {
            listaString += `<tr>
            <td>`+ user.id + `</td>
            <td>`+ user.correo + `</td>
            <td>`+ user.nombre + `</td>
            <td>`+ user.apellido + `</td>
            <td>`+ user.perfil + `</td>
            <td><img src=${user.foto} height="50px" width="50px"></td>`;

            listaString += `</tr>`;
        }

        listaString += `</tbody></table></div>`;

        $('#tabla').html(listaString);

        if (userActual.perfil === "empleado") {
            $("#tablaUsers tbody tr").each(function () {
                $(this).children("td").each(function () {
                    $(this).children('img').addClass('img-rounded');
                });
            });
        }

        if (userActual.perfil === "encargado") {
            $("#tablaUsers tbody tr").each(function () {
                $(this).children("td").each(function () {
                    $(this).children('img').addClass('img-thumbnail');
                });
            });
        }
    }

    public static ArmarTablaAutos():void{
        let userActual: any = JSON.parse(<string>localStorage.getItem('usuarioActual'));

        let listaString: string = ` <div class="table-responsive">
        <table class="table table-condensed" id="tablaAutos">
            <thead>
                <th>ID</th>
                <th>Color</th>
                <th>Marca</th>
                <th>Precio</th>
                <th>Modelo</th>`;

        if (userActual.perfil === "propietario") {
            listaString += `<th>Acciones</th>`;
        }

        listaString += `</thead><tbody>`;

        for (let auto of JSON.parse(<string>localStorage.getItem('autos'))) {
            listaString += `<tr>
            <td>`+ auto.id + `</td>
            <td>`+ auto.color + `</td>
            <td>`+ auto.marca + `</td>
            <td>`+ auto.precio + `</td>
            <td>`+ auto.modelo + `</td>`;

            switch (userActual.perfil) {
                case "propietario": {
                    listaString += `<td><button type="button" class="btn btn-danger" onclick='Principal.EliminarAuto(${JSON.stringify(auto)})' data-toggle="modal" data-target="#eliminarAuto">Eliminar</button></td>`;
                    listaString += `<td><button type="button" class="btn btn-warning" onclick='Principal.Modificar(${JSON.stringify(auto)})' data-toggle="modal" data-target="#modificacionAuto">Modificar</button></td>`;
                    break;
                } 
                case "encargado":{
                    listaString += `<td><button type="button" class="btn btn-warning" onclick='Principal.Modificar(${JSON.stringify(auto)})' data-toggle="modal" data-target="#modificacionAuto">Modificar</button></td>`;
                    break;
                }
                default:
                break;
            }
            listaString += `</tr>`;
        }

        listaString += `</tbody></table></div>`;

        $('#tablaAutos').html(listaString);
    }

    public static CargarAutos():void{
        $.ajax({
            type: "GET",
            url: "./BACKEND/autos/",
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            async: true
          })
        .done(response => {
            if (response.exito) {
                localStorage.setItem("autos", JSON.stringify(response.autos));
                Principal.ArmarTablaAutos();
            }
        })
        .fail((jqXHR, textStatus, errorThrown) => {
            Principal.ManejoAlert(JSON.parse(jqXHR.responseText).msg, "alert-warning");
        });
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

    public static EliminarAuto(auto: any) {

        $("#confirmarTextoAuto").html("Desea eliminar el auto con modelo " + auto.modelo + "?");

        $("#modal-btn-si-Auto").off('click').on("click", () =>{
            $.ajax({
                method: "DELETE",
                url: "./BACKEND/",
                data: { "id": auto.id },
                headers: { "token": <string>localStorage.getItem("token") },
                async: true
            })
            .done(response => {
                if (response.exito) {
                    Principal.CargarAutos();
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
        $("#marca").val(obj.marca);
        $("#color").val(obj.color);
        $("#precio").val(obj.precio);
        $("#modelo").val(obj.modelo);
        $("#id").val(obj.id);

        $("#autoForm").off('submit').submit(function (event) {
            event.preventDefault();

            Principal.verificarModificacion();
        });
    }

    public static verificarModificacion(): void{
        let marca: string = <string>$("#marca").val();
        let color: string = <string>$("#color").val();
        let precio: string = <string>$("#precio").val();
        let modelo: string = <string>$("#modelo").val();
        let id: string = <string>$("#id").val();

        let auto = {
            id: id,
            marca: marca,
            color: color,
            precio: precio,
            modelo: modelo
        }

        let formData: FormData = new FormData();
        formData.append("datos", JSON.stringify(auto));

        $("#btnEnviar").off('click').on("click", () =>{
            $.ajax({
                method: "POST",
                url: "./BACKEND/modificar",
                data: formData,
                contentType: false,
                processData: false,
                headers: { "token": <string>localStorage.getItem("token") }
            })
            .done(response => {
                if (response.exito == true) {
                    Principal.CargarAutos();
                    $("#modificacionAuto").modal("hide");
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
}

$(document).ready(() => {
    Principal.CargarUsuarios();
    Principal.CargarAutos();
    if (!localStorage.getItem("token")) {
        location.assign("login.html");
    } else {
        Principal.Verificar();
    }
});
