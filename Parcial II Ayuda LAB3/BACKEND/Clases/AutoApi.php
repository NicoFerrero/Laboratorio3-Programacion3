<?php

require_once "Auto.php";
date_default_timezone_set('America/Argentina/Buenos_Aires');

class AutoApi extends Auto{

    public function TraerTodos($req, $res, $args){

        $id = $args["id"];
        $newResponse = null;
        if($id == null){
            $autos = Auto::TraerAutos();

            if(!$autos){
                $objResponse= new stdclass();
                $objResponse->exito=false;
                $objResponse->msg="No existen autos";
                $newResponse = $res->withJson($objResponse, 418); //500 da error preguntar
            } else{
                $objResponse->exito=true;
                $objResponse->autos=$autos;
                $newResponse = $res->withJson($objResponse, 200);
            }
        } else{
            $auto = Auto::TraerAuto($id);

            if(!$auto){
                $objResponse= new stdclass();
                $objResponse->msg="No existe un auto con ese id";
                $newResponse = $res->withJson($objResponse, 500); //500 da error preguntar
            } else{
                $newResponse = $res->withJson($auto, 200);
            }
        }


        return $newResponse;
    }

    public function InsertarUno($req, $res, $args){
        $params = $req->getParsedBody();
        $jsonParams = json_decode($params["datos"]);
        $auto = new Auto();
        $auto->color = $jsonParams->color;
        $auto->marca = $jsonParams->marca;
        $auto->precio = $jsonParams->precio;
        $auto->modelo = $jsonParams->modelo;

        $newResponse = new stdclass();
        $seAgrego = $auto->InsertarAuto();
        if($seAgrego){
            $newResponse->msg = "Se agrego el auto";
            $newResponse->exito = true;
        } else{
            $newResponse->msg = "No se agrego el auto";
            $newResponse->exito = false;
        }

        return $res->withJson($newResponse, 200);
    }

    public function BorrarUno($req, $res, $args){
        $params = $req->getParsedBody();
        $id = $params["id"];
        $status = 200;
        $newResponse = new stdclass();
        if($auto = Auto::TraerAuto($id)){
            $seBorro = $auto->BorrarAuto();
            if($seBorro){
                $newResponse->msg = "Se borro el auto";
                $newResponse->exito = true;
            } else{
                $newResponse->msg = "No se borro el auto";
                $status = 418;
                $newResponse->exito = false;
            }
        } else{
            $newResponse->msg = "El auto no existe";
            $status = 418;
            $newResponse->exito = false;
        }

        return $res->withJson($newResponse, $status);
    }

    public function ModificarUno($req, $res, $args){

        $params = $req->getParsedBody();
        $jsonParams = json_decode($params["datos"]);
        $newResponse = new stdclass();
        $status = 200;
        if($auto = Auto::TraerAuto($jsonParams->id)){
            $auto->id = $jsonParams->id;
            $auto->color = $jsonParams->color;
            $auto->marca = $jsonParams->marca;
            $auto->talle = $jsonParams->talle;
            $auto->modelo = $jsonParams->modelo;

            $seModifico = $auto->ModificarAuto();

            if($seModifico){
                $newResponse->msg = "Se modifico el auto";
                $newResponse->exito = true;
            } else{
                $newResponse->msg = "No se modifico el auto";
                $status = 418;
                $newResponse->exito = false;
            }
        } else{
            $newResponse->msg = "El auto no existe";
            $status = 418;
            $newResponse->exito = false;
        }

        return $res->withJson($newResponse, $status);
    }

}

?>