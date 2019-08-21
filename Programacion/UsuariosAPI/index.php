<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './vendor/autoload.php';
require_once "clases/UsuarioApi.php";

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

$app->group('/usuarios', function(){
    $this->get('/{id}', \UsuarioApi::class . '::TraerUno');

    $this->get('[/]', \UsuarioApi::class . '::TraerTodos');

    $this->post('[/]', \UsuarioApi::class . '::InsertarUno');

    $this->post('/modificar', \UsuarioApi::class . '::ModificarUno');

    $this->delete('/{id}', \UsuarioApi::class . '::BorrarUno');
});

$app->run();