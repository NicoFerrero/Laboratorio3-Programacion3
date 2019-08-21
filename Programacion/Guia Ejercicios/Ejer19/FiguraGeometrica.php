<?php

abstract class FiguraGeometrica
{
    protected $_color;
    protected $_perimetro;
    protected $_superficie;

    function __construct()
    {
    }

    protected abstract function CalcularDatos();

    public abstract function Dibujar();

    function getColor()
    {
        return $this->_color;
    }

    public function setColor($color)
    {
        $this->_color = $color;
    }

    public function toString()
    {
        return "Color: " . $this->getColor() . " - Perimetro: " . $this->_perimetro . " - Superficie: " . $this->_superficie . " - ";
    }
}
?>