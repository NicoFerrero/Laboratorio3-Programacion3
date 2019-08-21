<?php

    $conStr ="mysql:host=localhost;dbname=cdcol";
    $user = "root";
    $pass = "";

    try{
        $pdo = new PDO($conStr, $user, $pass);
        echo "conexion establecida <br>";
        $query = $pdo->query("SELECT * from cds");
        echo "Filas: " . $query->rowCount() . "<br>";
        //echo var_dump($query->fetchAll());
        /*foreach ($query->fetchAll() as $fila) {
            echo $fila[0] . "-" . $fila[1] . "-" . $fila[2] . "-" . $fila[3] . "<br>";
        }*/
        foreach ($query->fetchAll(PDO::FETCH_OBJ) as $fila) {
            echo $fila->titel . "-" . $fila->interpret . "-" . $fila->jahr . "-" . $fila->id . "<br>";
        }
    }catch(PDOEception $e){
        echo "Error: " . $e->GetMessage(); 
    }
    

?>
