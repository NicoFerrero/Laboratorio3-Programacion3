<?php
  class  BaseDatos
 {

    #atributos
    public static $base="usuarios";
    private static $user="root";
    private  static $clave="";


    #constructor

    /*
    public function _construct($base , $user , $clave)
    {
        $this->base=$base;
        $this->user=$user;
        $this->clave=$clave;
    }*/


    #metodos Estaticos

    public static function EstablecerConexion()
    {

       return $con = @mysql_connect("localhost", BaseDatos::$user, BaseDatos::$clave);
    }

    public static function CerrarConexion()
    {
        //no hace falta pasarle parametro porque por default va a cerrar la ultima conexion abierta
        mysql_close();
    }
 }
?>