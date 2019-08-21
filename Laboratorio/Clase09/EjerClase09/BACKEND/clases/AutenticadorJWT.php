<?php

use Firebase\JWT\JWT;

class AutenticadorJWT{
    private static $miClaveSecreta = '0mb4ussb';
    private static $tipoEncriptacion = ['HS256'];
    private static $aud = null;

    public static function CrearToken($datos)
    {
        $ahora = time();
        $payload = array(
              'iat'=>$ahora,
              'exp' => $ahora + 60,
              //'aud' => self::Aud(),
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
            $objResponse->tipo = "token";
        } else{
            try {
                $decodificado = JWT::decode($token, self::$miClaveSecreta, self::$tipoEncriptacion);
                $objResponse->exito = true;
            } catch (Exception $e) {
                $objResponse->exito = false;
                $objResponse->msg = "El token no es valido";
                $objResponse->tipo = "token";
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