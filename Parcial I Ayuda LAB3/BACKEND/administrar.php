<?php
$caso = isset($_POST["caso"]) ? $_POST["caso"] : null;

//var_dump($caso);
sleep(1);

switch ($caso) {

    case 'agregar':

        $cadenaJSON = isset($_POST['cadenaJson']) ? $_POST['cadenaJson'] : null;

        $ar = fopen("./alien.json", "a");

		$cant = fwrite($ar, $cadenaJSON . "\r\n");

        fclose($ar);

        $resultado["TodoOK"] = $cant > 0 ? true : false;
        $resultado["caso"] = "agregar";

        if($_FILES != null){
            $pathOrigen = $_FILES['foto']['tmp_name'];

            $objJson = json_decode($cadenaJSON);
            //echo($cadenaJSON); die();
            $pathDestino = "./fotos/".$objJson->pathFoto;

            move_uploaded_file($pathOrigen, $pathDestino);
        }

        echo json_encode($resultado);
    break;

    case 'traer':

        $a = fopen("./alien.json", "r");

        $string = "";

        while(!feof($a)){

            $linea = trim(fgets($a));

            if(strlen($linea) > 0)
                $string .=  $linea . ',';
        }

        fclose($a);

        $string = substr($string, 0, strlen($string)-1);

        echo ('['.$string.']');

    break;

    case 'eliminar':

        $cadenaJSON = isset($_POST['cadenaJson']) ? $_POST['cadenaJson'] : null;

        //var_dump($cadenaJSON);
        $obj = json_decode($cadenaJSON);

        $a = fopen("./alien.json","r");

        $string = '';

        while(!feof($a)){
            $linea = trim(fgets($a));

            if(strlen($linea) > 0){
                $vec = explode(",", $linea);
                $cuadrante = trim(explode(":", $vec[0])[1],'"');//Obtiene el valor del cuadrante.
                $raza = trim(explode(":", $vec[3])[1],'"');//Obtiene el valor de la raza.

                if($cuadrante == $obj->cuadrante && $raza == $obj->raza){
                    continue;
                }
                $string .= $linea . "\r\n";
            }
        }

        fclose($a);

        $objRetorno = new stdClass();
        $objRetorno->TodoOK = true;

        $a = fopen("./alien.json","w");

        $cant = fwrite($a, $string);

        fclose($a);

        if($cant < 1){
            $objRetorno->TodoOK = false;
        }

        echo json_encode($objRetorno);

    break;

    case 'modificar':

        $cadenaJSON = isset($_POST['cadenaJson']) ? $_POST['cadenaJson'] : null;
        $obj = json_decode($cadenaJSON);

        $a = fopen("./alien.json","r");

        $string = '';

        while(!feof($a)){
            $linea = trim(fgets($a));

            if(strlen($linea) > 0){
                $vec = explode(",", $linea);
                $cuadrante = trim(explode(":", $vec[0])[1],'"');//Obtiene el valor del cuadrante.
                $raza = trim(explode(":", $vec[3])[1],'"');//Obtiene el valor de la raza.

                if($cuadrante == $obj->cuadrante && $raza == $obj->raza){
                    continue;
                }
                $string .= $linea . "\r\n";
            }
        }

        $string .=  $cadenaJSON . "\r\n";

        fclose($a);

        $objRetorno = new stdClass();
        $objRetorno->TodoOK = TRUE;
        $objRetorno->caso = "modificar";

        $a = fopen("./alien.json","w");

        $cant = fwrite($a, $string);

        fclose($a);

        if($cant < 1){
            $objRetorno->TodoOK = FALSE;
        }

        if($_FILES != null){
            $pathOrigen = $_FILES['foto']['tmp_name'];

            $objJson = json_decode($cadenaJSON);
            //echo($cadenaJSON); die();
            $pathDestino = "./fotos/".$objJson->pathFoto;

            move_uploaded_file($pathOrigen, $pathDestino);
        }

        echo json_encode($objRetorno);

    break;

    case "planetas":

        $a = fopen("./planetas.json","r");
        $paises = fread($a, filesize("./planetas.json"));
        fclose($a);

        echo ($paises);

    break;

    case "filtrar":

        $a = fopen("./alien.json","r");
        $planetaAux = $_POST["planeta"];
        $string = '';
        while(!feof($a)){
            $linea = trim(fgets($a));

            if(strlen($linea) > 0){
                $vec = explode(",", $linea);
                $planeta = trim(explode(":", $vec[4])[1],'"');//Obtiene el valor del planeta.

                if($planeta != $planetaAux){
                    continue;
                }
                $string .= $linea . ",";
            }
        }

        $string = substr($string, 0, strlen($string)-1);

        echo ('['.$string.']');

    break;

    default:
        echo ":(";
        break;
}