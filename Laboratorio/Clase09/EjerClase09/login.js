"use strict";
$(document).ready(function () {
    $("#loginBtn").click(function (e) {
        e.preventDefault();
        Login();
    });
    $("#crearBtn").click(function (e) {
        e.preventDefault();
        Crear();
    });
});
function Login() {
    var legajo = $("#legajoLogin").val();
    var clave = $("#claveLogin").val();
    $.ajax({
        type: "GET",
        url: "./BACKEND/empleados/login" + ("?legajo=" + legajo + "&clave=" + clave),
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        async: true
    })
        .done(function (response) {
        if (response.exito) {
            localStorage.setItem("token", response.token);
            location.assign("index.html");
        }
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });
}
function Crear() {
    var nombre = $("#nombre").val();
    var apellido = $("#apellido").val();
    var legajo = $("#legajo").val();
    var sueldo = $("#sueldo").val();
    var clave = $("#clave").val();
    var foto = $("#foto")[0];
    var empleado = {
        nombre: nombre,
        apellido: apellido,
        legajo: legajo,
        sueldo: sueldo,
        clave: clave
    };
    var formData = new FormData();
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
        .done(function (response) {
        if (response.exito == true) {
            $("#miFormulario").trigger("reset");
            $("#crearModal").modal("hide");
            ManejoAlert(response.msg, "alert-success");
        }
        else {
            ManejoAlert(response.msg, "alert-danger");
        }
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        ManejoAlert(JSON.parse(jqXHR.responseText).msg, "alert-warning");
    });
}
function ManejoAlert(msg, tipoAlert) {
    $("#msgAlert").html(msg);
    $("#alert").addClass(tipoAlert);
    $("#alert").removeClass("d-none");
    setInterval(function () {
        $("#alert").addClass("d-none");
        $("#alert").removeClass(tipoAlert);
    }, 5000);
}
//# sourceMappingURL=login.js.map