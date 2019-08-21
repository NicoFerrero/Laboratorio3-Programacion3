"use strict";
$(document).ready(function () {
    if (!localStorage.getItem("token")) {
        location.assign("login.php");
    }
    else {
        Verificar();
    }
    MostrarLista();
    $("#agregarBtn").on("click", function (e) {
        e.preventDefault();
        AgregarEmpleado();
    });
    $("#foto").on("change", function (event) {
        var reader = new FileReader();
        reader.onload = function () {
            var output = document.getElementById("imgFoto");
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    });
    $("#cancelar").on("click", function () {
        $("#span").html("Crear");
    });
});
function AgregarEmpleado() {
    var nombre = $("#nombre").val();
    var apellido = $("#apellido").val();
    var legajo = $("#legajo").val();
    var sueldo = $("#sueldo").val();
    var clave = $("#clave").val();
    var foto = $("#foto")[0];
    var token = localStorage.getItem("token") !== null
        ? localStorage.getItem("token")
        : "";
    var empleado = {
        nombre: nombre,
        apellido: apellido,
        legajo: legajo,
        sueldo: sueldo,
        clave: clave
    };
    var url = "./BACKEND/empleados";
    var hacer = true;
    if ($("#span").html() === "Modificar") {
        if (confirm("Esta seguro que quiere modificar a " +
            $("#oldName").val() +
            ", legajo: " +
            legajo +
            "?")) {
            url = "./BACKEND/empleados/modificar";
            empleado.id = $("#idEmpleado").val();
            empleado.token = token;
        }
        else {
            hacer = false;
        }
    }
    var formData = new FormData();
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
            .done(function (response) {
            if (response.exito == true) {
                Alerta(response.msg, "alert-success");
                MostrarLista();
                $("#miFormulario").trigger("reset");
                $("#span").html("Crear");
                document.getElementById("imgFoto").src =
                    "BACKEND/usr_default.jpg";
            }
            else {
                Alerta(response.msg, "alert-danger");
            }
        })
            .fail(function (jqXHR, textStatus, errorThrown) {
            Alerta(JSON.parse(jqXHR.responseText).msg, "alert-warning");
        });
    }
}
function MostrarLista() {
    $.ajax({
        type: "GET",
        url: "./BACKEND/empleados",
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        async: true
    })
        .done(function (response) {
        if (Array.isArray(response)) {
            var empleados = response;
            var tabla_1 = "<table class='table table-light table-striped'><thead><tr><th class='text-center'>ID</th><th class='text-center'>Nombre</th><th class='text-center'>Apellido</th><th class='text-center'>Sueldo</th><th class='text-center'>Foto</th><th class='text-center'>Legajo</th><th class='text-center'>Acciones</th></tr></thead><tbody>";
            empleados.forEach(function (empleado) {
                tabla_1 += "<tr>\n                            <td class='text-center align-middle'>" + empleado.id + "</td>\n                            <td class='text-center align-middle'>" + empleado.nombre + "</td>\n                            <td class='text-center align-middle'>" + empleado.apellido + "</td>\n                            <td class='text-center align-middle'>" + empleado.sueldo + "</td>\n                            <td class='text-center align-middle'><img height=\"42\" width=\"42\" src=" + empleado.foto + "></td>\n                            <td class='text-center align-middle'>" + empleado.legajo + "</td>\n                            <td class='text-center align-middle'>\n                                <div class=\"row\">\n                                    <div class=\"col-12 col-md-6\">\n                                        <button type=\"button\" id=\"eliminar\" onclick='Eliminar(" + JSON.stringify(empleado) + ")' class=\"btn btn-outline-danger btn-block mb-1\"><i class=\"fas fa-trash\"></i></button>\n                                    </div>\n                                    <div class=\"col-12 col-md-6\">\n                                        <button type=\"button\" id=\"modificar\" onclick='Modificar(" + JSON.stringify(empleado) + ")' class=\"btn btn-outline-warning btn-block\"><i class=\"fas fa-edit\"></i></button>\n                                    </div>\n                                </div>\n                            </td>\n                        </tr>";
            });
            tabla_1 += "</tbody></tabla>";
            $("#tabla").html(tabla_1);
        }
        else {
            alert(response.msg);
            $("#tabla").html("");
        }
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });
}
function Eliminar(obj) {
    if (confirm("Esta seguro que quiere eliminar a " + obj.nombre + ", legajo: " + obj.legajo + "?")) {
        var token = localStorage.getItem("token") !== null ? localStorage.getItem("token") : "";
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
            .done(function (response) {
            if (response.exito == true) {
                Alerta(response.msg, "alert-success");
                MostrarLista();
            }
            else {
                Alerta(response.msg, "alert-danger");
                if (response.tipo === "token") {
                    location.assign("login.php");
                }
            }
        })
            .fail(function (jqXHR, textStatus, errorThrown) {
            Alerta(JSON.parse(jqXHR.responseText).msg, "alert-warning");
        });
    }
}
function Modificar(obj) {
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
    var token = localStorage.getItem("token");
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
        .done(function (response) {
        if (!response.exito) {
            location.assign("login.php");
        }
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });
}
function Alerta(msg, tipoAlert) {
    $("#msgAlert").html(msg);
    $("#alert").addClass(tipoAlert);
    $("#alert").removeClass("d-none");
    setInterval(function () {
        $("#alert").addClass("d-none");
        $("#alert").removeClass(tipoAlert);
    }, 5000);
}
//# sourceMappingURL=ejemplo.js.map