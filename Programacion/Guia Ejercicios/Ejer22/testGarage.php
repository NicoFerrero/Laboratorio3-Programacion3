<?php

    //require_once "Auto.php";
    require_once "Garage.php";

    $autos = array(new Auto("Ford", 0, "Rojo"), new Auto("Ford", 0, "Verde"));
    //var_dump($autos);

    $garage = new Garage("Nicolas Garage", 1000, $autos);

    $garage->MostrarGarage();
?>