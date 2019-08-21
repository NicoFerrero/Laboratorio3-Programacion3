<?php

    $nombre="Nicolas"." Lo Vento";

    $archivo=fopen("texto1.txt","w");

    if(0<fwrite($archivo,$nombre)){
        echo "Se escribió correctamente";
    }else{
        echo "No se pudo escribir";
    }

    fclose($archivo);





?>