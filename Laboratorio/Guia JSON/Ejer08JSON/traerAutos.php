<?php

$linea = "";
$auto;

$file = fopen("./autos.json", "r");
while(!feof($file))
{
    $linea .= fgets($file);
}

fclose($file);

if(count($linea) > 0)
    $auto = ($linea);
else
    $auto = "{}";
    
echo $auto;

?>