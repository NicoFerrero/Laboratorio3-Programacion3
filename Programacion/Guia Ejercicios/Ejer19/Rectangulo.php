<?php

require_once "FiguraGeometrica.php";

class Rectangulo extends FiguraGeometrica
{
    private $_ladoUno;
    private $_ladoDos;

    function __construct($lado1, $lado2)
    {
        parent :: __construct();
        $this->_ladoUno = $lado1;
        $this->_ladoDos = $lado2;
        $this->CalcularDatos();
    }

    protected function CalcularDatos()
    {
        $this->_superficie = $this->_ladoUno * $this->_ladoDos;
        $this->_perimetro = 2 * ($this->_ladoUno + $this->_ladoDos);
    }

    public function Dibujar()
    {
        echo "<p style='color:FF0000'>";
        for($i = 1; $i <= $this->_ladoUno; $i++)
        {
            for($j = 1; $j <= $this->_ladoDos; $j++)
            {
                echo "*";
            }

            echo "</br>";
        }
        echo "</p>";

        //return $this->getColor();
    }

    public function toString()
    {
        return parent :: toString() . "Lado uno: " . $this->_ladoUno . " - Lado dos: " . $this->_ladoDos;
    }
}

?>