<?php

require_once "IMiddlewareable.php";

class Verificadora implements IMiddlewareable{
    
    public function VerificarUsuario($req, $res, $next){
        $objResponse = new stdClass();

        if($req->isGet()){
            $res->getBody()->write("Entro a Middleware 1 por GET<br>");
            $res = $next($req, $res);
            $res->getBody()->write("Salgo de Middleware 1<br>");
        } else if($req->isPost()){
            $arrayParametros = $req->getParsedBody();
            $tipo = $arrayParametros["tipo"];
            $nombre = $arrayParametros["nombre"];
            if($tipo === "admin"){
                $objResponse->exito = true;
                $objResponse->msg = "Bienvendido {$nombre}";
                $objResponse->status = 200;
                $res = $next($req, $res);
            } else{
                $objResponse->exito = false;
                $objResponse->msg = "No tiene acceso";
                $objResponse->status = 403;
            }
            $res = $res->withJson($objResponse, $objResponse->status);
        }

        return $res;
    }
}

?>