<?php

require_once "IParte1.php";
require_once "IParte2.php";
require_once "AccesoDatos.php";

class Juguete implements IParte1{
    private $_tipo;
    private $_precio;
    private $_paisOrigen;
    private $_pathImagen;


    public function __construct($tipo, $precio, $paisOrigen, $pathImagen = "") {
        $this->_tipo = $tipo;
        $this->_precio = $precio;
        $this->_paisOrigen = $paisOrigen;
        $this->_pathImagen = $pathImagen;
    }

    public function getTipo(){
        return $this->_tipo;
    }

    public function getPrecio(){
        return $this->_precio;
    }

    public function getPais(){
        return $this->_paisOrigen;
    }

    public function getPath(){
        return $this->_pathImagen;
    }

    public function ToString(){
        $cadena = $this->_tipo . "-" .  $this->_precio . "-" .$this->_paisOrigen . "-" . $this->_pathImagen;
        return $cadena;
    }

    public function Agregar(){
        $rta = false;
        $objetoDatos = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoDatos->RetornarConsulta("INSERT INTO juguetes (tipo, precio, pais, foto) VALUES(:tipo, :precio, :pais, :foto)");
        $consulta->bindValue(':tipo', $this->_tipo);
        $consulta->bindValue(':precio', $this->_precio);
        $consulta->bindValue(':pais', $this->_paisOrigen);
        $consulta->bindValue(':foto', $this->_pathImagen);

        $consulta->execute();
        if($consulta->rowCount() > 0){
            $rta = true;
        }

        return $rta;
    }

    public function Traer(){
        $auxReturn = array();
        $objetoDatos = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoDatos->RetornarConsulta("SELECT * FROM juguetes"); //Se prepara la consulta, aquí se podrían poner los alias
        $consulta->execute();

        $consulta->setFetchMode(PDO::FETCH_LAZY);

        foreach ($consulta as $juguete) {
            $auxJuguete = new Juguete($juguete->tipo,$juguete->precio,$juguete->pais,$juguete->foto);
            array_push($auxReturn, $auxJuguete);
        }
        return $auxReturn;
    }

    public function CalcularIVA(){
        $auxIva = $this->_precio *21 /100;
        return $this->_precio + $auxIva;
    }

    public function Verificar(){
        $rta = false;
        $juguetes = $this->Traer();

        foreach ($juguetes as $jugueteAux) {
            if((strcmp($jugueteAux->getTipo(), $this->getTipo()) == 0) && (strcmp($jugueteAux->getPais(), $this->getPais()) == 0)){
                $rta = true;
                break;
            }
        }
        return $rta;
    }

    public static function MostrarLog(){
        $cadena = "";
        if(!file_exists("./archivos/juguetes_sin_foto.txt")){
            $archivo = fopen("./archivos/juguetes_sin_foto.txt", "w");
        }else {
            $archivo = fopen("./archivos/juguetes_sin_foto.txt", "r");
            while(!feof($archivo)){
                $linea = trim(fgets($archivo));
                if($linea == ""){
                    continue;
                }
                $cadena .= $linea . "<br>";
            }
        }
        fclose($archivo);

        return $cadena;
    }

    public function Modificar($tipo, $precio, $paisOrigen, $path){
        $rta = false;
        if($this->Verificar()){
            $objetoDatos = AccesoDatos::ObtenerObjetoAcceso();
            $consulta = $objetoDatos->RetornarConsulta('UPDATE juguetes SET tipo = :tipo, precio = :precio, pais = :pais, foto = :foto WHERE tipo = :tipoAct AND pais = :paisAct');

            $consulta->bindValue(':tipo', $tipo, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $precio, PDO::PARAM_INT);
            $consulta->bindValue(':pais', $paisOrigen, PDO::PARAM_STR);
            $consulta->bindValue(':foto', $path, PDO::PARAM_STR);

            $consulta->bindValue(':tipoAct', $this->getTipo(), PDO::PARAM_STR);
            $consulta->bindValue(':paisAct', $this->getPais(), PDO::PARAM_STR);

            $consulta->execute();
            if($consulta->rowCount() > 0) {
                $rta = true;
            }
        }
        return $rta;
    }
}

?>