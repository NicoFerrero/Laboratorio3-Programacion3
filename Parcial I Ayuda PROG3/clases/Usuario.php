<?php

class Usuario{
    private $_email;
    private $_clave;

    public function __construct($email, $clave){
        $this->_email = $email;
        $this->_clave = $clave;
    }

    public function ToJSON(){
        $aux = new stdClass();
        $aux->email = $this->_email;
        $aux->clave = $this->_clave;
        return json_encode($aux);
    }

    public function GuardarEnArchivo(){
        $rta = new stdClass();
        $rta->exito = false;
        $rta->msg = "No se pudo guardar en usuario en el archivo";

        if(!file_exists("./archivos/usuarios.json")){
            $archivo = fopen("./archivos/usuarios.json", "w");
        }else {
            $archivo = fopen("./archivos/usuarios.json", "a");
        }

        if($this->_email != "" && $this->_clave != ""){
            $cant = fwrite($archivo, $this->ToJSON() . "\r\n");
            fclose($archivo);

            if($cant > 0){
                $rta->exito = true;
                $rta->msg = "El usuario se guardo con exito";
            }
        }

        return $rta;
    }

    public static function TraerTodos(){
        $usuarios = array();

        if(!file_exists("./archivos/usuarios.json")){
            $archivo = fopen("./archivos/usuarios.json", "w");
        }else {
            $archivo = fopen("./archivos/usuarios.json", "r");
            while(!feof($archivo)){
                $linea = trim(fgets($archivo));
                if($linea == ""){
                    continue;
                }
                $usuarioJSON = json_decode($linea);
                $usuario = new Usuario($usuarioJSON->email, $usuarioJSON->clave);
                array_push($usuarios, $usuario);
            }
        }
        fclose($archivo);

        return $usuarios;
    }

    public static function VerificarExistencia($usuario){
        $rta = false;
        $usuarios = Usuario::TraerTodos();

        foreach ($usuarios as $usuarioAux) {
            if(strcmp($usuarioAux->ToJSON(), $usuario->ToJSON()) == 0){
                $rta = true;
                break;
            }
        }

        return $rta;
    }
}

?>