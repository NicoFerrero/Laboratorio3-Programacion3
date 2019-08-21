<?php

require_once "Empleado.php";
require_once "IApiUsable.php";
date_default_timezone_set('America/Argentina/Buenos_Aires');

class EmpleadoApi extends Empleado implements IApiUsable{

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
        $empleados = Empleado::TraerEmpleados();
        $newResponse = null;

        if(!$empleados){
            $objResponse= new stdclass();
            $objResponse->msg="No existen empleados";
            $newResponse = $res->withJson($objResponse, 200); //500 da error preguntar
        } else{
            $newResponse = $res->withJson($empleados, 200);
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
            $destino .= $jsonParams->legajo . "_" . date('Ymd_His') . "." . $extension[0];
            $archivo["foto"]->moveTo($destino);
        } else{
            $destino = "usr_default.jpg";
        }

        $empleado = new Empleado();
        $empleado->nombre = $jsonParams->nombre;
        $empleado->apellido = $jsonParams->apellido;
        $empleado->sueldo = $jsonParams->sueldo;
        $empleado->foto = "./BACKEND/" . $destino;
        $empleado->legajo = $jsonParams->legajo;
        $empleado->clave = $jsonParams->clave;

        $newResponse = new stdclass();
        $seAgrego = $empleado->InsertarEmpleado();
        if($seAgrego){
            $newResponse->msg = "Se agrego el empleado";
            $newResponse->exito = true;
        } else{
            $newResponse->msg = "No se agrego el empleado";
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