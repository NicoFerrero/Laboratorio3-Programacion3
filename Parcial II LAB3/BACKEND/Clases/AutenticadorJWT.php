<?php

use Firebase\JWT\JWT;

class AutenticadorJWT{
    private static $miClaveSecreta = 'claveSecreta';
    private static $tipoEncriptacion = ['HS256'];

    public static function CrearToken($datos)
    {
        $ahora = time();
        $payload = array(
              'iat'=>$ahora,
              'exp' =>$ahora + 15,
              'data' => $datos
          );

        return JWT::encode($payload, self::$miClaveSecreta);
    }

    public static function VerificarToken($token)
    {
        $objResponse = new stdClass();

        if (empty($token)|| $token=="") {
            $objResponse->exito = false;
            $objResponse->msg = "El token esta vacio o no existe";
        } else{
            try {
                $decodificado = JWT::decode($token, self::$miClaveSecreta, self::$tipoEncriptacion);
                $objResponse->exito = true;
                $objResponse->msg = "token valido";
            } catch (Exception $e) {
                $objResponse->exito = false;
                $objResponse->msg = "El token no es valido";
            }
        }

        return $objResponse;
    }

    public static function ObtenerPayLoad($token)
    {
        return JWT::decode($token, self::$miClaveSecreta, self::$tipoEncriptacion);
    }

    public static function ObtenerData($token)
    {
        $payload = AutenticadorJWT::ObtenerPayLoad($token);
        return $payload->data;
    }
}

?>