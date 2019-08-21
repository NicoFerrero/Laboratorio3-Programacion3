<?php

$numeros = 1;
$sumatoria = 0;
echo "Los numeros son: ";
do{
    echo $numeros . ", ";
    $sumatoria += $numeros;
    $numeros++;
}while($sumatoria <= 1000);

?>