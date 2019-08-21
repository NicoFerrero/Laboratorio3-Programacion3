<!--Aplicación Nº 35 (Empresa de turismo)
Una empresa de turismo ofrece cinco destinos: Río de Janeiro, Punta del Este, La Habana,
Miami e Ibiza. Se pide hacer una página que posea un <select> con los cinco destinos y un
botón que le permita al usuario ver el valor del viaje.
Los valores de los viajes son: €900, €550, €1000, €1250 y €1500 respectivamente. -->

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ejercicio29</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
</head>
<body>
    <form action="funciones.php" method="post">
        
        <select id="cbo" name="opcion" value="1">
            <option value="1" name="Rio">Rio De Janeiro</option>
            <option value="2" name="Punta">Punta Del Este</option>
            <option value="3" name="Habana">La Habana</option>
            <option value="4" name="Miami">Miami</option>
            <option value="5" name="Ibiza">Ibiza</option>
        </select>
        <button type="submit">Valor de viaje</button>
        
        
    </form>
    
    
</body>
</html>