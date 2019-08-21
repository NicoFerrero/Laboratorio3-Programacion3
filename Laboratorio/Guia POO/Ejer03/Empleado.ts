/// <reference path="./Persona.ts"/>

namespace Empleados{
    
    export class Empleado extends Empleados.Persona{

        protected _legajo:number;
        protected _sueldo:number;

        public constructor(nombre:string, apellido:string, dni:number, sexo : string, legajo:number, sueldo:number){
            super(nombre, apellido, dni, sexo);
            this._legajo = legajo;
            this._sueldo = sueldo;
        }

        public GetLegajo():number{
            return this._legajo;
        }

        public GetSueldo():number{
            return this._sueldo;
        }

        public Hablar(idioma:string):string{
            return `El empleado habla ${idioma}`;
        }

        public ToString():string{
            return super.ToString() + `${this.GetLegajo()}-${this.GetSueldo()}`;
        }
    }
}