<?php

require_once "./clases/Televisor.php";

class Manejadora{
    public static function Agregar($tipo, $precio, $paisOrigen){
        $rta = new stdClass();
        $rta->exito = false;
        $rta->msg = "No se agrego el televisor a la BD";
        $televisor = new Televisor($tipo, $precio, $paisOrigen);
        if($televisor->Agregar()){
            $rta->exito = true;
            $rta->msg = "El televisor se agrego a la BD";
        }

        return $rta;
    }
}

$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";
$precio = isset($_POST["precio"]) ? $_POST["precio"] : "";
$paisOrigen = isset($_POST["paisOrigen"]) ? $_POST["paisOrigen"] : "";

echo json_encode(Manejadora::Agregar($tipo, $precio, $paisOrigen))

?>