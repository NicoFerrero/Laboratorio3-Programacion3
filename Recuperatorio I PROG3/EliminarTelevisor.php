<?php

date_default_timezone_set('America/Argentina/Buenos_Aires');
require_once "./clases/Televisor.php";

class Manejadora{
    public static function EliminarGET($tipo, $precio, $paisOrigen){
        $televisor = new Televisor($tipo, $precio, $paisOrigen);
        $obj = new stdClass();
        $obj->exito = false;
        $obj->msg = "El televisor no existe";
        if($televisor->Existe($televisor)){
            $obj = new stdClass();
            $obj->exito = true;
            $obj->msg = "El televisor existe";
        }
        return $obj;
    }

    public static function EliminarPOST($tipo, $precio, $paisOrigen, $path){
        $destino = "./televisores/imagenes/" . $path;
        $televisor = new Televisor($tipo, $precio, $paisOrigen, $destino);
        $obj = new stdClass();
        $obj->exito = false;
        $obj->msg = "El televisor no se borro";
        if($televisor->Eliminar()){
            $destinoEliminados = "./televisores_Eliminados/" . $televisor->tipo . "." .  $televisor->paisOrigen . "." . "eliminado." . date("Gis") . "." . "jpg";
            copy($televisor->path, $destinoEliminados);
            unlink($televisor->path);
            header("Location:./Listado.php");
        }
        return $obj;
    }
}

$tipoGET = isset($_GET["tipo"]) ? $_GET["tipo"] : "";
$precioGET  = isset($_GET["precio"]) ? $_GET["precio"] : "";
$paisOrigenGET  = isset($_GET["paisOrigen"]) ? $_GET["paisOrigen"] : "";

$tipoPOST = isset($_POST["tipo"]) ? $_POST["tipo"] : "";
$precioPOST  = isset($_POST["precio"]) ? $_POST["precio"] : "";
$paisOrigenPOST  = isset($_POST["paisOrigen"]) ? $_POST["paisOrigen"] : "";
$path = isset($_FILES["archivo"]["name"]) ? $_FILES["archivo"]["name"] : "";

if($tipoGET !== "" && $precioGET !== "" && $paisOrigenGET !== ""){
    echo json_encode(Manejadora::EliminarGET($tipoGET ,$precioGET ,$paisOrigenGET));
} else if($tipoPOST !== "" && $precioPOST !== "" && $paisOrigenPOST !== ""){
    echo json_encode(Manejadora::EliminarPOST($tipoPOST, $precioPOST, $paisOrigenPOST, $path));
}

?>