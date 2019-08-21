<?php

require_once "IParte2.php";
require_once "IParte3.php";
require_once "AccesoDatos.php";

class Televisor implements IParte2, IParte3{
    public $tipo;
    public $precio;
    public $paisOrigen;
    public $path;

    public function __construct($tipo = null, $precio = null, $paisOrigen = null, $path = null) {
        $this->tipo = $tipo != null ? $tipo : "";
        $this->precio = $precio != null ? $precio : "";
        $this->paisOrigen = $paisOrigen != null ? $paisOrigen : "";
        $this->path = $path != null ? $path : "";
    }

    public function ToJSON(){
        $aux = new stdClass();
        $aux->tipo = $this->tipo;
        $aux->precio = $this->precio;
        $aux->paisOrigen = $this->paisOrigen;
        $aux->path = $this->path;
        return json_encode($aux);
    }

    public function Agregar(){
        $objetoDatos = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoDatos->RetornarConsulta("INSERT INTO televisores (tipo, precio, pais, foto) VALUES(:tipo, :precio, :pais, :foto)");
        $consulta->bindValue(':tipo', $this->tipo);
        $consulta->bindValue(':precio', $this->precio);
        $consulta->bindValue(':pais', $this->paisOrigen);
        $consulta->bindValue(':foto', $this->path);

        return $consulta->execute();
    }

    public function Traer(){
        $auxReturn = array();
        $objetoDatos = AccesoDatos::ObtenerObjetoAcceso();
        $consulta = $objetoDatos->RetornarConsulta("SELECT * FROM televisores");
        $consulta->execute();

        $consulta->setFetchMode(PDO::FETCH_LAZY);

        foreach ($consulta as $tele) {
            $auxTele = new Televisor($tele->tipo,$tele->precio,$tele->pais,$tele->foto);
            array_push($auxReturn, $auxTele);
        }
        return $auxReturn;
    }

    public function CalcularIVA(){
        $auxIva = $this->precio *21 /100;
        return $this->precio + $auxIva;
    }

    public function Existe($televisor){
        $rta = false;
        $televisores = $this->Traer();

        foreach ($televisores as $televisorAux) {
            if((strcmp($televisorAux->tipo, $televisor->tipo) == 0) && (strcmp($televisorAux->paisOrigen, $televisor->paisOrigen) == 0) && ($televisorAux->precio == $televisor->precio)){
                $rta = true;
                break;
            }
        }
        return $rta;
    }

    public function Modificar($tipo, $precio, $paisOrigen, $path){
        $rta = false;
        if($this->Existe($this)){
            $objetoDatos = AccesoDatos::ObtenerObjetoAcceso();
            $consulta = $objetoDatos->RetornarConsulta('UPDATE televisores SET tipo = :tipo, precio = :precio, pais = :pais, foto = :foto WHERE tipo = :tipoAct AND precio = :precioAct AND pais = :paisAct');

            $consulta->bindValue(':tipo', $tipo, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $precio, PDO::PARAM_INT);
            $consulta->bindValue(':pais', $paisOrigen, PDO::PARAM_STR);
            $consulta->bindValue(':foto', $path, PDO::PARAM_STR);

            $consulta->bindValue(':tipoAct', $this->tipo, PDO::PARAM_STR);
            $consulta->bindValue(':precioAct', $this->precio, PDO::PARAM_INT);
            $consulta->bindValue(':paisAct', $this->paisOrigen, PDO::PARAM_STR);

            $consulta->execute();
            if($consulta->rowCount() > 0) {
                $rta = true;
            }
        }
        return $rta;
    }

    public function Eliminar(){
        $rta = false;
        if($this->Existe($this)){
            $objetoDatos = AccesoDatos::ObtenerObjetoAcceso();
            $consulta = $objetoDatos->RetornarConsulta('DELETE FROM televisores WHERE tipo = :tipo AND precio = :precio AND pais = :pais');

            $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
            $consulta->bindValue(':pais', $this->paisOrigen, PDO::PARAM_STR);

            $consulta->execute();
            if($consulta->rowCount() > 0) {
                $rta = true;
            }
        }
        return $rta;
    }
}

?>