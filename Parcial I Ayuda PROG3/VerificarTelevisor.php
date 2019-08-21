<?php

require_once "./clases/Televisor.php";

class Manejadora{
    public static function Verificar(){
        $auxReturn = new stdClass();
        $auxReturn->Exito = false;
        $auxReturn->Mensaje = "No se ha verificado porque se ha ingreso un json incorrecto";

        $obj = isset($_POST["televisor"]) ? json_decode($_POST["televisor"]) : null;

        if($obj != null) {
            $auxTelevisor = new Televisor($obj->tipo,$obj->precio,$obj->pais,$obj->foto);

            if($auxTelevisor->Existe($auxTelevisor)) {

                $auxReturn->Mensaje = $auxTelevisor->ToJson();
                $auxReturn->Exito = true;
            }
            else {
                $auxArr = $auxTelevisor->Traer();
                $boolPais = false;
                $boolTipo = false;

                foreach($auxArr as $TelevisorA) {
                    if(strcmp($TelevisorA->tipo, $auxTelevisor->tipo) == 0) {
                        $boolTipo = true;
                    }
                    if(strcmp($TelevisorA->paisOrigen, $auxTelevisor->paisOrigen) == 0) {
                        $boolPais = true;
                    }
                }

                $auxReturn->Mensaje="No se encuentra el Ovni ya que no coinciden ";

                if($boolPais && !$boolTipo) {
                    $auxReturn->Mensaje.= "Tipo";
                }
                else if (!$boolPais && $boolTipo) {
                    $auxReturn->Mensaje.= "Pais";
                }
                else if(!$boolPais && !$boolTipo) {
                    $auxReturn->Mensaje.= "Ambos";
                }
            }
        }

        return $auxReturn;
    }
}

echo json_encode(Manejadora::Verificar())."<br>";

?>