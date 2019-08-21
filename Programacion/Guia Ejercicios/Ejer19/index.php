<?php

require_once "Triangulo.php";
require_once "Rectangulo.php";

$rectangulo = new Rectangulo(6, 6);

echo $rectangulo->toString();
echo "</br>";
echo $rectangulo->Dibujar();
echo "</br>**********************************</br>";
echo "</br>";


$triangulo = new Triangulo(4, 5);

echo $triangulo->toString();
echo "</br>";
echo $triangulo->Dibujar();
?>