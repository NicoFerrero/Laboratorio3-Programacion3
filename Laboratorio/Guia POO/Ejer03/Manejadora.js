"use strict";
/// <reference path="./Empleado.ts" />
var Manejadora;
(function (Manejadora) {
    var Datos = /** @class */ (function () {
        function Datos() {
        }
        Datos.RecuperarDatos = function () {
            var nombre = document.getElementById("nombre").value;
            var apellido = document.getElementById("apellido").value;
            var dni = parseInt(document.getElementById("dni").value, 10);
            var sexo = document.getElementById("sexo").value;
            var legajo = parseInt(document.getElementById("legajo").value, 10);
            var sueldo = parseInt(document.getElementById("sueldo").value, 10);
            var formulario = document.getElementById("formulario");
            var empleado = new Empleados.Empleado(nombre, apellido, dni, sexo, legajo, sueldo);
            console.log(empleado.ToString());
            formulario.submit();
            formulario.reset();
        };
        return Datos;
    }());
    Manejadora.Datos = Datos;
})(Manejadora || (Manejadora = {}));
//# sourceMappingURL=Manejadora.js.map