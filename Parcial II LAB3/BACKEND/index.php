<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './vendor/autoload.php';
require_once './Clases/UsuarioApi.php';
require_once './Clases/AutoApi.php';
require_once './Clases/LoginApi.php';
require_once './Clases/MW.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

$app->group("/usuarios", function(){
    $this->post("/", \UsuarioApi::class . ":InsertarUno")->add(\MW::class . "::VerificarCorreo")->add(\MW::class . "::CamposVacios")->add(\MW::class . ":CamposSeteados");
    $this->delete("/", \UsuarioApi::class . ":BorrarUno")->add(\MW::class . "::VerificarPropietario")->add(\MW::class . ":VerificarToken");
    $this->post("/modificar", \UsuarioApi::class . ":ModificarUno")->add(\MW::class . "::VerificarEncargado")->add(\MW::class . ":VerificarToken");
});

$app->get("/[{apellido}]", \UsuarioApi::class . ":TraerTodos")/*->add(\MW::class . ":ListadosUsuarios")*/;


$app->post("/", \AutoApi::class . ":InsertarUno")->add(\MW::class . "::VerificarPrecio");

$app->group("/autos", function(){
    $this->get("/[{id}]", \AutoApi::class . ":TraerTodos")/*->add(\MW::class . ":ListadosAutos")*/;
});

$app->delete("/", \AutoApi::class . ":BorrarUno")->add(\MW::class . "::VerificarPropietario")->add(\MW::class . ":VerificarToken");

$app->post("/modificar", \AutoApi::class . ":ModificarUno")->add(\MW::class . ":VerificarEncargado")->add(\MW::class . ":VerificarToken");


$app->group("/login", function(){
    $this->post("/", \LoginApi::class . ":Ingresar")->add(\MW::class . ":VerificarUsuario")->add(\MW::class . "::CamposVacios")->add(\MW::class . ":CamposSeteados");

    $this->get("/", \LoginApi::class . ":Verificar");
});

$app->run();