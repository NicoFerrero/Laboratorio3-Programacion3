<?php

    $archivo=fopen("texto1.txt","r");

    $texto=fread($archivo,filesize("texto1.txt"));
    
    if(strlen($texto)>0){
        echo $texto;
    }else{
        echo "No se pudo leer el archivo";
    }
    
   
    fclose($archivo);
    
?>