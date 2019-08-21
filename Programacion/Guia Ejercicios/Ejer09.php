<?php

$numeros = array();
$promedio = 0;

for($i = 0; $i < 5; $i++)
{
    $numeros[$i] = rand(0,10);
    $promedio += $numeros[$i] ;
}

if(($promedio / 5) < 6)
{
    echo "El promedio de numeros es menor a 6";
}
else if (($promedio / 5) == 6)
{
    echo "El promedio de numeros es igual a 6";

}
else
{
    echo "El promedio de numeros es mayor a 6";
}

?>