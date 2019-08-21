<?php

date_default_timezone_set('America/Argentina/Buenos_Aires');
require_once "./clases/Usuario.php";

class Manejadora{

    public static function Verificar($email, $clave){
        $usuario = new Usuario($email, $clave);
        $esta = Usuario::VerificarExistencia($usuario);
        if($esta){
            $auxJson = json_decode($usuario->ToJson());
            $auxEmail = str_replace(".", "_", $auxJson->email);
            setcookie($auxEmail, date("G:i:s", date()));
            header("Location: ListadoUsuarios.php");
        }else{
            $rta = new stdClass();
            $rta->exito = false;
            $rta->msg = "El usuario no se encuentra en el listado";
        }

        return $rta;
    }
}

$email = isset($_REQUEST["email"]) ? $_REQUEST["email"] : "";
$clave = isset($_REQUEST["clave"]) ? $_REQUEST["clave"] : "";

echo json_encode(Manejadora::Verificar($email, $clave));

?>