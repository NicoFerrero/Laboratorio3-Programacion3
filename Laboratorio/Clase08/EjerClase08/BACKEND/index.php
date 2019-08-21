<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './vendor/autoload.php';
require_once './AccesoDatos.php';

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

$app->get("/login", function($req, $res, $args){
    $legajo = $_GET["legajo"];
    $clave = $_GET["clave"];
    $objetoAcceso = AccesoDatos::ObtenerObjetoAcceso();
    $consulta = $objetoAcceso->RetornarConsulta("SELECT * FROM empleados WHERE legajo = :legajo AND clave = :clave");
    $consulta->bindValue(':legajo', $legajo);
    $consulta->bindValue(':clave', $clave);
    $consulta->setFetchMode(PDO::FETCH_ASSOC);
    $consulta->execute();
    $empleadoBD = $consulta->fetch();
    $objResponse = new stdClass();
    if($empleadoBD != null){
        $empleado = new stdClass();
        $empleado->legajo = $empleadoBD["legajo"];
        $empleado->clave = $empleadoBD["clave"];
        $objResponse->exito = true;
        $objResponse->objEmpleado = $empleado;
    } else{
        $objResponse->exito = false;
        $objResponse->objEmpleado = null;
    }
    $newResponse = $res->withJson($objResponse, 200);
    return $newResponse;
});


$app->run();