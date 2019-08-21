<?php

date_default_timezone_set('America/Argentina/Buenos_Aires');
require_once "./clases/Juguete.php";

class Manejadora{
    public static function Agregar($tipo, $precio, $paisOrigen, $path){
        $destino = "./juguetes/imagenes/" . $tipo . "." . $paisOrigen . "." . date("Gis") . "." . pathinfo($path, PATHINFO_EXTENSION);
        $rta = new stdClass();
        $rta->exito = false;
        $rta->msg = "No se agrego el televisor a la BD";
        $juguete = new Juguete($tipo, $precio, $paisOrigen, $destino);
        if(!$juguete->Verificar()){
            if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $destino)){
                if($juguete->Agregar()){
                    header("Location: Listado.php");                    
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