<?php

$contra = isset($_POST["contraseña"]) ? $_POST["contraseña"] : null;

$objJson = new stdClass();

$objJson->Exito=false;

if($contra=="1234")
{

    $objJson->Exito=true;

    echo json_encode($objJson);
}
else
{
    echo json_encode($objJson);
}


?>