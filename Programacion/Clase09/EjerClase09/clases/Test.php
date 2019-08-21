<?php

class Test{
    public function Instancia($req, $res, $next){
        $res->getBody()->write("Entro en metodo de instancia<br>");
        $next($req, $res);
        $res->getBody()->write("Salgo de metodo de instancia<br>");
        return $res;
    }

    public static function Estatico($req, $res, $next){
        $res->getBody()->write("Entro en metodo estatico<br>");
        $next($req, $res);
        $res->getBody()->write("Salgo de metodo estatico<br>");
        return $res;
    }
}

?>