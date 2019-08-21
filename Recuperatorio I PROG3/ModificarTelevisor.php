<?php

date_default_timezone_set('America/Argentina/Buenos_Aires');
require_once "./clases/Televisor.php";

class Manejadora{
    public static function Modificar($tipo, $precio, $paisOrigen, $path, $tipoA, $precioA, $paisOrigenA, $pathA){
        $obj = new stdClass();
        $destino = "";
        $televisor = new Televisor($tipoA, $precioA, $paisOrigenA, "./televisores/imagenes/" . $pathA);
        if($path != ""){
            $destino = "./televisores/imagenes/" . $tipo . "." . $paisOrigen . "." . date("Gis") . "." . "jpg";
        }
        if($televisor->Modificar($tipo, $precio, $paisOrigen, $destino)){
            $destinoModificado = "./televisores_Modificados/" . $televisor->tipo . "." .  $televisor->paisOrigen . "." . "modificado." . date("Gis") . "." . "jpg";
            copy($televisor->path, $destinoModificado);
            unlink($televisor->path);
            if($path != ""){
                if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $destino)){
                    header("Location:./Listado.php");
                } else{
                    $obj->exito = false;
                    $obj->mensaje = "No se pudo modificar el televisor";
                }
            } else{
                header("Location:./Listado.php");
            }
        }else{
            $obj->exito = false;
            $obj->mensaje = "No existe el televisor";
        }
        return $obj;
    }
}

$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";
$precio = isset($_POST["precio"]) ? $_POST["precio"] : "";
$paisOrigen = isset($_POST["paisOrigen"]) ? $_POST["paisOrigen"] : "";
$path = isset($_FILES["archivo"]["name"]) ? $_FILES["archivo"]["name"] : "";

$tipoA = isset($_POST["tipoA"]) ? $_POST["tipoA"] : "";
$precioA = isset($_POST["precioA"]) ? $_POST["precioA"] : "";
$paisOrigenA = isset($_POST["paisOrigenA"]) ? $_POST["paisOrigenA"] : "";
$pathA = isset($_FILES["archivoA"]["name"]) ? $_FILES["archivoA"]["name"] :"" ;

echo json_encode(Manejadora::Modificar($tipo, $precio, $paisOrigen, $path, $tipoA, $precioA, $paisOrigenA, $pathA));


?>