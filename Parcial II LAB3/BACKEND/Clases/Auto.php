<?php

require_once 'AccesoDatos.php';

class Auto{

    public $id;
    public $color;
    public $marca;
    public $precio;
    public $modelo;

    protected static function TraerAuto($id){
        $objetoAcceso = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoAcceso->RetornarConsulta("SELECT * FROM autos WHERE id = :id");
        $consulta->bindValue(':id', $id);
        $consulta->setFetchMode(PDO::FETCH_CLASS, "Auto");
        $consulta->execute();
        return $consulta->fetch();
    }

    protected static function TraerAutos(){
        $objetoAcceso = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoAcceso->RetornarConsulta("SELECT * FROM autos");
        $consulta->setFetchMode(PDO::FETCH_CLASS, "Auto");
        $consulta->execute();
        return $consulta->fetchAll();
    }

    protected function InsertarAuto(){
        $objetoAcceso = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoAcceso->RetornarConsulta("INSERT INTO autos (color, marca, precio, modelo) VALUES (:color, :marca, :precio, :modelo)");
        $consulta->bindValue(':color', $this->color);
        $consulta->bindValue(':marca', $this->marca);
        $consulta->bindValue(':precio', $this->precio);
        $consulta->bindValue(':modelo', $this->modelo);
        $consulta->execute();
        return $consulta->rowCount();
    }

    protected function BorrarAuto(){
        $objetoAcceso = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoAcceso->RetornarConsulta("DELETE FROM autos WHERE id=:id");
        $consulta->bindValue(':id', $this->id);
        $consulta->execute();
        return $consulta->rowCount();
    }

    protected function ModificarAuto(){
        $objetoAcceso = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoAcceso->RetornarConsulta("UPDATE autos SET color=:color, marca=:marca, precio=:precio, modelo=:modelo WHERE id=:id");
        $consulta->bindValue(':id', $this->id);
        $consulta->bindValue(':color', $this->color);
        $consulta->bindValue(':marca', $this->marca);
        $consulta->bindValue(':precio', $this->precio);
        $consulta->bindValue(':modelo', $this->modelo);
        $consulta->execute();
        return $consulta->rowCount();
    }
}

?>