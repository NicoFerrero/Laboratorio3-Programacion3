<?php

require_once "./clases/Usuario.php";

class Manejadora {
    public static function Listado() {
        $auxReturn = "";
        $auxArray = Usuario::TraerTodos();

        foreach ($auxArray as $usuario) {
            $auxReturn.= $usuario->ToJson() . "<br>";
        }

        return $auxReturn;
    }
}

echo Manejadora::Listado();

?>