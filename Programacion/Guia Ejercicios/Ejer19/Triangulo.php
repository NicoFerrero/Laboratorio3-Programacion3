<?php

require_once "FiguraGeometrica.php";

class Triangulo extends FiguraGeometrica
{
    private $_altura;
    private $_base;

    function __construct($base, $altura)
    {
        parent :: __construct();
        $this->_base = $base;
        $this->_altura = $altura;
        $this->CalcularDatos();
    }

    protected function CalcularDatos()
    {
        $this->_superficie = ($this->_base * $this->_altura) / 2;
        $this->_perimetro = sqrt(pow($this->_base, 2) + pow($this->_altura, 2)) + $this->_base + $this->_altura;
    }

    public function Dibujar()
    {
        echo "<p style='color:FF0000'>";
        $totalLineas = $this->_base;
        $nlineas = 0;
        $nAst = 0;
        $nEsp = 0;

        while($nlineas <= $totalLineas)
        {
            while($nEsp < $totalLineas - $nlineas)
            {
                echo "&nbsp;&nbsp;";
                $nEsp++;
            }
            while($nAst < (($nlineas * 2) - 1))
            {
                echo "*";
                $nAst++;
            }
            $nEsp = 0;
            $nAst = 0;
            $nlineas++;
            echo "</br>";
        }
        echo "</p>";

        //return $this->getColor();
    }

    public function toString()
    {
        return parent :: toString() . "Base: " . $this->_base . " - Altura: " . $this->_altura;
    }
}

?>