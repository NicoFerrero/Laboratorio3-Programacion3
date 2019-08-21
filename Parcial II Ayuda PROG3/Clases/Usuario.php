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

    /*protected static function TraerEmpleado($id){
        $objetoAcceso = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoAcceso->RetornarConsulta("SELECT * FROM empleados WHERE id = :id");
        $consulta->bindValue(':id', $id);
        $consulta->setFetchMode(PDO::FETCH_CLASS, "Empleado");
        $consulta->execute();
        return $consulta->fetch();
    }*/

    protected static function TraerUsuarios(){
        $objetoAcceso = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoAcceso->RetornarConsulta("SELECT * FROM usuarios");
        $consulta->setFetchMode(PDO::FETCH_CLASS, "Usuario");
        $consulta->execute();
        return $consulta->fetchAll();
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

    /*protected function BorrarEmpleado(){
        $objetoAcceso = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoAcceso->RetornarConsulta("DELETE FROM empleados WHERE id=:id");
        $consulta->bindValue(':id', $this->id);
        $consulta->execute();
        return $consulta->rowCount();
    }*/

    /*protected function ModificarEmpleado(){
        $objetoAcceso = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoAcceso->RetornarConsulta("UPDATE empleados SET nombre=:nombre, apellido=:apellido, sueldo=:sueldo, foto=:foto, legajo=:legajo, clave=:clave WHERE id=:id");
        $consulta->bindValue(':id', $this->id);
        $consulta->bindValue(':nombre', $this->nombre);
        $consulta->bindValue(':apellido', $this->apellido);
        $consulta->bindValue(':sueldo', $this->sueldo);
        $consulta->bindValue(':foto', $this->foto);
        $consulta->bindValue(':legajo', $this->legajo);
        $consulta->bindValue(':clave', $this->clave);
        $consulta->execute();
        return $consulta->rowCount();
    }*/
}

?>