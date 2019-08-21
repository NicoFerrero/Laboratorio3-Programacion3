"use strict";
/// <reference path="../node_modules/@types/jquery/index.d.ts" />
$(document).ready(() => {
    Login.CargarUsuarios();
    $("#btnEnviarLogin").click(e => {
        e.preventDefault();
        Login.Login();
    });
    $("#btnEnviar").click(e => {
        e.preventDefault();
        Login.Registrar();
    });
    localStorage.removeItem("usuarioActual");
    localStorage.removeItem("token");
});
class Login {
    static Login() {
        let correo = $("#mailLogin").val();
        let clave = $("#passwordLogin").val();
        let datos = {
            correo: correo,
            clave: clave
        };
        let formData = new FormData();
        formData.append("datos", JSON.stringify(datos));
        $.ajax({
            type: "POST",
            url: "./BACKEND/login/",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            async: true
        })
            .done(response => {
            if (response.exito) {
                localStorage.setItem("token", response.jwt);
                $("#loginForm").trigger("reset");
                for (let user of JSON.parse(localStorage.getItem("usuarios"))) {
                    if (user.correo === correo) {
                        localStorage.setItem('usuarioActual', JSON.stringify(user));
                        break;
                    }
                }
                location.assign("principal.html");
            }
        })
            .fail((jqXHR) => {
            Login.ManejoAlert(JSON.parse(jqXHR.responseText).msg, "alert-warning");
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
    static CargarUsuarios() {
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
                localStorage.removeItem('usuarios');
                localStorage.setItem("usuarios", JSON.stringify(response.usuarios));
            }
        })
            .fail((jqXHR, textStatus, errorThrown) => {
            Login.ManejoAlert(JSON.parse(jqXHR.responseText).msg, "alert-warning");
            localStorage.removeItem('usuarios');
        });
    }
    static Registrar() {
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
                Login.ManejoAlert(response.msg, "alert-success");
                $("#registroForm").trigger("reset");
                location.assign("./login.html");
            }
            else {
                Login.ManejoAlert(response.msg, "alert-danger");
            }
        })
            .fail((jqXHR) => {
            Login.ManejoAlert(JSON.parse(jqXHR.responseText).msg, "alert-warning");
        });
    }
}
//# sourceMappingURL=login.js.map