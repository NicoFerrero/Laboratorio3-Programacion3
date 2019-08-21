<?php

date_default_timezone_set('America/Argentina/Buenos_Aires');
require_once "./clases/Televisor.php";

class Manejadora{
    public static function Agregar($tipo, $precio, $paisOrigen, $path){
        $destino = "./televisores/" . $tipo . "." . $paisOrigen . "." . date("Gis") . "." . pathinfo($path, PATHINFO_EXTENSION);
        $rta = new stdClass();
        $rta->exito = false;
        $rta->msg = "No se agrego el televisor a la BD";
        $televisor = new Televisor($tipo, $precio, $paisOrigen, $destino);
        if(!$televisor->Existe($televisor)){
            if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $destino)){
                if($televisor->Agregar()){
                    $rta->exito = true;
                    $rta->msg = "El televisor se agrego a la BD";
                }
            }
        }
        return $rta;
    }
}

$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";
$precio = isset($_POST["precio"]) ? $_POST["precio"] : "";
$paisOrigen = isset($_POST["paisOrigen"]) ? $_POST["paisOrigen"] : "";
$path = isset($_FILES["archivo"]["name"]) ? $_FILES["archivo"]["name"] : "";

echo json_encode(Manejadora::Agregar($tipo, $precio, $paisOrigen, $path));

?>