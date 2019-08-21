<?php

require_once 'AccesoDatos.php';

class Usuario{

    public $id;
    public $correo;
    public $clave;
    public $nombre;
    public $apellido;
    public $perfil;
    public $foto;

    protected static function ExisteUsuario($correo, $clave){
        $objetoAcceso = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoAcceso->RetornarConsulta("SELECT * FROM usuarios WHERE correo = :correo AND clave = :clave");
        $consulta->bindValue(':correo', $correo);
        $consulta->bindValue(':clave', $clave);
        $consulta->setFetchMode(PDO::FETCH_CLASS, "Usuario");
        $consulta->execute();
        return $consulta->fetch();
    }

    protected static function ExisteCorreo($correo){
        $objetoAcceso = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoAcceso->RetornarConsulta("SELECT * FROM usuarios WHERE correo = :correo");
        $consulta->bindValue(':correo', $correo);
        $consulta->setFetchMode(PDO::FETCH_CLASS, "Usuario");
        $consulta->execute();
        return $consulta->fetch();
    }

    protected static function TraerUsuario($apellido){
        $objetoAcceso = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoAcceso->RetornarConsulta("SELECT COUNT(*) AS cantidad, apellido FROM usuarios WHERE apellido = :apellido");
        $consulta->bindValue(':apellido', $apellido);
        $consulta->setFetchMode(PDO::FETCH_CLASS, "Usuario");
        $consulta->execute();
        return $consulta->fetch();
    }

    protected static function TraerUsuarios(){
        $objetoAcceso = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoAcceso->RetornarConsulta("SELECT * FROM usuarios");
        $consulta->setFetchMode(PDO::FETCH_CLASS, "Usuario");
        $consulta->execute();
        return $consulta->fetchAll();
    }

    protected static function TraerUsuarioID($id){
        $objetoAcceso = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoAcceso->RetornarConsulta("SELECT * FROM usuarios WHERE id = :id");
        $consulta->bindValue(':id', $id);
        $consulta->setFetchMode(PDO::FETCH_CLASS, "Usuario");
        $consulta->execute();
        return $consulta->fetch();
    }

    protected function InsertarUsuario(){
        $objetoAcceso = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoAcceso->RetornarConsulta("INSERT INTO usuarios (correo, clave, nombre, apellido, perfil, foto) VALUES (:correo, :clave, :nombre, :apellido, :perfil, :foto)");
        $consulta->bindValue(':correo', $this->correo);
        $consulta->bindValue(':clave', $this->clave);
        $consulta->bindValue(':nombre', $this->nombre);
        $consulta->bindValue(':apellido', $this->apellido);
        $consulta->bindValue(':perfil', $this->perfil);
        $consulta->bindValue(':foto', $this->foto);
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
        $consulta = $objetoAcceso->RetornarConsulta("UPDATE usuarios SET nombre=:nombre, apellido=:apellido, perfil=:perfil, foto=:foto, correo=:correo, clave=:clave WHERE id=:id");
        $consulta->bindValue(':id', $this->id);
        $consulta->bindValue(':nombre', $this->nombre);
        $consulta->bindValue(':apellido', $this->apellido);
        $consulta->bindValue(':perfil', $this->perfil);
        $consulta->bindValue(':foto', $this->foto);
        $consulta->bindValue(':correo', $this->correo);
        $consulta->bindValue(':clave', $this->clave);
        $consulta->execute();
        return $consulta->rowCount();
    }
}

?>