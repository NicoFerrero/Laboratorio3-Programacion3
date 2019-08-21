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
        $newResponse = null;

        try {
            $datos = array(
                'correo' => $usuario->correo,
                'clave' => $usuario->clave,
                'perfil' => $usuario->perfil,
                'nombre' => $usuario->nombre,
                'apellido' => $usuario->apellido,
                'id' => $usuario->id,
                'foto' => $usuario->foto,
            );

            $token = AutenticadorJWT::CrearToken($datos);
            $objResponse->exito = true;
            $objResponse->jwt = $token;
            $newResponse = $res->withJson($objResponse, 200);
        } catch (Exception $e) {
            $objResponse->exito = false;
            $objResponse->jwt = null;
            $newResponse = $res->withJson($objResponse, 424);
        }

        return $newResponse;
    }

    public static function Verificar($req, $res, $args){
        $token = $req->getHeaders()["HTTP_TOKEN"];
        $objResponse = AutenticadorJWT::VerificarToken($token[0]);
        if($objResponse->exito){
            $res = $res->withJson($objResponse, 200);
        } else{
            $res = $res->withJson($objResponse, 403);
        }
        return $res;
    }
}

?>