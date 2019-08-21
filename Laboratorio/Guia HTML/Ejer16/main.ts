function Manejadora(): void{
    let nombre = (<HTMLInputElement>document.getElementById("nombre")).value;
    let mail = (<HTMLInputElement>document.getElementById("mail")).value;
    let dni = parseInt((<HTMLInputElement>document.getElementById("dni")).value);
    let cv = (<HTMLInputElement>document.getElementById("cv")).value;
    let form = (<HTMLFormElement>document.getElementById("formulario"));

    console.log(`Nombre: ${nombre} mail: ${mail} dni: ${dni} cv: ${cv}`);
    form.reset();
}