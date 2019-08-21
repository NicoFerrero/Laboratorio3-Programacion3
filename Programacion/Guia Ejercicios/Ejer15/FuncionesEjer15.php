<?php

function Operar()
{
    for($i = 1; $i < 5; $i++)
    {
        echo "Potencias de $i: ";

        for($j = 0; $j < 4; $j++)
        {
            echo pow($i, $j) . ", ";
        }

        echo "</br>";
    }
}

?>