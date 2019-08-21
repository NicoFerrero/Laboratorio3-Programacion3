<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Firebase\JWT\JWT as JWT;

require_once './vendor/autoload.php';
require_once 'clases/Usuario.php';
require_once 'clases/Middleware.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

$app->get('/', function(Request $req, Response $res, Array $args){
    $res->getBody()->write("GET");
    return $res;
});

$app->post('/', function(Request $req, Response $res, Array $args){
    $res->getBody()->write("POST");
    return $res;
});

$app->put('/', function(Request $req, Response $res, Array $args){
    $res->getBody()->write("PUT");
    return $res;
});

$app->delete('/', function(Request $req, Response $res, Array $args){
    $res->getBody()->write("DELETE");
    return $res;
});

/******************************************************************************/

$app->post("/crear", function(Request $req, Response $res, Array $args){
    $arrayParametros = $req->getParsedBody();   
    $ahora = time();
    $payload = array(
        'data' => $arrayParametros,
        'iat' => $ahora,
        'exp' => $ahora + 60
    );
    $token = JWT::encode($payload, "miClaveSuperSecreta");
    return $res->withJson($token, 200);
});

$app->post("/verificar", function(Request $req, Response $res, Array $args){
    $arrayParametros = $req->getParsedBody();   
    if(empty($arrayParametros["token"]) ||$arrayParametros["token"] === ""){
        throw new Exception("Token vacio");
    }
    try{
        $token = JWT::decode($arrayParametros["token"], "miClaveSuperSecreta", ["HS256"]);
    } catch(Exception $e){ 
        throw new Exception("Token no valido " . $e->getMessage());
    }
    $res->getBody()->write("Todo ok");
    return $res;
});

$app->post("/obtenerPayload", function(Request $req, Response $res, Array $args){
    $arrayParametros = $req->getParsedBody();   
    if(empty($arrayParametros["token"]) ||$arrayParametros["token"] === ""){
        throw new Exception("Token vacio");
    }
    try{
        $token = JWT::decode($arrayParametros["token"], "miClaveSuperSecreta", ["HS256"]);
    } catch(Exception $e){ 
        throw new Exception("Token no valido " . $e->getMessage());
    }
    //return $res->withJson($token, 200); TODA LA INFO DE PAYLOAD
    return $res->withJson($token->data, 200); //SOLO LA INFO QUE LE AGREGUE AL PAYLOAD
});

$app->group("/jwt", function(){
    $this->post("[/]", function(Request $req, Response $res, Array $args){
        $arrayParametros = $req->getParsedBody();  
        $newResponse = null;
        $usuario = new Usuario();
        $usuario->nombre = $arrayParametros["nombre"];
        $usuario->apellido = $arrayParametros["apellido"];
        $usuario->division = $arrayParametros["division"];
        if(Usuario::Verificar($usuario)){
            $ahora = time();
            $payload = array(
                'data' => $arrayParametros,
                'iat' => $ahora,
                'exp' => $ahora + 10
            );
            $token = JWT::encode($payload, "miClaveSuperSecreta");
            $newResponse = $res->withJson($token, 200);
        } else{
            $objResponse = new stdClass();
            $objResponse->exito = false;
            $objResponse->msg = "El usuario no existe";
            $newResponse = $res->withJson($objResponse, 409);
        }
        return $newResponse;
    })->add(\Middleware::class . '::VerificarCamposVacios')->add(\Middleware::class . '::VerificarCamposExisten');

    $this->post("/mostrar", function(Request $req, Response $res, Array $args){
        $arrayParametros = $req->getParsedBody();   
        $newResponse = null;
        if(empty($arrayParametros["token"]) ||$arrayParametros["token"] === ""){
            throw new Exception("Token vacio");
        }
        try{
            $token = JWT::decode($arrayParametros["token"], "miClaveSuperSecreta", ["HS256"]);
            $newResponse = $res->getBody()->write(Usuario::TraerListado());
        } catch(Exception $e){ 
            $objResponse = new stdClass();
            $objResponse->exito = false;
            $objResponse->msg = "Error: " . $e->getMessage();
            $newResponse = $res->withJson($objResponse, 409);
        }
        return $newResponse;
    });
});

$app->run();