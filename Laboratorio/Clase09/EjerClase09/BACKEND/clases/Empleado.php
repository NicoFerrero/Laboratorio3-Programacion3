<?php

require_once 'AccesoDatos.php';

class Empleado{

    public $id;
    public $nombre;
    public $apellido;
    public $sueldo;
    public $legajo;
    public $clave;
    public $foto;

    protected static function LoginEmpleado($legajo, $clave){
        $objetoAcceso = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoAcceso->RetornarConsulta("SELECT * FROM empleados WHERE legajo = :legajo AND clave = :clave");
        $consulta->bindValue(':legajo', $legajo);
        $consulta->bindValue(':clave', $clave);
        $consulta->setFetchMode(PDO::FETCH_CLASS, "Empleado");
        $consulta->execute();
        return $empleadoBD = $consulta->fetch();
    }

    protected static function ExisteEmpleado($legajo){
        $objetoAcceso = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoAcceso->RetornarConsulta("SELECT * FROM empleados WHERE legajo = :legajo");
        $consulta->bindValue(':legajo', $legajo);
        $consulta->setFetchMode(PDO::FETCH_CLASS, "Empleado");
        $consulta->execute();
        return $empleadoBD = $consulta->fetch();
    }

    protected static function TraerEmpleado($id){
        $objetoAcceso = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoAcceso->RetornarConsulta("SELECT * FROM empleados WHERE id = :id");
        $consulta->bindValue(':id', $id);
        $consulta->setFetchMode(PDO::FETCH_CLASS, "Empleado");
        $consulta->execute();
        return $consulta->fetch();
    }

    protected static function TraerEmpleados(){
        $objetoAcceso = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoAcceso->RetornarConsulta("SELECT * FROM empleados");
        $consulta->setFetchMode(PDO::FETCH_CLASS, "Empleado");
        $consulta->execute();
        return $consulta->fetchAll();
    }

    protected function InsertarEmpleado(){
        $objetoAcceso = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoAcceso->RetornarConsulta("INSERT INTO empleados (nombre, apellido, sueldo, foto, legajo, clave) VALUES (:nombre, :apellido, :sueldo, :foto, :legajo, :clave)");
        $consulta->bindValue(':nombre', $this->nombre);
        $consulta->bindValue(':apellido', $this->apellido);
        $consulta->bindValue(':sueldo', $this->sueldo);
        $consulta->bindValue(':foto', $this->foto);
        $consulta->bindValue(':legajo', $this->legajo);
        $consulta->bindValue(':clave', $this->clave);
        $consulta->execute();
        return $consulta->rowCount();
    }

    protected function BorrarEmpleado(){
        $objetoAcceso = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoAcceso->RetornarConsulta("DELETE FROM empleados WHERE id=:id");
        $consulta->bindValue(':id', $this->id);
        $consulta->execute();
        return $consulta->rowCount();
    }

    protected function ModificarEmpleado(){
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
    }
}

?>