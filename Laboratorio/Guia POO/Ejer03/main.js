var __extends = (this && this.__extends) || (function () {
    var extendStatics = Object.setPrototypeOf ||
        ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
        function (d, b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
    return function (d, b) {
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
var Empleados;
(function (Empleados) {
    var Persona = /** @class */ (function () {
        function Persona(nombre, apellido, dni, sexo) {
            this._nombre = nombre;
            this._apellido = apellido;
            this._dni = dni;
            this._sexo = sexo;
        }
        Persona.prototype.GetApellido = function () {
            return this._apellido;
        };
        Persona.prototype.GetNombre = function () {
            return this._nombre;
        };
        Persona.prototype.GetDni = function () {
            return this._dni;
        };
        Persona.prototype.GetSexo = function () {
            return this._sexo;
        };
        Persona.prototype.ToString = function () {
            return this.GetNombre() + "-" + this.GetApellido() + "-" + this.GetDni() + "-" + this.GetSexo() + "-";
        };
        return Persona;
    }());
    Empleados.Persona = Persona;
})(Empleados || (Empleados = {}));
/// <reference path="./Persona.ts"/>
var Empleados;
(function (Empleados) {
    var Empleado = /** @class */ (function (_super) {
        __extends(Empleado, _super);
        function Empleado(nombre, apellido, dni, sexo, legajo, sueldo) {
            var _this = _super.call(this, nombre, apellido, dni, sexo) || this;
            _this._legajo = legajo;
            _this._sueldo = sueldo;
            return _this;
        }
        Empleado.prototype.GetLegajo = function () {
            return this._legajo;
        };
        Empleado.prototype.GetSueldo = function () {
            return this._sueldo;
        };
        Empleado.prototype.Hablar = function (idioma) {
            return "El empleado habla " + idioma;
        };
        Empleado.prototype.ToString = function () {
            return _super.prototype.ToString.call(this) + (this.GetLegajo() + "-" + this.GetSueldo());
        };
        return Empleado;
    }(Empleados.Persona));
    Empleados.Empleado = Empleado;
})(Empleados || (Empleados = {}));
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
/// <reference path="./Fabrica.ts" />
var e1 = new Empleados.Empleado("Juan", "Gonzales", 50236984, "M", 1000, 15000);
var e2 = new Empleados.Empleado("Carlos", "Perez", 45321698, "M", 1001, 15600);
console.log(e1.Hablar("Ingles"));
console.log(e1.ToString());
console.log("-----------------------------");
var empleados = new Array();
empleados.push(e1);
empleados.push(e2);
var f1 = new Fabricas.Fabrica(empleados, "Empresa 1");
console.log(f1.ToString());
console.log("Sueldos " + f1.CalcularSueldos());
