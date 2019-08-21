<?php

class Auto
{
    private $_color;
    private $_precio;
    private $_marca;
    private $_fecha;

    public function __construct($marca, $precio = 0, $color = null, $fecha = null)
    {
        $this->_marca = $marca;
        if($precio != 0)
            $this->_precio = $precio;
        if($color != null)
            $this->_color = $color;
        if($fecha != null)
            $this->_fecha = $fecha;
    }

    public function AgregarImpuesto($impuesto)
    {
        $this->_precio += $impuesto;
    }

    public static function MostrarAuto($objAuto)
    {
        echo "Color: " . $objAuto->_color . "</br>Marca: " . $objAuto->_marca . "</br>Precio: " . $objAuto->_precio . "</br>Fecha: " . $objAuto->_fecha . "<br>";
    }

    public function Equals($objAuto)
    {
        $rta = false;

        if(strcasecmp($this->_marca, $objAuto->_marca) == 0)
        {
            $rta = true;
        }

        return $rta;
    }

    public static function Add($objAuto1, $objAuto2)
    {
        $rta = 0;

        if((strcasecmp($objAuto1->_marca, $objAuto2->_marca) && strcasecmp($objAuto1->_color, $objAuto2->_color)) ==  0)
        {
            echo "Los autos son iguales ";
            $rta = $objAuto1->_precio + $objAuto2->_precio;
        }
        else
        {
            echo "Los autos son distintos ";
        }

        return $rta;
    }
}

?>