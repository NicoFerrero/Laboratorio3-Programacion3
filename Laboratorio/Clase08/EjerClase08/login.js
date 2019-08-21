"use strict";
function Validar1() {
    var legajo = $("#legajo").val();
    var clave = $("#clave").val();
    $.ajax({
        type: 'GET',
        url: './BACKEND/login' + ("?legajo=" + legajo + "&clave=" + clave),
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        async: true
    }).done(function (response) {
        alert(response.exito + "\n" + JSON.stringify(response.objEmpleado));
        if (response.exito) {
            location.assign("index.html");
        }
    }).fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });
}
//# sourceMappingURL=login.js.map