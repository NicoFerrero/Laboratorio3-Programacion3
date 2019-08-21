/// <reference path="../node_modules/@types/jquery/index.d.ts" />

$(document).ready(() => {
    $("#btnEnviar").click(e => {
        e.preventDefault();
        Registro.Crear();
    });
});

class Registro{
    public static Crear(): void{
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
                Registro.ManejoAlert(response.msg, "alert-success");
                $("#registroForm").trigger("reset");
                location.assign("./login.html");
            } else {
                Registro.ManejoAlert(response.msg, "alert-danger");
            }
        })
        .fail((jqXHR) => {
            Registro.ManejoAlert(JSON.parse(jqXHR.responseText).msg, "alert-warning");
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
}