<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './vendor/autoload.php';

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

$app->run();