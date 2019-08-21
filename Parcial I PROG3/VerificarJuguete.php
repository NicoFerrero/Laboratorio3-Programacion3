<?php

require_once "./clases/Juguete.php";

class Manejadora{

    public static function Verificar($tipo, $precio,  $pais){
        $juguete = new Juguete($tipo, $precio, $pais);
        $esta = $juguete->Verificar();
        $mensaje;
        if($esta){
            $mensaje = $juguete->ToString() . "-" . $juguete->CalcularIVA();
        }else{
            $auxArr = $juguete->Traer();
            $boolPais = false;
            $boolTipo = false;

            foreach($auxArr as $jugueteAux) {
                if(strcmp($jugueteAux->getTipo(), $juguete->getTipo()) == 0) {
                    $boolTipo = true;
                }
                if(strcmp($jugueteAux->getPais(), $juguete->getPais()) == 0) {
                    $boolPais = true;
                }
            }

            $mensaje="No se encuentra el Juguete ya que no coinciden ";

            if($boolPais && !$boolTipo) {
                $mensaje.= "Tipo";
            }
            else if (!$boolPais && $boolTipo) {
                $mensaje.= "Pais";
            }
            else if(!$boolPais && !$boolTipo) {
                $mensaje.= "Ambos";
            }
        }

        return $mensaje;
    }
}

$tipo = isset($_GET["tipo"]) ? $_GET["tipo"] : "";
$pais = isset($_GET["paisOrigen"]) ? $_GET["paisOrigen"] : "";
$precio = isset($_GET["precio"]) ? $_GET["precio"] : "";

echo Manejadora::Verificar($tipo, $precio, $pais);

?>