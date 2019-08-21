<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './vendor/autoload.php';
require_once "./clases/Test.php";
require_once "./clases/Usuario.php";
require_once "./clases/Verificadora.php";

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

$mdwUno = function($req, $res, $next){
    $esAdmin = false;

    if($req->isGet()){
        $res->getBody()->write("Entro a Middleware 1 por GET<br>");
    } else if($req->isPost()){
        $res->getBody()->write("Entro a Middleware 1 por POST<br>");
        $arrayParametros = $req->getParsedBody();
        $tipo = $arrayParametros["tipo"];
        $nombre = $arrayParametros["nombre"];
        if($tipo === "admin"){
            $esAdmin = true;
            $res->getBody()->write("tipo: {$tipo} nombre: {$nombre}<br>");
        } else{
            $res->getBody()->write("No tiene permiso para esta ruta<br>");
        }
    }

    if($esAdmin || $req->isGet()){
        $res = $next($req, $res);
        $res->getBody()->write("Salgo de Middleware 1<br>");
    }
    return $res;
};

$app->group('/credenciales', function(){
    $this->get('[/]', function($req, $res, $args){
        $res->getBody()->write("Estoy en /credenciales GET<br>");
    });

    $this->post('[/]', function($req, $res, $args){
        $res->getBody()->write("Estoy en /credenciales POST<br>");
    });
})->add($mdwUno)->add(\Test::class . ':Instancia')->add(\Test::class . '::Estatico');

/*****************************************************************************************/

$app->group('/poo', function(){

    /*$mdwEscribir = function($req, $res, $next){
        $arrayParametros = $req->getParsedBody();
        $tipo = $arrayParametros["tipo"];
        $nombre = $arrayParametros["nombre"];
        $usuario = new Usuario();
        $usuario->tipo = $tipo;
        $usuario->nombre = $nombre;
        $archivo = fopen("./archivos/usuarios.txt", "a");
        fwrite($archivo, $usuario->ToString() . "\r\n");
        fclose($archivo);
        return $next($req, $res);
    };

    $mdwTabla = function($req, $res, $next){
        $archivo = fopen("./archivos/usuarios.txt", "r");
        $arrayUsuarios = array();
        while(!feof($archivo)){
            $linea = trim(fgets($archivo));
            if($linea == ""){
                continue;
            }
            $usuarioAux = explode("-", $linea);
            $usuario = new Usuario();
            $usuario->tipo = $usuarioAux[0];
            $usuario->nombre = $usuarioAux[1];
            array_push($arrayUsuarios, $usuario);
        }
        fclose($archivo); 
        $res = $next($req, $res);
        return $res->withJson($arrayUsuarios, 200);  
    };*/

    $this->get('[/]', function($req, $res, $args){
        $archivo = fopen("./archivos/usuarios.txt", "r");
        $arrayUsuarios = array();
        while(!feof($archivo)){
            $linea = trim(fgets($archivo));
            if($linea == ""){
                continue;
            }
            $usuarioAux = explode("-", $linea);
            $usuario = new Usuario();
            $usuario->tipo = $usuarioAux[0];
            $usuario->nombre = $usuarioAux[1];
            array_push($arrayUsuarios, $usuario);
        }
        fclose($archivo); 
        return $res->withJson($arrayUsuarios, 200); 
    });

    $this->post('[/]', function($req, $res, $args){
        $arrayParametros = $req->getParsedBody();
        $tipo = $arrayParametros["tipo"];
        $nombre = $arrayParametros["nombre"];
        $usuario = new Usuario();
        $usuario->tipo = $tipo;
        $usuario->nombre = $nombre;
        $archivo = fopen("./archivos/usuarios.txt", "a");
        fwrite($archivo, $usuario->ToString() . "\r\n");
        fclose($archivo);
    });
})->add(\Verificadora::class . ':VerificarUsuario');

$app->run();