<?php

require_once "./clases/Juguete.php";

class Manejadora{
    public static function Listado(){
        $auxJuguete = new Juguete("", "", 0);
        $juguetes = array();
        $juguetes = $auxJuguete->Traer();
        $tabla = '<table border="1">
                    <thead>
                        <th>Tipo</th>
                        <th>Precio</th>
                        <th>Pais</th>
                        <th>Precio IVA</th>
                        <th>Foto</th>
                    </thead>';
        foreach ($juguetes as $juguete){
            $tabla .= "<tr><td>".$juguete->getTipo().'</td><td>'.$juguete->getPrecio().'</td><td>'.$juguete->getPais().'</td><td>'.$juguete->CalcularIVA().'</td><td>';
            if($juguete->getPath() != "") {
                //echo "Entré al if path diferente de ''";
                if(file_exists($juguete->getPath())) {
                    //echo "File exist";
                    $tabla.= '<img src="'.$juguete->getPath().'" alt="'.$juguete->getPath().'" height="100px" width="100px">';
                }
                else {
                    $tabla.= 'There is no path '.$juguete->path;
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