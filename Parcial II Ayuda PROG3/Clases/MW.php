<?php

require_once "Usuario.php";
require_once "AutenticadorJWT.php";

class MW extends Usuario{
    public function CamposSeteados($req, $res, $next){
        $params = $req->getParsedBody();
        $jsonParams = json_decode($params["datos"]);
        $ok = true;
        $objResponse = new stdClass();
        $objResponse->msg = "Los siguientes campos no estan seteados: ";

        if(!isset($jsonParams->correo)){
            $ok = false;
            $objResponse->msg .= "correo, ";
        }

        if(!isset($jsonParams->clave)){
            $ok = false;
            $objResponse->msg .= "clave, ";
        }

        if($ok){
            $res = $next($req, $res);
        } else{
            $objResponse->msg = substr($objResponse->msg, 0 , (strlen($objResponse->msg) -2));
            $res = $res->withJson($objResponse, 409);
        }
        return $res;
    }

    public static function CamposVacios($req, $res, $next){
        $params = $req->getParsedBody();
        $jsonParams = json_decode($params["datos"]);
        $ok = true;
        $objResponse = new stdClass();
        $objResponse->msg = "Los siguientes campos estan vacios: ";

        if($jsonParams->correo === ""){
            $ok = false;
            $objResponse->msg .= "correo, ";
        }

        if($jsonParams->clave === ""){
            $ok = false;
            $objResponse->msg .= "clave, ";
        }

        if($ok){
            $res = $next($req, $res);
        } else{
            $objResponse->msg = substr($objResponse->msg, 0 , (strlen($objResponse->msg) -2));
            $res = $res->withJson($objResponse, 409);
        }
        return $res;
    }

    public function VerificarUsuario($req, $res, $next){
        $params = $req->getParsedBody();
        $jsonParams = json_decode($params["datos"]);
        if(Usuario::ExisteUsuario($jsonParams->correo, $jsonParams->clave)){
            $res = $next($req, $res);
        } else{
            $objResponse = new stdClass();
            $objResponse->msg = "El usuario no existe";
            $res = $res->withJson($objResponse, 409);
        }
        return $res;
    }

    public static function VerificarPropietario($req, $res, $next){
        $token = $req->getHeaders()["HTTP_TOKEN"];
        $datos = AutenticadorJWT::ObtenerData($token[0]);
        $objResponse = new stdClass();
        if($datos->perfil === "propietario"){
            $res = $next($req, $res);
        } else{
            $objResponse->msg = "No tiene permiso para realizar la accion. Debe ser propietario";
            $res = $res->withJson($objResponse, 409);
        }

        return $res;
    }

    public function VerificarEncargado($req, $res, $next){
        $token = $req->getHeaders()["HTTP_TOKEN"];
        $datos = AutenticadorJWT::ObtenerData($token[0]);
        $objResponse = new stdClass();
        if($datos->perfil === "encargado" || $datos->perfil === "propietario"){
            $res = $next($req, $res);
        } else{
            $objResponse->msg = "No tiene permiso para realizar la accion. Debe ser encargado o propietario";
            $res = $res->withJson($objResponse, 409);
        }

        return $res;
    }

    public function VerificarToken($req, $res, $next){
        $token = $req->getHeaders()["HTTP_TOKEN"];
        $objResponse = AutenticadorJWT::VerificarToken($token[0]);
        if($objResponse->exito){
            $res = $next($req, $res);
        } else{
            $res = $res->withJson($objResponse, 409);
        }
        return $res;
    }

    public function Listados($req, $res, $next){
        $token = $req->getHeaders()["HTTP_TOKEN"];
        $datos = AutenticadorJWT::ObtenerData($token[0]);
        $res = $next($req, $res);

        $streamBody = $res->getBody();
        $streamBody->rewind();
        $content = $streamBody->read($streamBody->getSize());

        if($datos->perfil === "empleado"){
            $medias = array();
            foreach(json_decode($content) as $media){
                $objResponse = new stdClass();
                $objResponse->color = $media->color;
                $objResponse->marca = $media->marca;
                $objResponse->precio = $media->precio;
                $objResponse->talle = $media->talle;
                array_push($medias, $objResponse);
            }
            $res = $res->withJson($medias, 200);

        } else if($datos->perfil === "encargado"){
            $medias = array();
            $objResponse = array();
            foreach(json_decode($content) as $media){
                if($objResponse[$media->color] === null){
                    $objResponse[$media->color] = 1;
                } else{
                    $objResponse[$media->color]++;
                }
            }
            array_push($medias, $objResponse);
            $res = $res->withJson($medias, 200);
        }

        return $res;
    }
}

?>