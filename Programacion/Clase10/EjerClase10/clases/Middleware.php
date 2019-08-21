<?php

class Middleware{

    private static $campos = array("nombre", "apellido", "division");

    public static function VerificarCamposExisten($req, $res, $next){
        $arrayParametros = $req->getParsedBody();
        $newResponse = null;
        $ok = true;
        $objResponse = new stdClass();
        $objResponse->msg = "Se deben setear los siguientes campos: ";

        foreach(self::$campos as $campo){
            if(!isset($arrayParametros[$campo])){
                $objResponse->msg .= $campo . ", ";
                $ok = false;
            }
        }

        if($ok){
            $newResponse = $next($req, $res);
        } else{
            $objResponse->exito = false;
            $objResponse->msg = substr($objResponse->msg, 0 , (strlen($objResponse->msg) -2));
            $newResponse = $res->withJson($objResponse, 409);
        }
        return $newResponse;
    }   

    public static function VerificarCamposVacios($req, $res, $next){
        $arrayParametros = $req->getParsedBody();
        $newResponse = null;
        $ok = true;
        $objResponse = new stdClass();
        $objResponse->msg = "Los siguientes campos estan vacios: ";

        foreach(self::$campos as $campo){
            if($arrayParametros[$campo] === ""){
                $objResponse->msg .= $campo . ", ";
                $ok = false;
            }
        }

        if($ok){
            $newResponse = $next($req, $res);
        } else{
            $objResponse->exito = false;
            $objResponse->msg = substr($objResponse->msg, 0 , (strlen($objResponse->msg) -2));
            $newResponse = $res->withJson($objResponse, 409);
        }
        return $newResponse;
    }   
}

?>