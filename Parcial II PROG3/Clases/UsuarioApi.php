<?php

require_once "Usuario.php";
date_default_timezone_set('America/Argentina/Buenos_Aires');

class UsuarioApi extends Usuario{

    public function TraerTodos($req, $res, $args){
        $apellido = $args["apellido"];
        $newResponse = null;

        if($apellido == null){
            $usuarios = Usuario::TraerUsuarios();
            if(!$usuarios){
                $objResponse= new stdclass();
                $objResponse->exito=false;
                $objResponse->msg="No existen usuarios";
                $newResponse = $res->withJson($objResponse, 424); //500 da error preguntar
            } else{
                $objResponse->exito=true;
                $objResponse->usuarios=$usuarios;
                $newResponse = $res->withJson($objResponse, 200);
            }
        } else{
            $usuario = Usuario::TraerUsuario($apellido);
            if(!$usuario){
                $objResponse= new stdclass();
                $objResponse->msg="No existe un usuario con ese apellido";
                $newResponse = $res->withJson($objResponse, 500); //500 da error preguntar
            } else{
                $newResponse = $res->withJson($usuario, 200);
            }
        }

        return $newResponse;
    }

    public function InsertarUno($req, $res, $args){
        $params = $req->getParsedBody();
        $jsonParams = json_decode($params["datos"]);
        $archivo = $req->getUploadedFiles();
        $destino = "fotos/";

        if(isset($archivo["foto"])){
            $nombreAnterior = $archivo["foto"]->getClientFileName();
            $extension= explode(".", $nombreAnterior);
            $extension = array_reverse($extension);
            $destino .= $jsonParams->nombre . "_" . date('Ymd_His') . "." . $extension[0];
            $archivo["foto"]->moveTo($destino);
        } else{
            $destino = "usr_default.jpg";
        }

        $usuario = new Usuario();
        $usuario->correo = $jsonParams->correo;
        $usuario->clave = $jsonParams->clave;
        $usuario->nombre = $jsonParams->nombre;
        $usuario->apellido = $jsonParams->apellido;
        $usuario->perfil = $jsonParams->perfil;
        $usuario->foto = $destino;

        $newResponse = new stdclass();
        $seAgrego = $usuario->InsertarUsuario();
        if($seAgrego){
            $newResponse->msg = "Se agrego el usuario";
            $newResponse->exito = true;
        } else{
            $newResponse->msg = "No se agrego el usuario";
            $newResponse->exito = false;
        }

        return $res->withJson($newResponse, 200);
    }
}

?>