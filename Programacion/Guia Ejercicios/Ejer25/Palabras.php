<?php

   

    class Palabras{
    public static function ObtenerPalabras(){

        $arrayDePalabras=array();
        $archivo=fopen("MisArchivos/palabras.txt","r");
        
        while(!feof($archivo)){

            $texto=fgets($archivo);//leo por linea
            $texto=trim($texto,"\n\r");//elimino espacios en blanco
            array_push($arrayDePalabras,$texto);
            
        }
        
        fclose($archivo);

        return $arrayDePalabras;
    }

    public static function CalcularLetrasPorPalabra($arrayDePalabras){

        $unaLetra=0;
        $dosLetras=0;
        $tresLetras=0;
        $cuatroLetras=0;
        $masDeCuatroLetras=0;
        foreach($arrayDePalabras as $palabra){

            switch(strlen($palabra)){
                case 1:
                    $unaLetra++;
                break;
                case 2:
                    $dosLetras++;
                break;
                case 3:
                    $tresLetras++;
                break;
                case 4:
                    $cuatroLetras++;
                break;
                default:
                    $masDeCuatroLetras++;
                break;
             }

        }

        $arrayDeLetras=array("1"=>$unaLetra,"2"=>$dosLetras,"3"=>$tresLetras,"4"=>$cuatroLetras,"Más de 4"=>$masDeCuatroLetras);
        

        return $arrayDeLetras;
    }

    

    public static function MostrarPalabras($arrayDePalabras){

        echo "<br>";
        foreach($arrayDePalabras as $palabra){

            echo $palabra."<br>";

        }
        
    }

    
    }
    



?>