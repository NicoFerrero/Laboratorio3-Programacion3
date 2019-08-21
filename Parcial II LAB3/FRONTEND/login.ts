/// <reference path="../node_modules/@types/jquery/index.d.ts" />

$(document).ready(() => {
    Login.CargarUsuarios();

    $("#btnEnviarLogin").click(e => {
      e.preventDefault();
      Login.Login();
    });

    $("#btnEnviar").click(e=>{
        e.preventDefault();
        Login.Registrar();
    })

    localStorage.removeItem("usuarioActual");
    localStorage.removeItem("token");
});

class Login{
    public static Login(): void{
        let correo: string = <string>$("#mailLogin").val();
        let clave: string = <string>$("#passwordLogin").val();
        let datos: any = {
            correo: correo,
            clave: clave
        }
        let formData: FormData = new FormData();
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
                for (let user of JSON.parse(<string>localStorage.getItem("usuarios"))){
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
                localStorage.removeItem('usuarios');
                localStorage.setItem("usuarios", JSON.stringify(response.usuarios));
            }
        })
        .fail((jqXHR, textStatus, errorThrown) => {
            Login.ManejoAlert(JSON.parse(jqXHR.responseText).msg, "alert-warning");
            localStorage.removeItem('usuarios');
        });
    }

    public static Registrar():void{

        let nombre: string = <string>$("#nombre").val();
        let apellido: string = <string>$("#apellido").val();
        let correo: string = <string>$("#mail").val();
        let clave: string = <string>$("#password").val();
        let perfil: string = <string>$("#perfil").val();
        let foto: any = $("#foto")[0];

        let usuario: any = {
            nombre: nombre,
            apellido: apellido,
            correo: correo,
            perfil: perfil,
            clave: clave
        };

        let formData: FormData = new FormData();
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
            } else {
                Login.ManejoAlert(response.msg, "alert-danger");
            }
        })
        .fail((jqXHR) => {
            Login.ManejoAlert(JSON.parse(jqXHR.responseText).msg, "alert-warning");
        });
    }
}