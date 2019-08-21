<?php

require_once "./usuario.php";

$OP = $_POST["OP"];

switch($OP){
    case "insertar":
        $correo = $_POST["correo"];
        $clave = $_POST["clave"];
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $perfil = $_POST["perfil"];

        $usuario = new Usuario($correo, $clave, $nombre, $apellido, $perfil);
        if(Usuario::Agregar($usuario)){
            echo "Usuario agregado";
        }else{
            echo "El usuario no se agrego";
        }
    break;

    case "mostrar":
        $usuarios = Usuario::TraerTodos();
        echo var_dump($usuarios);
    break;

    case "mostrarUno":
        $id = $_POST["id"];
        $usuario= Usuario::TraerId($id);
        echo $usuario->correo;
    break;

    case "modificar":
        $id = $_POST["id"];
        $correo = $_POST["correo"];
        $clave = $_POST["clave"];
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $perfil = $_POST["perfil"];

        $usuario = new Usuario($correo, $clave, $nombre, $apellido, $perfil);
        if(Usuario::Modificar($usuario, $id)){
            echo "Usuario Modificado";
        }else{
            echo "El usuario no se modifico";
        }
    break;

    case "eliminar":
        $id = $_POST["id"];
        if($usuarios = Usuario::Eliminar($id)){
            echo "Usuario eliminado";
        }else{
            echo "El usuario no se elimino o no existe";
        }
    break;
}

?>