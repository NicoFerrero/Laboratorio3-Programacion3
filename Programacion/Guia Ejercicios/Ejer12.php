<?php

$lapicera = array(array("color" => "rojo", "marca" => "bic", "trazo" => 0.5, "precio" => 12.96),
array("color" => "azul", "marca" => "micro", "trazo" => 1, "precio" => 6.35),
array("color" => "verde", "marca" => "faber-castel", "trazo" => 0.7, "precio" => 8.32));

foreach ($lapicera as $clave => $valor)
{
    echo "Lapicera</br>";

    while(list($clave_1, $valor_1) = each($valor))
    {
        echo "$clave_1: $valor_1</br>";
    }

    echo "</br>";
}

?>