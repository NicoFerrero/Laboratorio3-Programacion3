<?php
	require_once('Palabras.php');
?>
<html>
<head>
	<title>Tabla de palabras</title>

	<meta charset="UTF-8">
	
</head>
<body>
	
    <div>
	<span>Lista de palabras:<span>
<?php
//Obtengo palabra,calculo y muestro
	Palabras::MostrarPalabras(Palabras::ObtenerPalabras());
?>
    <a href="MostrarPorTabla.php">MostrarPorTabla</a>
    </div>
</body>
</html>
		