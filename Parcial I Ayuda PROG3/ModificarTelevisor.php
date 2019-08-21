<?php

date_default_timezone_set('America/Argentina/Buenos_Aires');
require_once "./clases/Televisor.php";

class Manejadora{
    public static function Modificar($tipo, $precio, $paisOrigen, $path){
        $obj = new stdClass();
        $televisor = new Televisor("LED", 6000, "Brasil", "./televisores/LED.Brasil.143919.jpg");
        $destino = "./televisores/" . $tipo . "." . $paisOrigen . "." . date("Gis") . "." . pathinfo($path, PATHINFO_EXTENSION);
        if($televisor->Modificar($tipo, $precio, $paisOrigen, $destino)){
            $destinoModificado = "./televisores_Modificados/" . $televisor->tipo . "." .  $televisor->paisOrigen . "." . "modificado." . date("Gis") . "." . "jpg";
            copy($televisor->path, $destinoModificado);
            unlink($televisor->path);
            if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $destino)){
                header("Location:./Listado.php");
            } else{
                $obj->mensaje = "No se pudo modificar el televisor";
                $obj->exito = false;
            }
        }
        return $obj;
    }
}

$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";
$precio = isset($_POST["precio"]) ? $_POST["precio"] : "";
$paisOrigen = isset($_POST["paisOrigen"]) ? $_POST["paisOrigen"] : "";
$path = isset($_FILES["archivo"]["name"]) ? $_FILES["archivo"]["name"] : "";

echo json_encode(Manejadora::Modificar($tipo, $precio, $paisOrigen, $path));

?>