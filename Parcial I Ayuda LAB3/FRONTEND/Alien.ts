/// <reference path="./Ente.ts" />

namespace Entidades{
    export class Alien extends Entidades.Ente{
        public raza: string;
        public planetaOrigen: string;
        public pathFoto: string;

        public constructor(cuadrante:string, edad:number, altura:number, raza:string, planetaOrigen:string, pathFoto:string) {
            super(cuadrante, edad, altura);
            this.raza = raza;
            this.planetaOrigen = planetaOrigen;
            this.pathFoto = pathFoto;
        }

        public ToJSON(): string{
            return `{${super.ToString()}"raza":"${this.raza}","planetaOrigen":"${this.planetaOrigen}","pathFoto":"${this.pathFoto}"}`;
        }
    }
}