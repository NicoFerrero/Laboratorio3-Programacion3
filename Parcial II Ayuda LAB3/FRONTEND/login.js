"use strict";
/// <reference path="../node_modules/@types/jquery/index.d.ts" />
$(document).ready(() => {
    Login.CargarUsuarios();
    $("#btnEnviar").click(e => {
        e.preventDefault();
        Login.Login();
    });
    $("#btnRegistrar").click(e => {
        e.preventDefault();
        location.assign("./registro.html");
    });
    localStorage.removeItem("usuarioActual");
    localStorage.removeItem("token");
});
class Login {
    static Login() {
        let correo = $("#mail").val();
        let clave = $("#password").val();
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
}
//# sourceMappingURL=login.js.map