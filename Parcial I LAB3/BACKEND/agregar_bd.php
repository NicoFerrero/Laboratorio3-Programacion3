<?php

require_once "AccesoDatos.php";
$caso = isset($_POST["caso"]) ? $_POST["caso"] : null;

switch ($caso) {

    case "agregarBD":

        $cadenaJSON = isset($_POST['cadenaJson']) ? $_POST['cadenaJson'] : null;
        $objJson = json_decode($cadenaJSON);
        $resultado["TodoOK"] = false;

        $objetoDatos = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoDatos->RetornarConsulta("INSERT INTO perros (tamanio, edad, precio, nombre, raza, path_foto) VALUES(:tamanio, :edad, :precio, :nombre, :raza, :path_foto)");
        $consulta->bindValue(':tamanio', $objJson->tamanio);
        $consulta->bindValue(':edad', $objJson->edad);
        $consulta->bindValue(':precio', $objJson->precio);
        $consulta->bindValue(':nombre', $objJson->nombre);
        $consulta->bindValue(':raza', $objJson->raza);
        $consulta->bindValue(':path_foto', $objJson->pathFoto);

        $consulta->execute();
        if($consulta->rowCount() > 0){
            if($_FILES != null){
                $pathOrigen = $_FILES['foto']['tmp_name'];
                $pathDestino = "./fotos/".$objJson->pathFoto;
                move_uploaded_file($pathOrigen, $pathDestino);
                $resultado["TodoOK"] = true;
                $resultado["caso"] = "agregar";
            }
        }
        echo json_encode($resultado);
    break;

    case "modificar":
        $cadenaJSON = isset($_POST['cadenaJson']) ? $_POST['cadenaJson'] : null;
        $cadenaJSONActual = isset($_POST['perroModificar']) ? $_POST['perroModificar'] : null;
        $objJson = json_decode($cadenaJSON);
        $objJsonActual = json_decode($cadenaJSONActual);
        $resultado["TodoOK"] = false;

        $objetoDatos = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoDatos->RetornarConsulta("UPDATE perros set tamanio = :tamanio, edad = :edad, precio = :precio, nombre = :nombre, raza = :raza, path_foto = :path_foto WHERE tamanio = :tamanioActual AND edad = :edadActual AND precio = :precioActual AND nombre = :nombreActual AND raza = :razaActual AND path_foto = :path_fotoActual");
        $consulta->bindValue(':tamanio', $objJson->tamanio);
        $consulta->bindValue(':edad', $objJson->edad);
        $consulta->bindValue(':precio', $objJson->precio);
        $consulta->bindValue(':nombre', $objJson->nombre);
        $consulta->bindValue(':raza', $objJson->raza);
        $consulta->bindValue(':path_foto', $objJson->pathFoto);

        $consulta->bindValue(':tamanioActual', $objJsonActual->tamanio);
        $consulta->bindValue(':edadActual', $objJsonActual->edad);
        $consulta->bindValue(':precioActual', $objJsonActual->precio);
        $consulta->bindValue(':nombreActual', $objJsonActual->nombre);
        $consulta->bindValue(':razaActual', $objJsonActual->raza);
        $consulta->bindValue(':path_fotoActual', $objJsonActual->pathFoto);

        $consulta->execute();
        if($consulta->rowCount() > 0){
            if($_FILES != null){
                $pathOrigen = $_FILES['foto']['tmp_name'];
                $pathDestino = "./fotos/".$objJson->pathFoto;
                if($objJsonActual->pathFoto !== "perro_default.png"){
                    copy("./fotos/" . $objJsonActual->pathFoto, "./fotos_modificadas/" . explode(".",$objJsonActual->pathFoto)[0] . "." . explode(".",$objJsonActual->pathFoto)[1] . "_MODIFICADA.jpg");
                    unlink("./fotos/" . $objJsonActual->pathFoto);
                }
                move_uploaded_file($pathOrigen, $pathDestino);
                $resultado["TodoOK"] = true;
                $resultado["caso"] = "modificar";
            }
        }
        echo json_encode($resultado);
    break;
}

?>