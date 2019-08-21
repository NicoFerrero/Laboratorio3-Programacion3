<?php

$impares = array();
$numeros = 0;

do
{
    if($numeros % 2 != 0)
    {
        array_push($impares, $numeros);
    }
    $numeros++;
}while(count($impares) < 10);

foreach($impares as $numero)
{
    echo $numero . ", ";
}

?>