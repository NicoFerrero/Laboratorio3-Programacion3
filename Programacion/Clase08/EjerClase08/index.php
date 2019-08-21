<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './vendor/autoload.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

/*
¡La primera línea es la más importante! A su vez en el modo de 
desarrollo para obtener información sobre los errores
 (sin él, Slim por lo menos registrar los errores por lo que si está utilizando
  el construido en PHP webserver, entonces usted verá en la salida de la consola 
  que es útil).

  La segunda línea permite al servidor web establecer el encabezado Content-Length, 
  lo que hace que Slim se comporte de manera más predecible.
*/

$app = new \Slim\App(["settings" => $config]);

$app->get('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("GET => Bienvenido!!! a SlimFramework");
    return $response;

});

$app->post('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("POST => Bienvenido!!! a SlimFramework");
    return $response;

});

$app->put('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("PUT => Bienvenido!!! a SlimFramework");
    return $response;

});

$app->delete('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("DELETE => Bienvenido!!! a SlimFramework");
    return $response;

});

//ruta propia
$app->get('/saludar', function (Request $request, Response $response) {    
    $response->getBody()->write("Hola mundo slim");
    return $response;

});

//ruta con parametros
$app->get('/mostrar/{nombre}', function (Request $request, Response $response, $args){
    $nombre = $args['nombre'];
    $response->getBody()->write("Hola " . strtoupper($nombre));
    return $response;
});

//traer datos por post
$app->post('/mostrar', function (Request $request, Response $response){
    $datos = $request->getParsedBody();
    $obj = new stdClass();
    $obj->nombre = $datos['nombre'];
    $obj->apellido = $datos['apellido'];
    $obj->id = rand();
    $newResponse = $response->withJson($obj, 200);
    return $newResponse;
});

$app->post('/json', function (Request $request, Response $response){
    $datos = $request->getParsedBody();
    $obj = json_decode($datos['datos']);
    $newResponse = $response->withJson($obj, 200);
    return $newResponse;
});

$app->run();