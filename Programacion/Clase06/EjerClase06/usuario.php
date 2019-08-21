<?php
require "./AccesoDatos.php";
class Usuario
{
    public $correo;
    public $clave;
    public $nombre;
    public $apellido;
    public $perfil;

    public function __construct($correo=null,$clave=null,$nombre=null,$apellido=null,$perfil=null)
    {
        $this->correo= isset($correo) ? $correo : "";
        $this->clave= isset($clave) ? $clave : "";
        $this->nombre= isset($nombre) ? $nombre : "";
        $this->apellido= isset($apellido) ? $apellido : "";
        $this->perfil= isset($perfil) ? $perfil : "";
    }
    
    public static function TraerId($id)
    {
        $usuarios = array();
        $pdo = AccesoDatos::DameUnObjetoAcceso();
        $sp = $pdo->RetornarConsulta("SELECT * FROM usuarios WHERE id = :id");
        $sp->bindParam(":id", $id);
        $sp->execute();
        $obj = $sp->fetch(PDO::FETCH_LAZY);
        return new Usuario($obj->correo, $obj->clave, $obj->nombre, $obj->apellido, $obj->perfil);
    }

    public static function TraerTodos()
    {
        $usuarios = array();
        $pdo = AccesoDatos::DameUnObjetoAcceso();
        $sp = $pdo->RetornarConsulta("SELECT * FROM usuarios");
        $sp->execute();
        $sp->fetch(PDO::FETCH_INTO, new Usuario);
        foreach($sp as $usuario){
            array_push($usuarios, $usuario);
        }
        return $usuarios;
    }

    public static function Eliminar($id)
    {
        $pdo = AccesoDatos::DameUnObjetoAcceso();
        $sp = $pdo->RetornarConsulta("DELETE FROM usuarios WHERE id = :id");
        $sp->bindParam(":id", $id);
        $sp->execute();
        return $sp->rowCount();
    }

    public static function Agregar($obj)
    {
        $pdo = AccesoDatos::DameUnObjetoAcceso();
        $sp = $pdo->RetornarConsulta("INSERT INTO usuarios (correo, clave, nombre, apellido, perfil) VALUES(:correo, :clave, :nombre, :apellido, :perfil)");
        $sp->bindParam(":correo", $obj->correo);
        $sp->bindParam(":clave", $obj->clave);
        $sp->bindParam(":nombre", $obj->nombre);
        $sp->bindParam(":apellido", $obj->apellido);
        $sp->bindParam(":perfil", $obj->perfil);
        $sp->execute();
        return $sp->rowCount();
    }

    public static function Modificar($obj, $id)
    {
        $pdo = AccesoDatos::DameUnObjetoAcceso();
        $sp = $pdo->RetornarConsulta("UPDATE usuarios SET correo = :correo, clave = :clave, nombre = :nombre, apellido = :apellido, perfil = :perfil WHERE id = :id");
        $sp->bindParam(":id", $id);
        $sp->bindParam(":correo", $obj->correo);
        $sp->bindParam(":clave", $obj->clave);
        $sp->bindParam(":nombre", $obj->nombre);
        $sp->bindParam(":apellido", $obj->apellido);
        $sp->bindParam(":perfil", $obj->perfil);
        $sp->execute();
        return $sp->rowCount();
    }
}
?>