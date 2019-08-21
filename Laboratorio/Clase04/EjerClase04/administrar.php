<?php   

//echo "Hola Mundo";

switch($_GET["accion"]){
    case "1":
        echo ($_GET["nombre"] != "") ? $_GET["nombre"] : "No se envio ningun nombre";
    break;

    case "2":
        if($_GET["nombre"] != ""){
            $archivo = fopen("nombres.txt", "a");
            $cant = fwrite($archivo, $_GET["nombre"] . "\r\n");
            fclose($archivo);
            echo ($cant > 0) ? 1 : 0;
        }
        else{
            echo 0;
        }
    break;

    case "3":
        $tabla = "<table border=1><tr><th>Nombres</th></tr>";
        $archivo = fopen("nombres.txt", "r");
        while(!feof($archivo)){
            $aux = trim(fgets($archivo));
            if($aux == ""){
                continue;
            }
            $tabla .= "<tr><td>$aux</td></tr>";
        }
        fclose($archivo);
        $tabla .= "</table>";
        echo $tabla;
    break;

    case "4":
        $archivo = fopen("nombres.txt", "r");
        $esta = 0;
        $nombre = $_GET["nombre"];
        while(!feof($archivo)){
            $aux = trim(fgets($archivo));
            if($aux == ""){
                continue;
            }
            if($nombre == $aux){
                $esta = 1;
                break;
            }
        }
        echo $esta;
        fclose($archivo);
    break;
}

?>