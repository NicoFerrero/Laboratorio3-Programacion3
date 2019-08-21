<?php

class Manejadora{
    public static function Cookie(){
        $rta = new stdClass();
        $rta->exito = false;
        $rta->msg = "No existe la cookie";
        $email = isset($_GET["email"]) ? $_GET["email"] : "";
        if(isset($_COOKIE[$email])){
            $rta->exito = true;
            $rta->msg = $_COOKIE[$email];
        }

        return $rta;
    }
}

echo json_encode(Manejadora::Cookie());

?>