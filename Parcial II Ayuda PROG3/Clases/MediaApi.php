<?php

require_once "Media.php";
require_once "IApiUsable.php";
date_default_timezone_set('America/Argentina/Buenos_Aires');

class MediaApi extends Media implements IApiUsable{

    public function TraerUno($req, $res, $args){
    }

    public function TraerTodos($req, $res, $args){

        $id = $args["id"];
        $newResponse = null;
        if($id == null){
            $medias = Media::TraerMedias();

            if(!$medias){
                $objResponse= new stdclass();
                $objResponse->msg="No existen medias";
                $newResponse = $res->withJson($objResponse, 500); //500 da error preguntar
            } else{
                $newResponse = $res->withJson($medias, 200);
            }
        } else{
            $media = Media::TraerMedia($id);

            if(!$media){
                $objResponse= new stdclass();
                $objResponse->msg="No existe una media con ese id";
                $newResponse = $res->withJson($objResponse, 500); //500 da error preguntar
            } else{
                $newResponse = $res->withJson($media, 200);
            }
        }


        return $newResponse;
    }

    public function InsertarUno($req, $res, $args){
        $params = $req->getParsedBody();
        $jsonParams = json_decode($params["datos"]);
        $media = new Media();
        $media->color = $jsonParams->color;
        $media->marca = $jsonParams->marca;
        $media->precio = $jsonParams->precio;
        $media->talle = $jsonParams->talle;

        $newResponse = new stdclass();
        $seAgrego = $media->InsertarMedia();
        if($seAgrego){
            $newResponse->msg = "Se agrego la media";
            $newResponse->exito = true;
        } else{
            $newResponse->msg = "No se agrego la media";
            $newResponse->exito = false;
        }

        return $res->withJson($newResponse, 200);
    }

    public function BorrarUno($req, $res, $args){
        $params = $req->getParsedBody();
        $id = $params["id"];
        $newResponse = new stdclass();
        if($media = Media::TraerMedia($id)){
            $seBorro = $media->BorrarMedia();
            if($seBorro){
                $newResponse->msg = "Se borro la media";
                $newResponse->exito = true;
            } else{
                $newResponse->msg = "No se borro la media";
                $newResponse->exito = false;
            }
        } else{
            $newResponse->msg = "La media no existe";
            $newResponse->exito = false;
        }

        return $res->withJson($newResponse, 200);
    }

    public function ModificarUno($req, $res, $args){

        $params = $req->getParsedBody();
        $jsonParams = json_decode($params["datos"]);
        $newResponse = new stdclass();
        if($media = Media::TraerMedia($jsonParams->id)){
            $media->id = $jsonParams->id;
            $media->color = $jsonParams->color;
            $media->marca = $jsonParams->marca;
            $media->talle = $jsonParams->talle;
            $media->precio = $jsonParams->precio;

            $seModifico = $media->ModificarMedia();

            if($seModifico){
                $newResponse->msg = "Se modifico la media";
                $newResponse->exito = true;
            } else{
                $newResponse->msg = "No se modifico la media";
                $newResponse->exito = false;
            }
        } else{
            $newResponse->msg = "La media no existe";
            $newResponse->exito = false;
        }

        return $res->withJson($newResponse, 200);
    }

}

?>