"use strict";
/// <reference path="../node_modules/@types/jquery/index.d.ts" />
$(document).ready(() => {
    $("#btnEnviar").click(e => {
        e.preventDefault();
        Registro.Crear();
    });
});
class Registro {
    static Crear() {
        let nombre = $("#nombre").val();
        let apellido = $("#apellido").val();
        let correo = $("#mail").val();
        let clave = $("#password").val();
        let perfil = $("#perfil").val();
        let foto = $("#foto")[0];
        let usuario = {
            nombre: nombre,
            apellido: apellido,
            correo: correo,
            perfil: perfil,
            clave: clave
        };
        let formData = new FormData();
        formData.append("datos", JSON.stringify(usuario));
        formData.append("foto", foto.files[0]);
        $.ajax({
            type: "POST",
            url: "./BACKEND/usuarios/",
            dataType: "json",
            cache: false,
            data: formData,
            contentType: false,
            processData: false,
            async: true
        })
            .done(response => {
            if (response.exito == true) {
                Registro.ManejoAlert(response.msg, "alert-success");
                $("#registroForm").trigger("reset");
                location.assign("./login.html");
            }
            else {
                Registro.ManejoAlert(response.msg, "alert-danger");
            }
        })
            .fail((jqXHR) => {
            Registro.ManejoAlert(JSON.parse(jqXHR.responseText).msg, "alert-warning");
        });
    }
    static ManejoAlert(msg, tipoAlert) {
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
}
//# sourceMappingURL=registro.js.map