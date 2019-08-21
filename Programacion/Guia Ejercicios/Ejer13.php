<?php

$animales = array();
$fechas = array();
$lenguajesProgramacion = array();

array_push($animales, "perro", "gato", "raton", "araña", "moscas");
array_push($fechas, "1986", "1996", "2015", "78", "86");
array_push($lenguajesProgramacion, "php", "mysql", "html5", "typescript", "ajax");

$general = array_merge($animales, $fechas, $lenguajesProgramacion);

foreach($general as $clave => $claves)
{
    echo "$claves</br>";
}

//var_dump($general);

?>