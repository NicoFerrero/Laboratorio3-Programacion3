<?php

$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$dni = $_POST["dni"];
$sexo = $_POST["sexo"];
$legajo = $_POST["legajo"];
$sueldo = $_POST["sueldo"];
$msg = "";

$archivo = fopen("empleados.txt", "a");

$cant = fwrite($archivo, "$nombre-$apellido-$dni-$sexo-$legajo-$sueldo\r\n");

if($cant > 0)
{
    $msg = "Usuario agregado";
}
else
{
    $msg = "Usuario no agregado";
}

fclose($archivo);

echo $msg;
echo "<br><a href='./index.html'>Index</a>";
?>