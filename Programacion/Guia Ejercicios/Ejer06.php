<?php

$operador = "/";
$num1 = 5;
$num2 = 0;

switch($operador)
{
    case "+":
    echo "Resultado: " . ($num1 + $num2);
    break;

    case "-":
    echo "Resultado: " . ($num1 - $num2);
    break;

    case "*":
    echo "Resultado: " . ($num1 * $num2);
    break;

    case "/":
    if($num2 > 0)
    {
        echo "Resultado: " . ($num1 / $num2);
    }
    else
    {
        echo "No se puede dividir por 0";
    }
    break;

    default:
    echo "La opcion no es correcta";
    break;
}

?>