<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ejercicio29</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
</head>
<body>
    <form action="index.php" method="post">
        
        <select id="cbo" name="opcion" >
            <option value="blue" name="Azul">Azul</option>
            <option value="red" name="Rojo">Rojo</option>
            <option value="yellow" name="Yellow">Amarillo</option>
            <option value="black" name="Black">Negro</option>
        </select>
        <button type="submit" name="enviar"  >Cambiar Color</button>
        
        
    </form>
    <?php
       
            echo '<style> body{ background-color:'.$_POST["opcion"].';}</style>';
        
        
    ?>
    
</body>
</html>