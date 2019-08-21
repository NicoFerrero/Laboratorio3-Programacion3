<?php

    $nombre=" Juan"." Perez".date("r")."\n";

    $archivo=fopen("texto1.txt","a");

    if(0<fwrite($archivo,$nombre)){
        echo "Se escribió correctamente";
    }else{
        echo "No se pudo escribir";
    }

    fclose($archivo);
    
?>