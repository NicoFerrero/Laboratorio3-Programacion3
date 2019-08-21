<?php

$op = isset($_POST["op"]) ? $_POST["op"] : null;

switch ($op) {

    case "subirFoto":
        $nombre = $_POST["nombre"];
        $legajo = $_POST["legajo"];
        $objRetorno = new stdClass();
        $objRetorno->Ok = false;
        $objRetorno->msg = "El empleado no se agrego, hubo un error al subir la foto";
        $empleado = new stdClass();
        $empleado->nombre = $nombre;
        $empleado->legajo = $legajo;
        $string = "[";
        $esta = false; //existe el empleado o no
        $foto = true; //se envio foto o no
        $pudo = false; //se pudo mover la foto a la carpeta que coprresponda

        if(empty($_FILES)){
            $foto = false;
        }
        $destino = "./fotos/" . $nombre . "_" . $legajo . "_" . date("Ymd_His") . ".jpg";
        $archivo = fopen("./archivo/empleado.json", "r");
        $linea = fread($archivo, filesize("./archivo/empleado.json"));
        $obj = json_decode($linea);

        foreach ($obj as $clave => $valor) {
            if($empleado->legajo === $valor->legajo){
                $esta = true;
                $objRetorno->msg = "El empleado no se agrego, ya existe un empleado con ese legajo";
                break;
            }
        }

        if(!$esta){
            foreach ($obj as $clave => $valor) {
                $string .= json_encode($valor, JSON_UNESCAPED_SLASHES) . ",\r\n";
            }
            fclose($archivo);

            if($foto){
                $pudo = move_uploaded_file($_FILES["foto"]["tmp_name"], $destino);
            } else{
                $pudo = copy("./usr_default.jpg", $destino);
            }

            if($pudo){
                $empleado->path = $destino;
                $archivo = fopen("./archivo/empleado.json", "w");
                $string .= json_encode($empleado, JSON_UNESCAPED_SLASHES) . "]";
                $cant = fwrite($archivo, $string);
                if($cant > 0){
                    $objRetorno->Ok = true;
                    $objRetorno->msg = $destino;
                }
                fclose($archivo);
            }
        }

        echo json_encode($objRetorno, JSON_UNESCAPED_SLASHES);

    break;

    case "mostrarListado":
        $tabla = '<table class="table table-bordered" style="background-color:darksalmon">
                    <thead>
                        <th>Nombre</th>
                        <th>Legajo</th>
                        <th>Foto</th>
                        <th>Acciones</th>
                    </thead>';
        $archivo = fopen("./archivo/empleado.json", "r");
        $linea = fread($archivo, filesize("./archivo/empleado.json"));
        $obj = json_decode($linea);
        foreach ($obj as $clave => $valor) {
            $tabla .= '<tr><td>' . $valor->nombre .  '</td><td>' . $valor->legajo . '</td><td><img src="BACKEND/' . $valor->path . '" height="100" width="150">' . '</img></td><td><input type="button" class="btn btn-danger" value="Eliminar" onclick=Eliminar(' . json_encode($valor, JSON_UNESCAPED_SLASHES) . ') \><input type="button" class="btn btn-warning" value="Modificar" onclick=Modificar(' . json_encode($valor, JSON_UNESCAPED_SLASHES) . ') \></td></tr>';
        }
        fclose($archivo);
        echo $tabla;
    break;

    case "eliminar":
        $objRetorno = new stdClass();
        $objRetorno->Ok = false;
        $objBorrarAux = $_POST["obj"];
        $objBorrar = json_decode($objBorrarAux);
        $string = "";

        $archivo = fopen("./archivo/empleado.json", "r");
        $linea = fread($archivo, filesize("./archivo/empleado.json"));
        $obj = json_decode($linea);
        foreach ($obj as $clave => $valor) {
            if($objBorrar->nombre === $valor->nombre && $objBorrar->legajo === $valor->legajo){
                copy($objBorrar->path, "./eliminados/" . $objBorrar->nombre . "_" . $objBorrar->legajo . "_eliminado_" . date("Ymd_His") . ".jpg");
                unlink($objBorrar->path);
                continue;
            }
            $string .= json_encode($valor, JSON_UNESCAPED_SLASHES) . ",\r\n";
        }
        $stringFinal = substr($string, 0, strlen($string)-3);
        fclose($archivo);
        $archivo = fopen("./archivo/empleado.json", "w");
        $cant = fwrite($archivo, "[" . $stringFinal . "]");
        if($cant > 0){
            $objRetorno->Ok = true;
        }
        fclose($archivo);
        echo json_encode($objRetorno, JSON_UNESCAPED_SLASHES);
    break;

    case "modificar":
        $nombre = $_POST["nombre"];
        $legajo = $_POST["legajo"];
        $objRetorno = new stdClass();
        $objRetorno->Ok = false;
        $objRetorno->msg = "No se pudo modificar el empleado";
        $empleadoModificar = new stdClass();
        $empleadoModificar->nombre = $nombre;
        $empleadoModificar->legajo = $legajo;
        $string = "";
        $foto = true; //se envio foto o no
        $pudo = false; //se pudo mover la foto a la carpeta que coprresponda.
        $destino = "./fotos/" . $nombre . "_" . $legajo . "_" . date("Ymd_His") . ".jpg";

        if(empty($_FILES)){
            $foto = false;
        }
        $archivo = fopen("./archivo/empleado.json", "r");
        $linea = fread($archivo, filesize("./archivo/empleado.json"));
        $obj = json_decode($linea);

        foreach ($obj as $clave => $valor) {
            if($empleadoModificar->legajo === $valor->legajo){
                copy($valor->path, "./modificados/" . $valor->nombre . "_" . $valor->legajo . "_modificado_" . date("Ymd_His") . ".jpg");
                unlink($valor->path);
                continue;
            }
            $string .= json_encode($valor, JSON_UNESCAPED_SLASHES) . ",\r\n";
        }
        fclose($archivo);

        if($foto){
            $pudo = move_uploaded_file($_FILES["foto"]["tmp_name"], $destino);
        } else{
            $pudo = copy("./usr_default.jpg", $destino);
        }

        if($pudo){
            $empleadoModificar->path = $destino;
            $string .= json_encode($empleadoModificar, JSON_UNESCAPED_SLASHES) . ",\r\n";
            $stringFinal = substr($string, 0, strlen($string)-3);
            $archivo = fopen("./archivo/empleado.json", "w");
            $cant = fwrite($archivo, "[" . $stringFinal . "]");
            if($cant > 0){
                $objRetorno->Ok = true;
                $objRetorno->msg = $destino;
            }
            fclose($archivo);
        }
        echo json_encode($objRetorno, JSON_UNESCAPED_SLASHES);
    break;

    default:
        echo ":(";
    break;
}