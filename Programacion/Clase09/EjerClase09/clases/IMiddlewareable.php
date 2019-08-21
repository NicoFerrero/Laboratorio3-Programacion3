<?php

interface IMiddlewareable{
    public function VerificarUsuario($req, $res, $next);
}

?>