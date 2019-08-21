<?php

require_once "./clases/Juguete.php";

class Manejadora{
    public static function Mostrar(){
        return Juguete::MostrarLog(); 
    }
}

echo Manejadora::Mostrar();

?>