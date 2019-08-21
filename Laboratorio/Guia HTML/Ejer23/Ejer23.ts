function ObtenerCoeficiente() : number
{
    return 6.88;
}

function CalcularSalario() : void
{
    let name : string = (<HTMLInputElement> document.getElementById("name")).value;
    let lastName : string = (<HTMLInputElement> document.getElementById("lastName")).value;
    let mail : string = (<HTMLInputElement> document.getElementById("mail")).value;
    let horas : number = parseInt((<HTMLInputElement> document.getElementById("horasTrabajadas")).value, 10);
    let salario: number = horas * ObtenerCoeficiente();

    (<HTMLInputElement> document.getElementById("salario")).value = salario.toString();

    console.log(`El empleado ${name} ${lastName} con mail ${mail} cobra $${salario} por haber trabajado ${horas} horas en el mes`);
}