function Operar() : void
{
    let num1 : number = parseInt((<HTMLInputElement> document.getElementById("num1")).value, 10);
    let num2 : number = parseInt((<HTMLInputElement> document.getElementById("num2")).value, 10);
    let resultado : number = 0;

    let rdoOpElement = document.getElementsByName("rdoOp");
    let operador;

    for (let i = 0; i < rdoOpElement.length; i++)
    {
        if ((<HTMLInputElement> rdoOpElement[i]).checked)
        {
            operador = (<HTMLInputElement> rdoOpElement[i]).value;
            break;
        }
    }


    switch(operador)
    {
        case "+":
            resultado = num1 + num2;
            break;

        case "-":
            resultado = num1 - num2;
            break;

        case "*":
            resultado = num1 * num2;
            break;

        case "/":
            if(num2 != 0)
            {
                resultado = num1 / num2;
            }
            break;
    }

    (<HTMLInputElement> document.getElementById("res")).value = (resultado).toString();
}