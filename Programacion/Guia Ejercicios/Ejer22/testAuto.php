<?php

require_once "Auto.php";

$auto1 = new Auto("Ford", 0, "Rojo");
$auto2 = new Auto("Ford", 0, "Verde");
$auto3 = new Auto("Fiat", 500, "Azul");
$auto4 = new Auto("Fiat", 1000, "Azul");
$auto5 = new Auto("Volvo", 1500, "Naranja", date("d-m-Y"));

Auto :: MostrarAuto($auto1);
echo "</br></br>";
Auto :: MostrarAuto($auto2);
echo "</br></br>";
Auto :: MostrarAuto($auto3);
echo "</br></br>";
Auto :: MostrarAuto($auto4);
echo "</br></br>";
Auto :: MostrarAuto($auto5);
echo "</br></br>";

$auto3->AgregarImpuesto(1500);
$auto4->AgregarImpuesto(1500);
$auto5->AgregarImpuesto(1500);

//Se aplico impuesto
Auto :: MostrarAuto($auto3);
echo "</br></br>";
Auto :: MostrarAuto($auto4);
echo "</br></br>";
Auto :: MostrarAuto($auto5);
echo "</br></br>";

//sumo el primer auto y el segundo
$sumaAutos1 = Auto :: Add($auto1, $auto2);
echo $sumaAutos1;
echo "</br></br>";
$sumaAutos2 = Auto :: Add($auto3, $auto4);
echo $sumaAutos2;
echo "</br></br>";
$sumaAutos3 = Auto :: Add($auto1, $auto3);
echo $sumaAutos3;

?>