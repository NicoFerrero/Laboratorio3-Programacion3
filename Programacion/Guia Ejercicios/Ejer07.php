<?php

date_default_timezone_set("America/Argentina/Buenos_Aires"); //Establece el uso horario para todas las funciones date del archvio
$fecha = date("d-m-Y H:i:s", time());
$month = date("n", time());
$day = date("j", time());

switch($month)
{
    case "1":
    case "2":
        echo "Estas en Verano";
    break;

    case "3":
        if($day < 21)
        {
            echo "Estas en Verano";
        }
        else
        {
            echo "Estas en Otoño";
        }
    break;

    case "4":
    case "5":
        echo "Estas en Otoño";
    break;

    case "6":
        if($day < 21)
        {
            echo "Estas en Otoño";
        }
        else
        {
            echo "Estas en Invierno";
        }
    break;

    case "7":
    case "8":
        echo "Estas en Invierno";
    break;

    case "9":
        if($day < 21)
        {
            echo "Estas en Invierno";
        }
        else
        {
            echo "Estas en Pirmavera";
        }
    break;

    case "10":
    case "11":
        echo "Estas en Pirmavera";
    break;

    case "12":
        if($day < 21)
        {
            echo "Estas en Pirmavera";
        }
        else
        {
            echo "Estas en Verano";
        }
    break;
}

echo "</br>" . $fecha;

?>