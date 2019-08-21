<?php

require_once "Usuario.php";
require_once "IApiUsable.php";

class UsuarioApi extends Usuario implements IApiUsable{
    public function TraerUno($req, $res, $args){
        $id = $args['id'];
        $newResponse = null;
        $usuario = Usuario::TraerUsuario($id);

        if(!$usuario){
            $objResponse= new stdclass();
            $objResponse->msg="No existe el empleado";
            $newResponse = $res->withJson($objResponse, 500);
        } else{
            $newResponse = $res->withJson($usuario, 200);
        }

        return $newResponse;
    }

    public function TraerTodos($req, $res, $args){
        $usuarios = Usuario::TraerUsuarios();
        $newResponse = null;

        if(!$usuarios){
            $objResponse= new stdclass();
            $objResponse->msg="No existen empleados";
            $newResponse = $res->withJson($objResponse, 500);
        } else{
            $newResponse = $res->withJson($usuarios, 200);
        }

        return $newResponse;
    }

    public function InsertarUno($req, $res, $args){
        $params = $req->getParsedBody();
        $jsonParams = json_decode($params["datos"]);

        $usuario = new Usuario();
        $usuario->correo = $jsonParams->correo;
        $usuario->clave = $jsonParams->clave;
        $usuario->nombre = $jsonParams->nombre;
        $usuario->apellido = $jsonParams->apellido;
        $usuario->perfil = $jsonParams->perfil;

        $newResponse = new stdclass();
        $seAgrego = $usuario->InserUsuario();
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
        /*SI LO HAGO COMO /USUARIOS Y TOMO EL ID COMO GETPARSEDBODY NUNCA BORRA EL USUARIO
        $params = $req->getParsedBody();
        $id = $params["id"];
        */
        $id = $args["id"];
        $usuario = new Usuario();
        $usuario->id = $id;

        $newResponse = new stdclass();
        $seBorro = $usuario->BorrarUsuario();
        if($seBorro){
            $newResponse->msg = "Se borro el usuario";
            $newResponse->exito = true;
        } else{
            $newResponse->msg = "No se borro el usuario";
            $newResponse->exito = false;
        }

        return $res->withJson($newResponse, 200);
    }

    public function ModificarUno($req, $res, $args){
        /*SI LO HAGO CON PUT NO ME LO TOMA*/
        $params = $req->getParsedBody();
        $jsonParams = json_decode($params["datos"]);

        $usuario = new Usuario();
        $usuario->id = $jsonParams->id;
        $usuario->correo = $jsonParams->correo;
        $usuario->clave = $jsonParams->clave;
        $usuario->nombre = $jsonParams->nombre;
        $usuario->apellido = $jsonParams->apellido;
        $usuario->perfil = $jsonParams->perfil;
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