<?php

        $fecha=date("Y-m-d-h-i-s"); 

        $archivo=fopen("MisArchivos/".$fecha.".txt","a");
        fwrite($archivo,"");
        
        $direccion=$_POST["direccion"];
        
        if(copy($direccion,"MisArchivos/".$fecha.".txt")){
            echo "Se copió el archivo";
        }else{
            echo "No se pudo copiar";
        }


?>