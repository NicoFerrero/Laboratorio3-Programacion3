<?php

require_once "./clases/Juguete.php";

class Manejadora{
    public static function Agregar($tipo, $precio, $paisOrigen){
        $rta = new stdClass();
        $juguete = new Juguete($tipo, $precio, $paisOrigen);
        $rta->exito = false;
        $rta->msg = $juguete->ToString();
        if($juguete->Agregar()){
            $rta->exito = true;
            $rta->msg = "El juguete se agrego a la BD";
            if(!file_exists("./archivos/juguetes_sin_foto.txt")){
                $archivo = fopen("./archivos/juguetes_sin_foto.txt", "w");
            }else {
                $archivo = fopen("./archivos/juguetes_sin_foto.txt", "a");
            }
            $cant = fwrite($archivo, $juguete->ToString() . "-" . date("d/m/Y/G:i") . "\r\n");
            fclose($archivo);
            if($cant > 0){
                $rta->msg .= " y se escribio correctamente en el archivo de texto";
            }
        }

        return $rta;
    }
}

$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";
$precio = isset($_POST["precio"]) ? $_POST["precio"] : "";
$paisOrigen = isset($_POST["paisOrigen"]) ? $_POST["paisOrigen"] : "";

echo json_encode(Manejadora::Agregar($tipo, $precio, $paisOrigen))

?>