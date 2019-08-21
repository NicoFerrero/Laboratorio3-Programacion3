let nombre: string = "Nicolas";
let apellido: string = "Ferrero";

function MostrarNombreApellido(nombre: string, apellido: string): void{
    console.log(`${apellido.toUpperCase()}, ${nombre.charAt(0).toUpperCase()}${nombre.slice(1).toLowerCase()}`);
}

MostrarNombreApellido(nombre, apellido);