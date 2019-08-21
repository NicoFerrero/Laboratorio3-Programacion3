<?php

class Usuario{
    
    public static function Verificar($user){
        $usuarios = Usuario::TraerTodos();
        $rta = false;
        foreach($usuarios as $usuario){
            $usuarioAux = json_decode($usuario);
            if($user->nombre === $usuarioAux->nombre && $user->apellido === $usuarioAux->apellido){
                $rta = true;
                break;
            } 
        }
        return $rta;
    }

    private static function TraerTodos(){
        return array(
            '{"nombre":"aaa", "apellido":"aaa", "division":"1a"}',
            '{"nombre":"bbb", "apellido":"bbb", "division":"2a"}',
            '{"nombre":"ccc", "apellido":"ccc", "division":"3a"}',
        );
    }

    public static function TraerListado(){
        $usuarios = Usuario::TraerTodos();
        $tabla = '<table border="1"><thead><th>Nombre</th><th>Apellido</th><th>Division</th></thead><tbody>';
        foreach($usuarios as $usuario){
            $usuarioAux = json_decode($usuario);
            $tabla .= "<tr><td>{$usuarioAux->nombre}</td><td>{$usuarioAux->apellido}</td><td>{$usuarioAux->division}</td></tr>";
        } 
        $tabla .= "</tbody></table>";
        return $tabla;
    }
}

?>