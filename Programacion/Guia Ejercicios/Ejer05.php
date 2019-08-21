<?php

$numeroUno = 1;
$numeroDos = 18;
$numeroTres = 18;
$valorMedio = 0;

if(($numeroDos > $numeroUno && $numeroDos < $numeroTres) || ($numeroDos < $numeroUno && $numeroDos > $numeroTres))
{
	$valorMedio = $numeroDos;
}
else if(($numeroTres > $numeroUno && $numeroTres < $numeroDos) || ($numeroTres < $numeroUno && $numeroTres > $numeroDos))
{
	$valorMedio = $numeroTres;
}
else if(($numeroUno > $numeroDos && $numeroUno < $numeroTres) || ($numeroUno < $numeroDos && $numeroUno > $numeroTres))
{
	$valorMedio = $numeroUno;
}

if($valorMedio != 0)
{
	echo "$valorMedio";
}
else
{
	echo "No hay valor medio";
}

?>