<?php

require_once 'AccesoDatos.php';

class Media{

    public $id;
    public $color;
    public $marca;
    public $precio;
    public $talle;

    protected static function TraerMedia($id){
        $objetoAcceso = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoAcceso->RetornarConsulta("SELECT * FROM medias WHERE id = :id");
        $consulta->bindValue(':id', $id);
        $consulta->setFetchMode(PDO::FETCH_CLASS, "Media");
        $consulta->execute();
        return $consulta->fetch();
    }

    protected static function TraerMedias(){
        $objetoAcceso = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoAcceso->RetornarConsulta("SELECT * FROM medias");
        $consulta->setFetchMode(PDO::FETCH_CLASS, "Media");
        $consulta->execute();
        return $consulta->fetchAll();
    }

    protected function InsertarMedia(){
        $objetoAcceso = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoAcceso->RetornarConsulta("INSERT INTO medias (color, marca, precio, talle) VALUES (:color, :marca, :precio, :talle)");
        $consulta->bindValue(':color', $this->color);
        $consulta->bindValue(':marca', $this->marca);
        $consulta->bindValue(':precio', $this->precio);
        $consulta->bindValue(':talle', $this->talle);
        $consulta->execute();
        return $consulta->rowCount();
    }

    protected function BorrarMedia(){
        $objetoAcceso = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoAcceso->RetornarConsulta("DELETE FROM medias WHERE id=:id");
        $consulta->bindValue(':id', $this->id);
        $consulta->execute();
        return $consulta->rowCount();
    }

    protected function ModificarMedia(){
        $objetoAcceso = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoAcceso->RetornarConsulta("UPDATE medias SET color=:color, marca=:marca, precio=:precio, talle=:talle WHERE id=:id");
        $consulta->bindValue(':id', $this->id);
        $consulta->bindValue(':color', $this->color);
        $consulta->bindValue(':marca', $this->marca);
        $consulta->bindValue(':precio', $this->precio);
        $consulta->bindValue(':talle', $this->talle);
        $consulta->execute();
        return $consulta->rowCount();
    }
}

?>