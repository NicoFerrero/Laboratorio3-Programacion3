<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once 'vendor/autoload.php';
require_once 'clases/EmpleadoApi.php';
require_once 'clases/LoginAPI.php';
require_once 'clases/Middleware.php';

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

//*********************************************************************************************//
//INICIALIZO EL APIREST
//*********************************************************************************************//
$app = new \Slim\App(["settings" => $config]);

$app->group('/empleados', function(){

  $this->get("/login", \LoginApi::class . "::Ingresar");

  $this->get("/verificar", \LoginApi::class . "::Verificar");

  $this->get('/{id}', \EmpleadoApi::class . ':TraerUno');

  $this->get('[/]', \EmpleadoApi::class . ':TraerTodos');

  $this->post('[/]', \EmpleadoApi::class . ':InsertarUno')->add(\Middleware::class . '::VerificarLegajo')->add(\Middleware::class . '::VerificarCampos');

  $this->post('/modificar', \EmpleadoApi::class . ':ModificarUno')->add(\Middleware::class . '::VerificarToken');

  $this->delete('/{id}', \EmpleadoApi::class . ':BorrarUno')->add(\Middleware::class . '::VerificarToken');
});

$app->run();