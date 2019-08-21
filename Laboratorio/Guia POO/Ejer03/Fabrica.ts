/// <reference path="./Empleado.ts" />

namespace Fabricas{
    
    export class Fabrica{

        private _empleados : Array<Empleados.Empleado>;
        private _razonSocial : string;
    
        public constructor(empleados: Array<Empleados.Empleado>, razonSocial:string){
            this._empleados = empleados;
            this._razonSocial = razonSocial;
        }
    
        public static AgregarEmpleado(empleado : Empleados.Empleado):boolean{
            return true;
        }
    
        public static EliminarEmpleado(empleado : Empleados.Empleado):boolean{
            return true;
        }
    
        public CalcularSueldos():number{
    
            let sueldos = 0;
    
            this._empleados.forEach(empleado => sueldos += empleado.GetSueldo());
    
            return sueldos;
        }
    
        public ToString():string{
            let cad : string = "";
    
            cad += this._razonSocial + "\n";
    
            this._empleados.forEach(empleado => cad += empleado.ToString() + "\n");
    
            return cad;
        }
    }
}
