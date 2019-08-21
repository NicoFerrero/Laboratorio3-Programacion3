<?php

require_once "Auto.php";

class Garage
{
    private $_razonSocial;
    private $_precioPorHora;
    private $_autos;

    function __construct($razonSocial, $precioPorHora = 0, $autos)
    {
        $this->_razonSocial = $razonSocial;
        if($precioPorHora != 0)
        {
            $this->_precioPorHora = $precioPorHora;
        }
        $this->_autos = $autos;
    }

    public function MostrarGarage()
    {
        $cad = "Razon Social: " . $this->_razonSocial . "<br>Precio Por Hora: " . $this->_precioPorHora . "<br>Autos:<br>";
        echo $cad;
        for($i = 0; $i < count($this->_autos); $i++)
        {
            $cad .= Auto :: MostrarAuto($this->_autos[$i]) . "<br>";
        }
    }
}

?>