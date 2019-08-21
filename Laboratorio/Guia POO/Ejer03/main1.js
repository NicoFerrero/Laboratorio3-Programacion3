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
