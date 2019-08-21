<?php

require_once "AccesoDatos.php";
$caso = isset($_POST["caso"]) ? $_POST["caso"] : null;

switch ($caso) {

    case "eliminar":
    $cadenaJSON = isset($_POST['cadenaJson']) ? $_POST['cadenaJson'] : null;
    $objJson = json_decode($cadenaJSON);
    $resultado["TodoOK"] = false;
    $string = "";
    $objetoDatos = AccesoDatos::ObtenerObjetoAcceso();
    $consulta = $objetoDatos->RetornarConsulta("DELETE FROM perros WHERE nombre=:nombre AND raza=:raza"); //Se prepara la consulta, aquí se podrían poner los alias
    $consulta->bindValue(':nombre', $objJson->nombre);
    $consulta->bindValue(':raza', $objJson->raza);
    $consulta->execute();
    if($consulta->rowCount() > 0){
        $resultado["TodoOK"] = true;
    }
    echo json_encode($resultado);
    break;

}

?>