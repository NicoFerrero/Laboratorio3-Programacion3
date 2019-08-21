<?php
require "./BaseDatos.php";
class Usuario
{

    #atributos
public $id;
public $correo;
public $clave;
public $nombre;
public $apellido;
public $perfil;


#constructor

public function __construct($id=null,$correo=null,$clave=null,$nombre=null,$apellido=null,$perfil=null)
{
    $this->id=$id;
    $this->correo=$correo;
    $this->clave=$clave;
    $this->nombre=$nombre;
    $this->apellido=$apellido;
    $this->perfil=$perfil;
}


#metodo instancia

public function TraerId($id)
{
    //establezco la conexion
  $con=BaseDatos::EstablecerConexion();

  //ejecuto la consulta
$sql = "SELECT * FROM usuarios WHERE id={$id}";

  
   //parametros son tabla,consulta y conexion 
    $rs = mysql_db_query("productos",$sql,$con);

    $usuario=null;

    if($rs!==false)
    {
       //obtengo los datos de la "consulta" en una variable
        $datos= mysql_fetch_object($rs);
        if($datos!==false)
        {          
          //cargo esos datos dependiendo de las columnas de tabla en un objeto de tipo usuario
          $usuario = new Usuario($datos->id,$datos->correo,$datos->clave,$datos->nombre,$datos->apellido,$datos->perfil);
        }

    }

    //cierro la conexion
    BaseDatos::CerrarConexion();

    //retorno ese usuario obtenido desde la base de datos
    return $usuario;
}

public function TraerTodos()
{
    $con=BaseDatos::EstablecerConexion();

    //obtengo todos los usuarios de la tabla
    $sql = "SELECT * FROM usuarios";

    $rs = mysql_db_query("productos",$sql,$con);

    $usuarios=[];

    if($rs!==false)
    { 
        //recorro cada uno de los elementos de la tabla
        while($datos= mysql_fetch_object($rs))
        {          
          if($datos!==false)
          {          
           $usuario = new Usuario($datos->id,$datos->correo,$datos->clave,$datos->nombre,$datos->apellido,$datos->perfil);

           //cargo cada uno de los usuarios en un array
           array_push($usuarios,$usuario);
          }
        }

    }

    BaseDatos::CerrarConexion();

    return $usuarios;
}


public function Eliminar()
{
    $con=BaseDatos::EstablecerConexion();

    //obtengo id de la instancia
    $id = $this->id;

    //ejecuto la consulta de eliminar un usuario en el id especificado
    $sql = "DELETE FROM usuarios WHERE id={$id}";

    $rs = mysql_db_query("productos",$sql,$con);

    $flag=false;

    if($rs!==false)
    {
        $flag=true;
    }


    BaseDatos::CerrarConexion();

    return $flag;
}



#Metodos Estaticos

public static function Agregar($obj)
{
    $con=BaseDatos::EstablecerConexion();


    //ejecuto la consulta de eliminar un usuario en el id especificado NO ESPECIFICO ID EN NINGUN LADO YA QUE ES AUTOINCREMENTAL
    $sql = "INSERT INTO usuarios (correo, clave, nombre, apellido, perfil) values ('$obj->correo','$obj->clave','$obj->nombre','$obj->apellido', $obj->perfil)";


    $rs = mysql_db_query("productos",$sql,$con);

    echo (int)$rs;
    $flag=false;

    if($rs!==false)
    {
        $flag=true;
    }


    BaseDatos::CerrarConexion();

    return $flag;

}


public static function Modificar($obj)
{
    $con=BaseDatos::EstablecerConexion();


    //ejecuto la consulta de modificar los parametros de usuario a excepcion del id que se mantiene
    $sql = "UPDATE usuarios SET correo='$obj->correo' , clave='$obj->clave' , nombre='$obj->nombre' , apellido='$obj->apellido' , perfil=$obj->perfil WHERE id=$obj->id";


    $rs = mysql_db_query("productos",$sql,$con);
    
    $flag=false;

    if($rs!==false)
    {
        $flag=true;
    }


    BaseDatos::CerrarConexion();

    return $flag;
}

}


?>