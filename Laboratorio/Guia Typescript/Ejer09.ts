import Factorial = require("./Ejer08");
import Cubo = require("./Ejer06");

function ValidarNumero(numero : number) : void
{
    if(numero >= 0)
    {
        Factorial(numero);
    }
    else
    {
        Cubo(numero);
    }
}

ValidarNumero(-2);