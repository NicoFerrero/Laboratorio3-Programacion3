<?php

class Usuario{
    public $tipo;
    public $nombre;

    public function ToString(){
        return $this->tipo . "-" . $this->nombre;
    }
}

?>