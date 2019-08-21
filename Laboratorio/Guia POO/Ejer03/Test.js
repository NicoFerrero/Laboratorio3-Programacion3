"use strict";
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
//# sourceMappingURL=Test.js.map