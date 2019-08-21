<?php

require_once "./clases/Televisor.php";

class Manejadora{
    public static function Listado(){
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
        foreach ($televisores as $televisor){
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
    <?php echo Manejadora::Listado(); ?>
</body>
</html>