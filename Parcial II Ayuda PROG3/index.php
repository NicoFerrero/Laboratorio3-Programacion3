<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './vendor/autoload.php';
require_once './Clases/MediaApi.php';
require_once './Clases/UsuarioApi.php';
require_once './Clases/LoginApi.php';
require_once './Clases/MW.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

/* MEDIAS */
$app->post("/", \MediaApi::class . ":InsertarUno");

$app->get("/medias", \MediaApi::class . ":TraerTodos");

$app->delete("/", \MediaApi::class . ":BorrarUno")->add(\MW::class . "::VerificarPropietario")->add(\MW::class . ":VerificarToken");

$app->put("/", \MediaApi::class . ":ModificarUno")->add(\MW::class . "::VerificarEncargado")->add(\MW::class . ":VerificarToken");

/* USUARIOS */
$app->post("/usuarios", \UsuarioApi::class . ":InsertarUno");

$app->get("/", \UsuarioApi::class . ":TraerTodos");

/* LOGIN */
$app->group("/login", function(){

    $this->post("/", \LoginApi::class . ":Ingresar")->add(\MW::class . ":VerificarUsuario")->add(\MW::class . "::CamposVacios")->add(\MW::class . ":CamposSeteados");

    $this->get("/", \LoginApi::class . ":Verificar");
});

$app->group("/listado", function(){
    $this->get("/[{id}]", \MediaApi::class . ":TraerTodos")->add(\MW::class . "::Listados");
});

$app->run();