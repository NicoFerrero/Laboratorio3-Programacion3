<?php

require_once "AccesoDatos.php";

class Usuario{
    public $id;
    public $correo;
    public $clave;
    public $nombre;
    public $apellido;
    public $perfil;

    protected static function TraerUsuario($id){
        $objetoAcceso = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoAcceso->RetornarConsulta("SELECT * FROM usuarios WHERE id = :id");
        $consulta->bindValue(':id', $id);
        $consulta->setFetchMode(PDO::FETCH_CLASS, "Usuario");
        $consulta->execute();
        return $consulta->fetch();
    }

    protected function TraerUsuarios(){
        $objetoAcceso = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoAcceso->RetornarConsulta("SELECT * FROM usuarios");
        $consulta->setFetchMode(PDO::FETCH_CLASS, "Usuario");
        $consulta->execute();
        return $consulta->fetchAll();
    }

    protected function InserUsuario(){
        $objetoAcceso = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoAcceso->RetornarConsulta("INSERT INTO usuarios (correo, clave, nombre, apellido, perfil) VALUES(:correo, :clave, :nombre, :apellido, :perfil)");
        $consulta->bindValue(':correo', $this->correo);
        $consulta->bindValue(':clave', $this->clave);
        $consulta->bindValue(':nombre', $this->nombre);
        $consulta->bindValue(':apellido', $this->apellido);
        $consulta->bindValue(':perfil', $this->perfil);
        $consulta->execute();
        return $consulta->rowCount();
    }

    protected function BorrarUsuario(){
        $objetoAcceso = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoAcceso->RetornarConsulta("DELETE FROM usuarios WHERE id=:id");
        $consulta->bindValue(':id', $this->id);
        $consulta->execute();
        return $consulta->rowCount();
    }

    protected function ModificarUsuario(){
        $objetoAcceso = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoAcceso->RetornarConsulta("UPDATE usuarios SET correo=:correo, clave=:clave, nombre=:nombre, apellido=:apellido, perfil=:perfil WHERE id=:id");
        $consulta->bindValue(':id', $this->id);
        $consulta->bindValue(':correo', $this->correo);
        $consulta->bindValue(':clave', $this->clave);
        $consulta->bindValue(':nombre', $this->nombre);
        $consulta->bindValue(':apellido', $this->apellido);
        $consulta->bindValue(':perfil', $this->perfil);
        $consulta->execute();
        return $consulta->rowCount();
    }
}

?>