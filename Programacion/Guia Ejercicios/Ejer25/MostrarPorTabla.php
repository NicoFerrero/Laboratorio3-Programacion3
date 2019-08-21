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
	
		<h1>Listado de PALABRAS</h1>

<?php 

    $arrayDeLetrasPorPalabra=Palabras::CalcularLetrasPorPalabra(Palabras::ObtenerPalabras());

echo "<table border='1'>
		<thead>
			<tr>
				<th>  CANT. DE LETRAS </th>
				<th>  CANT. DE PALABRAS</th>
			</tr> 
		</thead>";   	

	foreach ($arrayDeLetrasPorPalabra as $cantidadDeLetras => $cantidadDePalabras ){

		echo " 	<tr>
					<td>".$cantidadDeLetras."</td>
					<td>".$cantidadDePalabras."</td>
				</tr>";
	}	
echo "</table>";		
?>
		
	</div>
    <a href="Index.php">Regresar a la pagina principal</a>
</body>
</html>
