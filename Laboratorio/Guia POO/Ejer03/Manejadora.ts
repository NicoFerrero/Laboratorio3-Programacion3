/// <reference path="./Empleado.ts" />

namespace Manejadora{
    
    export class Datos{
        public static RecuperarDatos():void{

            let nombre = (<HTMLInputElement>document.getElementById("nombre")).value;
            let apellido = (<HTMLInputElement>document.getElementById("apellido")).value;
            let dni = parseInt((<HTMLInputElement>document.getElementById("dni")).value, 10);
            let sexo = (<HTMLInputElement>document.getElementById("sexo")).value;
            let legajo = parseInt((<HTMLInputElement>document.getElementById("legajo")).value, 10);
            let sueldo = parseInt((<HTMLInputElement>document.getElementById("sueldo")).value, 10);
            let formulario = <HTMLFormElement>document.getElementById("formulario");
    
            let empleado : Empleados.Empleado = new Empleados.Empleado(nombre, apellido, dni, sexo, legajo, sueldo);
    
            console.log(empleado.ToString());
            formulario.submit();
            formulario.reset();
        }
    }
}
