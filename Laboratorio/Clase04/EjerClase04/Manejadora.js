"use strict";
var AJAX;
(function (AJAX) {
    function Saludar() {
        var xmlhttp = new XMLHttpRequest();
        var respuesta;
        xmlhttp.open("GET", "administrar.php", true);
        xmlhttp.send();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                respuesta = xmlhttp.responseText;
                document.getElementById("div_mostrar").innerHTML = respuesta;
                console.log(respuesta);
                alert(respuesta);
            }
        };
    }
    AJAX.Saludar = Saludar;
    function Ingresar() {
        var xmlhttp = new XMLHttpRequest();
        var nombre = document.getElementById("nombre").value;
        var respuesta;
        xmlhttp.open("GET", "administrar.php?accion=2&nombre=" + nombre, true);
        xmlhttp.send();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                respuesta = xmlhttp.responseText;
                if (respuesta == "1") {
                    MostrarTabla();
                    console.log("Nombre Agregado");
                    alert("Nombre Agregado");
                }
                else {
                    console.log("No se pudo guardar el nombre");
                    alert("No se pudo guardar el nombre");
                }
            }
        };
    }
    function MostrarTabla() {
        var xmlhttp = new XMLHttpRequest();
        var respuesta;
        xmlhttp.open("GET", "administrar.php?accion=3", true);
        xmlhttp.send();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                respuesta = xmlhttp.responseText;
                document.getElementById("div_mostrar").innerHTML = respuesta;
            }
        };
    }
    function Verificar() {
        var xmlhttp = new XMLHttpRequest();
        var nombre = document.getElementById("nombre").value;
        var respuesta;
        xmlhttp.open("GET", "administrar.php?accion=4&nombre=" + nombre, true);
        xmlhttp.send();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                respuesta = xmlhttp.responseText;
                if (respuesta == "0") {
                    Ingresar();
                }
                else {
                    console.log("No se puede agregar el nombre ya existe");
                    alert("No se puede agregar el nombre ya existe");
                }
            }
        };
    }
    AJAX.Verificar = Verificar;
})(AJAX || (AJAX = {}));
//# sourceMappingURL=Manejadora.js.map