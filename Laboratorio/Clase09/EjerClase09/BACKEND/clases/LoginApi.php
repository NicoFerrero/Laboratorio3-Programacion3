<?php

require_once "Empleado.php";
require_once "AutenticadorJWT.php";

class LoginApi extends Empleado{
    public static function Ingresar($req, $res, $args)
    {
        $legajo = $_GET["legajo"];
        $clave = $_GET["clave"];

        $objResponse = new stdClass();

        try {
            $empleado = Empleado::LoginEmpleado($legajo, $clave);

            if($empleado){
                $datos = array(
                    'legajo' => $empleado->legajo,
                    'clave' => $empleado->clave
                );

                $token = AutenticadorJWT::CrearToken($datos);
                $objResponse->exito = true;
                $objResponse->token = $token;
            }
            else {
                $objResponse->error = "El empleado no existe";
                $objResponse->exito = false;
            }

        } catch (Exception $e) {
            echo($e->getMessage());
        }

        return $res->withJson($objResponse, 200);
    }

    public static function Verificar($req, $res, $args){
        $token = $req->getHeaders()["HTTP_TOKEN"];
        $objResponse = AutenticadorJWT::VerificarToken($token[0]);

        return $res->withJson($objResponse, 200);
    }
}

?>