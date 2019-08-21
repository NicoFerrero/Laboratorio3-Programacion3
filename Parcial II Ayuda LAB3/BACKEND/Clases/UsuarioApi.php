<?php

require_once "Usuario.php";
date_default_timezone_set('America/Argentina/Buenos_Aires');

class UsuarioApi extends Usuario{

    public function TraerTodos($req, $res, $args){

        $apellido = isset($args["apellido"]) ? $args["apellido"] : null;
        $newResponse = null;
        $objResponse= new stdclass();

        if($apellido == null){
            $usuarios = Usuario::TraerUsuarios();
            if(!$usuarios){
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
        $usuario->foto = "./BACKEND/" . $destino;

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

    public function BorrarUno($req, $res, $args){
        $params = $req->getParsedBody();
        $id = $params["id"];
        $newResponse = new stdclass();
        $usuario = Usuario::TraerUsuarioID($id);
        $seBorro = $usuario->BorrarUsuario();
        if($seBorro){
            if(explode("/", $usuario->foto)[2] != "usr_default.jpg"){
                copy("fotos/" . explode("/", $usuario->foto)[3], "eliminados/Eliminado_" . explode("/", $usuario->foto)[3]);
                unlink("fotos/" . explode("/", $usuario->foto)[3]);
            }
            $newResponse->msg = "Se borro el usuario";
            $newResponse->exito = true;
        } else{
            $newResponse->msg = "No se borro el usuario";
            $newResponse->exito = false;
        }

        return $res->withJson($newResponse, 200);
    }

    public function ModificarUno($req, $res, $args){

        $params = $req->getParsedBody();
        $jsonParams = json_decode($params["datos"]);
        $archivo = $req->getUploadedFiles();
        $destino = "fotos/";

        $usuarioModificar = new Usuario();
        $usuarioModificar = Usuario::TraerUsuarioID($jsonParams->id);

        if(explode("/", $usuarioModificar->foto)[2] != "usr_default.jpg"){
            copy("fotos/" . explode("/", $usuarioModificar->foto)[3], "modificados/Modificado_" . explode("/", $usuarioModificar->foto)[3]);
            unlink("fotos/" . explode("/", $usuarioModificar->foto)[3]);
        }

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
        $usuario->id = $jsonParams->id;
        $usuario->nombre = $jsonParams->nombre;
        $usuario->apellido = $jsonParams->apellido;
        $usuario->perfil = $jsonParams->perfil;
        $usuario->foto = "./BACKEND/" . $destino;
        $usuario->correo = $jsonParams->correo;
        $usuario->clave = $jsonParams->clave;

        $newResponse = new stdclass();
        $seModifico = $usuario->ModificarUsuario();

        if($seModifico){
            $newResponse->msg = "Se modifico el usuario";
            $newResponse->exito = true;
        } else{
            $newResponse->msg = "No se modifico el usuario";
            $newResponse->exito = false;
        }

        return $res->withJson($newResponse, 200);
    }
}

?>