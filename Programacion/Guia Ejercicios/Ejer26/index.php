<!--Aplicación Nº 26 (Copiar archivos)
Generar una aplicación que sea capaz de copiar un archivo de texto (su ubicación se ingresará
por la página) hacia otro archivo que será creado y alojado en
./misArchivos/yyyy_mm_dd_hh_ii_ss.txt, dónde yyyy corresponde al año en curso, mm
al mes, dd al día, hh hora, ii minutos y ss segundos.-->

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ejercicio26</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
</head>
<body>
    <form  action="funciones.php" method="post">
    <input type="text" value="Direccion del archivo" name="direccion"></input>
    <input type="submit" name="submit" value="Copiar"></input>
    </form>
    
</body>
</html>