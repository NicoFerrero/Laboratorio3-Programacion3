<?php

require_once "Usuario.php";
require_once "IApiUsable.php";
date_default_timezone_set('America/Argentina/Buenos_Aires');

class UsuarioApi extends Usuario implements IApiUsable{

    public function TraerUno($req, $res, $args){
        $id = $args['id'];
        $newResponse = null;
        $empleado = Empleado::TraerEmpleado($id);

        if(!$empleado){
            $objResponse= new stdclass();
            $objResponse->msg="No existe el empleado";
            $newResponse = $res->withJson($objResponse, 200); //500 da error preguntar
        } else{
            $newResponse = $res->withJson($empleado, 200);
        }

        return $newResponse;
    }

    public function TraerTodos($req, $res, $args){
        $usuarios = Usuario::TraerUsuarios();
        $newResponse = null;

        if(!$usuarios){
            $objResponse= new stdclass();
            $objResponse->msg="No existen usuarios";
            $newResponse = $res->withJson($objResponse, 500); //500 da error preguntar
        } else{
            $newResponse = $res->withJson($usuarios, 200);
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

    public function BorrarUno($req, $res, $args){
        $id = $args["id"];
        $empleado = new Empleado();
        $empleado = $empleado->TraerEmpleado($id);

        $newResponse = new stdclass();
        $seBorro = $empleado->BorrarEmpleado();
        if($seBorro){
            if(explode("/", $empleado->foto)[2] != "usr_default.jpg"){
                copy("fotos/" . explode("/", $empleado->foto)[3], "eliminados/Eliminado_" . explode("/", $empleado->foto)[3]);
                unlink("fotos/" . explode("/", $empleado->foto)[3]);
            }
            $newResponse->msg = "Se borro el empleado";
            $newResponse->exito = true;
        } else{
            $newResponse->msg = "No se borro el empleado";
            $newResponse->exito = false;
        }

        return $res->withJson($newResponse, 200);
    }

    public function ModificarUno($req, $res, $args){

        $params = $req->getParsedBody();
        $jsonParams = json_decode($params["datos"]);
        $archivo = $req->getUploadedFiles();
        $destino = "fotos/";

        $empleadoModificar = new Empleado();
        $empleadoModificar = $empleadoModificar->TraerEmpleado($jsonParams->id);

        if(explode("/", $empleadoModificar->foto)[2] != "usr_default.jpg"){
            copy("fotos/" . explode("/", $empleadoModificar->foto)[3], "modificados/Modificado_" . explode("/", $empleadoModificar->foto)[3]);
            unlink("fotos/" . explode("/", $empleadoModificar->foto)[3]);
        }

        if(isset($archivo["foto"])){
            $nombreAnterior = $archivo["foto"]->getClientFileName();
            $extension= explode(".", $nombreAnterior);
            $extension = array_reverse($extension);
            $destino .= $jsonParams->legajo . "_" . date('Ymd_His') . "." . $extension[0];
            $archivo["foto"]->moveTo($destino);
        } else{
            $destino = "usr_default.jpg";
        }

        $empleado = new Empleado();
        $empleado->id = $jsonParams->id;
        $empleado->nombre = $jsonParams->nombre;
        $empleado->apellido = $jsonParams->apellido;
        $empleado->sueldo = $jsonParams->sueldo;
        $empleado->foto = "./BACKEND/" . $destino;
        $empleado->legajo = $jsonParams->legajo;
        $empleado->clave = $jsonParams->clave;

        $newResponse = new stdclass();
        $seModifico = $empleado->ModificarEmpleado();

        if($seModifico){
            $newResponse->msg = "Se modifico el empleado";
            $newResponse->exito = true;
        } else{
            $newResponse->msg = "No se modifico el empleado";
            $newResponse->exito = false;
        }

        return $res->withJson($newResponse, 200);
    }

}

?>