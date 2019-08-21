<?php

function Invertir($palabra)
{
    for($i = strlen($palabra); $i >= 0 ; $i--)
    {
        echo $palabra[$i];
    }
}

?>