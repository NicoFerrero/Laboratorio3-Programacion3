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
            $objResponse->exito = false;
            $objResponse->msg = substr($objResponse->msg, 0 , (strlen($objResponse->msg) -2));
            $res = $res->withJson($objResponse, 403);
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
            $objResponse->exito = false;
            $objResponse->msg = substr($objResponse->msg, 0 , (strlen($objResponse->msg) -2));
            $res = $res->withJson($objResponse, 403);
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
            $objResponse->exito = false;
            $objResponse->msg = "El usuario no existe";
            $res = $res->withJson($objResponse, 403);
        }
        return $res;
    }

    public static function VerificarCorreo($req, $res, $next){
        $params = $req->getParsedBody();
        $jsonParams = json_decode($params["datos"]);
        if(!Usuario::ExisteCorreo($jsonParams->correo)){
            $res = $next($req, $res);
        } else{
            $objResponse = new stdClass();
            $objResponse->exito = false;
            $objResponse->msg = "El correo ya existe";
            $res = $res->withJson($objResponse, 403);
        }
        return $res;
    }

    public static function VerificarPrecio($req, $res, $next){
        $params = $req->getParsedBody();
        $jsonParams = json_decode($params["datos"]);
        $okPrecio = true;
        $okColor = true;
        $objResponse = new stdClass();
        $objResponse->msg = "Los siguientes campos no son correctos: ";

        if($jsonParams->precio <= 50000 || $jsonParams->precio >= 600000){
            $okPrecio = false;
            $objResponse->msg .= "precio, ";
        }

        if($jsonParams->color === "azul"){
            $okColor = false;
            $objResponse->msg .= "color, ";
        }

        if($okColor === true && $okPrecio === true){
            $res = $next($req, $res);
        } else{
            $objResponse->exito = false;
            $objResponse->msg = substr($objResponse->msg, 0 , (strlen($objResponse->msg) -2));
            $res = $res->withJson($objResponse, 403);
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
            $objResponse->exito = false;
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
            $objResponse->exito = false;
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
            $res = $res->withJson($objResponse, 403);
        }
        return $res;
    }

    public function ListadosAutos($req, $res, $next){
        $res = $next($req, $res);
        $token = $req->getHeaders()["HTTP_TOKEN"];
        $datos = AutenticadorJWT::ObtenerData($token[0]);
        $streamBody = $res->getBody();
        $streamBody->rewind();
        $content = $streamBody->read($streamBody->getSize());

        if($datos->perfil === "encargado"){
            $autos = array();
            foreach(json_decode($content)->autos as $auto){
                $objResponse = new stdClass();
                $objResponse->color = $auto->color;
                $objResponse->marca = $auto->marca;
                $objResponse->precio = $auto->precio;
                $objResponse->modelo = $auto->modelo;
                array_push($autos, $objResponse);
            }
            $res = $res->withJson($autos, 200);

        } else if($datos->perfil === "empleado"){
            $autos = array();
            $objResponse = array();
            foreach(json_decode($content)->autos as $auto){
                if($objResponse[$auto->color] === null){
                    $objResponse[$auto->color] = 1;
                } else{
                    $objResponse[$auto->color]++;
                }
            }
            array_push($autos, $objResponse);
            $res = $res->withJson($autos, 200);
        }

        return $res;
    }

    public function ListadosUsuarios($req, $res, $next){
        $res = $next($req, $res);
        $token = $req->getHeaders()["HTTP_TOKEN"];
        $datos = AutenticadorJWT::ObtenerData($token[0]);
        $streamBody = $res->getBody();
        $streamBody->rewind();
        $content = $streamBody->read($streamBody->getSize());

        if($datos->perfil === "encargado"){
            $usuarios = array();
            foreach(json_decode($content)->usuarios as $usuario){
                $objResponse = new stdClass();
                $objResponse->correo = $usuario->correo;
                $objResponse->nombre = $usuario->nombre;
                $objResponse->apellido = $usuario->apellido;
                $objResponse->foto = $usuario->foto;
                array_push($usuarios, $objResponse);
            }
            $res = $res->withJson($usuarios, 200);

        } else if($datos->perfil === "empleado"){
            $usuarios = array();
            foreach(json_decode($content)->usuarios as $usuario){
                $objResponse = new stdClass();
                $objResponse->nombre = $usuario->nombre;
                $objResponse->apellido = $usuario->apellido;
                $objResponse->foto = $usuario->foto;
                array_push($usuarios, $objResponse);
            }
            $res = $res->withJson($usuarios, 200);
        } else{
            $contenido = json_decode($content);
            if($contenido->usuarios === null){
                $usuario = new stdClass();
                $usuario->apellido = $contenido->apellido;
                $usuario->cantidad = $contenido->cantidad;
                $res = $res->withJson($usuario, 200);
            } else{
                $usuarios = array();
                $objResponse = array();
                foreach($contenido->usuarios as $usuario){
                    if($objResponse[$usuario->apellido] === null){
                        $objResponse[$usuario->apellido] = 1;
                    } else{
                        $objResponse[$usuario->apellido]++;
                    }
                }
                array_push($usuarios, $objResponse);
                $res = $res->withJson($usuarios, 200);
            }
        }

        return $res;
    }
}

?>