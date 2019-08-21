<?php

require_once "./clases/Televisor.php";

class Manejadora{
    public static function Filtrado($tipo, $paisOrigen){
        $auxTelevisor = new Televisor();
        $televisores = $auxTelevisor->Traer();
        $tabla = '<table border="1">
                    <thead>
                        <th>Tipo</th>
                        <th>Precio</th>
                        <th>Pais</th>
                        <th>Precio IVA</th>
                        <th>Foto</th>
                    </thead>';
        $filtrado = 0;
        $entre;
        if($tipo != "" && $paisOrigen == ""){
            $filtrado = 1;
        } else if($paisOrigen != "" && $tipo == ""){
            $filtrado = 2;
        } else if($tipo != "" && $paisOrigen != ""){
            $filtrado = 3;
        }
        foreach ($televisores as $televisor){
            $entre = 0;
            if($filtrado == 1 && $televisor->tipo == $tipo){
                $entre = 1;
            } else if($filtrado == 2 && $televisor->paisOrigen == $paisOrigen){
                $entre = 2;
            } else if($filtrado == 3 && $televisor->paisOrigen == $paisOrigen && $televisor->tipo == $tipo){
                $entre = 3;
            }
            if($filtrado == $entre){
                $tabla .= "<tr><td>".$televisor->tipo.'</td><td>'.$televisor->precio.'</td><td>'.$televisor->paisOrigen.'</td><td>'.$televisor->CalcularIVA().'</td><td>';
                if($televisor->path != "") {
                    //echo "Entré al if path diferente de ''";
                    if(file_exists($televisor->path)) {
                        //echo "File exist";
                        $tabla.= '<img src="'.$televisor->path.'" alt="'.$televisor->path.'" height="100px" width="100px">';
                    }
                    else {
                        $tabla.= 'There is no path '.$televisor->path;
                    }
                }
                else {
                    //echo "Entré al else del path diferente de ''";
                    $tabla.= 'No Photo';
                }

                $tabla.= "</td></tr>";
            }
        }

        $tabla.="</table>";
        return $tabla;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Listado</title>
</head>
<body>
    <?php
        $tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";
        $paisOrigen = isset($_POST["paisOrigen"]) ? $_POST["paisOrigen"] : "";
        echo Manejadora::Filtrado($tipo, $paisOrigen);
    ?>
</body>
</html>