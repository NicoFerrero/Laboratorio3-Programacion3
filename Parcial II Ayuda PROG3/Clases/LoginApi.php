<?php

require_once "Usuario.php";
require_once "AutenticadorJWT.php";

class LoginApi extends Usuario{
    public static function Ingresar($req, $res, $args)
    {
        $params = $req->getParsedBody();
        $jsonParams = json_decode($params["datos"]);
        $usuario = Usuario::ExisteUsuario($jsonParams->correo, $jsonParams->clave);
        $objResponse = new stdClass();

        try {
            $datos = array(
                'correo' => $usuario->correo,
                'clave' => $usuario->clave,
                'perfil' => $usuario->perfil
            );

            $token = AutenticadorJWT::CrearToken($datos);
            $objResponse->exito = true;
            $objResponse->token = $token;
        } catch (Exception $e) {
            $objResponse->exito = false;
            $objResponse->msg = "no se ha creado el token";
        }

        return $res->withJson($objResponse, 200);
    }

    public static function Verificar($req, $res, $args){
        $token = $req->getHeaders()["HTTP_TOKEN"];
        $objResponse = AutenticadorJWT::VerificarToken($token[0]);
        if($objResponse->exito){
            $res = $res->withJson($objResponse, 200);
        } else{
            $res = $res->withJson($objResponse, 409);
        }
        return $res;
    }
}

?>