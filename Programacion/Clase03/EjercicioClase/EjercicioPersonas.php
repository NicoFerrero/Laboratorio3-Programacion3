<?php

require_once "Persona.php";


/*$p1=new Persona();

$p1->nombre="Nicolas";
$p1->apellido="Lo Vento";

$p1->Guardar();
$p1->Leer();*/

/*echo "GET: ";
echo var_dump($_GET)."<br>";
echo "POST: ";
echo var_dump($_POST)."<br>";
echo "REQUEST: ";
echo var_dump($_REQUEST)."<br>";*/

$p1=new Persona();

$p1->nombre=$_POST["nombre"];
$p1->apellido=$_POST["apellido"];

$p1->Guardar();
//echo $p1->ToString();
//var_dump($_REQUEST);


//die();

$arraydePersonas=Persona::TraerTodasLasPersonas();
foreach($arraydePersonas as $persona){

    echo $persona->ToString()."<br>";

}

echo '<a href="ingreso.php">Volver a ingreso..</a>';



?>