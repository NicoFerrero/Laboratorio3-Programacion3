<?php

require_once "Empleado.php";
require_once "AutenticadorJWT.php";

class Middleware extends Empleado{

    public static function VerificarLegajo($req, $res, $next){
        $params = $req->getParsedBody();
        $jsonParams = json_decode($params["datos"]);
        if(!Empleado::ExisteEmpleado($jsonParams->legajo)){
            $res = $next($req, $res);
        } else{
            $objResponse = new stdClass();
            $objResponse->msg = "El legajo ya existe inserte otro";
            $res = $res->withJson($objResponse, 403);
        }
        return $res;
    }

    public static function VerificarCampos($req, $res, $next){
        $params = $req->getParsedBody();
        $jsonParams = json_decode($params["datos"]);
        $ok = true;
        $objResponse = new stdClass();
        $objResponse->msg = "Los siguientes campos estan vacios: ";

        if($jsonParams->nombre === ""){
            $ok = false;
            $objResponse->msg .= "nombre, ";
        }

        if($jsonParams->apellido === ""){
            $ok = false;
            $objResponse->msg .= "apellido, ";
        }

        if($jsonParams->legajo === ""){
            $ok = false;
            $objResponse->msg .= "legajo, ";
        }

        if($jsonParams->clave === ""){
            $ok = false;
            $objResponse->msg .= "clave, ";
        }

        if($jsonParams->sueldo === ""){
            $ok = false;
            $objResponse->msg .= "sueldo, ";
        }

        if($ok){
            $res = $next($req, $res);
        } else{
            $objResponse->msg = substr($objResponse->msg, 0 , (strlen($objResponse->msg) -2));
            $res = $res->withJson($objResponse, 403);
        }
        return $res;
    }

    public static function VerificarToken($req, $res, $next){

        $token = $req->getHeaders()["HTTP_TOKEN"];
        $objResponse = AutenticadorJWT::VerificarToken($token[0]);
        if($objResponse->exito){
            $res = $next($req, $res);
        } else{
            $res = $res->withJson($objResponse, 200);
        }

        return $res;
    }
}

?>