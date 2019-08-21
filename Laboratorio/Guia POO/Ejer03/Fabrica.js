"use strict";
/// <reference path="./Empleado.ts" />
var Fabricas;
(function (Fabricas) {
    var Fabrica = /** @class */ (function () {
        function Fabrica(empleados, razonSocial) {
            this._empleados = empleados;
            this._razonSocial = razonSocial;
        }
        Fabrica.AgregarEmpleado = function (empleado) {
            return true;
        };
        Fabrica.EliminarEmpleado = function (empleado) {
            return true;
        };
        Fabrica.prototype.CalcularSueldos = function () {
            var sueldos = 0;
            this._empleados.forEach(function (empleado) { return sueldos += empleado.GetSueldo(); });
            return sueldos;
        };
        Fabrica.prototype.ToString = function () {
            var cad = "";
            cad += this._razonSocial + "\n";
            this._empleados.forEach(function (empleado) { return cad += empleado.ToString() + "\n"; });
            return cad;
        };
        return Fabrica;
    }());
    Fabricas.Fabrica = Fabrica;
})(Fabricas || (Fabricas = {}));
//# sourceMappingURL=Fabrica.js.map