<?php

require_once "./clases/Usuario.php";

class Manejadora{

    public static function Guardar($email, $clave){
        $usuario = new Usuario($email, $clave);
        return $usuario->GuardarEnArchivo();
    }
}

$email = isset($_POST["email"]) ? $_POST["email"] : "";
$clave = isset($_POST["clave"]) ? $_POST["clave"] : "";

echo json_encode(Manejadora::Guardar($email, $clave));

?>