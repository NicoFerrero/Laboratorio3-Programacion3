/// <reference path="./Fabrica.ts" />

let e1 : Empleados.Empleado = new Empleados.Empleado("Juan", "Gonzales", 50236984, "M", 1000, 15000);
let e2 : Empleados.Empleado = new Empleados.Empleado("Carlos", "Perez", 45321698, "M", 1001, 15600);

console.log(e1.Hablar("Ingles"));
console.log(e1.ToString());

console.log("-----------------------------");

let empleados : Array<Empleados.Empleado> = new Array<Empleados.Empleado>();
empleados.push(e1);
empleados.push(e2);
let f1 : Fabricas.Fabrica = new Fabricas.Fabrica(empleados, "Empresa 1");
console.log(f1.ToString());
console.log(`Sueldos ${f1.CalcularSueldos()}`); 