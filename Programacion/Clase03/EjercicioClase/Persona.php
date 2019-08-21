<?php

class Persona{

    public $nombre;
    public $apellido;


    public function Guardar(){

        $archivo=fopen("personas.txt","a");

        //var_dump($_POST);
        if(($_POST["nombre"]!="") && ($_POST["apellido"]!="")){//Valido que haya ingresado texto

            fwrite($archivo,$this->ToString());
            return true;
        }else{

            return false;
        }

        fclose($archivo);
        }

    public function Leer(){
        $archivo=fopen("personas.txt","r");

        $texto=fread($archivo,filesize("personas.txt"));
        
        if(strlen($texto)>0){
            echo $texto."<br>";
            return true;
        }else{
            
            return false;
        }
        
    
        fclose($archivo);
        }

    public function ToString(){

        return $this->nombre."-".$this->apellido."\r\n";
    }

    public static function TraerTodasLasPersonas(){

        $arrayDePersonas=array();
        $archivo=fopen("personas.txt","r");

        while(!feof($archivo)){

            $texto=fgets($archivo);
            if($texto==""){
                continue;
            }
            $array=explode("-",$texto);
            $persona=new Persona();
            $persona->nombre=$array[0];
            $persona->apellido=$array[1];
            
            array_push($arrayDePersonas,$persona);
        }
        
    
        fclose($archivo);

        return $arrayDePersonas;
        }

    }



?>