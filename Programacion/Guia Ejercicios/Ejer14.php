<?php

$animales = array("perro", "gato", "raton", "araña", "moscas");
$fechas = array("1986", "1996", "2015", "78", "86");
$lenguajesProgramacion = array("php", "mysql", "html5", "typescript", "ajax");
$general = array("mascotas" => $animales, "fechas" => $fechas, "lenguajes" => $lenguajesProgramacion);

foreach($general as $clave => $claves)
{
    echo "$clave:</br>";
    //Por cada general desdoblar en clave valor mientras haya elementos en la lista
    while(list($clave_1, $valor) = each($claves))
    {
        echo "$valor</br>";
    }
    echo "</br>";
}
?>