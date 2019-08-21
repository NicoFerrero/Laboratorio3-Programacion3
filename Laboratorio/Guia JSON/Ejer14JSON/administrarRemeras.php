<?php

switch($_GET["op"])
{
    case 'traerRemeras':
        $linea = "";
        $remeras;
        
        $file = fopen("./remeras.json", "r");
        while(!feof($file))
        {
            $linea .= fgets($file);
        }
        
        fclose($file);
        
        if(count($linea) > 0)
            $remeras = ($linea);
        else
            $remeras = "{}";
            
        echo $remeras;
    break;

    case'traerRemerasFiltradas':
        $filtro = $_GET["filtrar"];
        $lineas = "";
        $remeras;
        $remerasFiltradas = array();
        $retorno;

        $file = fopen("./remeras.json", "r");
        while(!feof($file))
        {
            $lineas .= fgets($file);
        }
        fclose($file);
        
        $remeras = json_decode($lineas);

        foreach($remeras as $remeraAux)
        {
            if(strtolower($remeraAux->manofacturer->location->country) == strtolower($filtro))
            {
                $e = new stdclass();
                $e->id = $remeraAux->id;
                $e->slogan = $remeraAux->slogan;
                $e->size = $remeraAux->size;
                $e->price = $remeraAux->price;
                $e->color = $remeraAux->color;
                $e->manofacturer = new stdclass();
                $e->manofacturer->name = $remeraAux->manofacturer->name;
                $e->manofacturer->logo = $remeraAux->manofacturer->logo;
                $e->manofacturer->location = new stdclass();
                $e->manofacturer->location->country = $remeraAux->manofacturer->location->country;
                $e->manofacturer->location->city = $remeraAux->manofacturer->location->city;
                array_push($remerasFiltradas, $e);
            }

            if(strtolower($filtro) == "")
            {
                $e = new stdclass();
                $e->id = $remeraAux->id;
                $e->slogan = $remeraAux->slogan;
                $e->size = $remeraAux->size;
                $e->price = $remeraAux->price;
                $e->color = $remeraAux->color;
                $e->manofacturer = new stdclass();
                $e->manofacturer->name = $remeraAux->manofacturer->name;
                $e->manofacturer->logo = $remeraAux->manofacturer->logo;
                $e->manofacturer->location = new stdclass();
                $e->manofacturer->location->country = $remeraAux->manofacturer->location->country;
                $e->manofacturer->location->city = $remeraAux->manofacturer->location->city;
                array_push($remerasFiltradas, $e);
            }
        }

        if(count($remerasFiltradas) > 0)
            $retorno = json_encode($remerasFiltradas,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        else
            $retorno = "{}";

        echo $retorno;
    break;

    case 'traerRemerasFiltradasPorCampo':
        $filtro = $_GET["filtrar"];
        $lineas = "";
        $remeras;
        $remerasFiltradas = array();
        $retorno;

        $file = fopen("./remeras.json", "r");
        while(!feof($file))
        {
            $lineas .= fgets($file);
        }
        fclose($file);
        
        $remeras = json_decode($lineas);

        foreach($remeras as $remeraAux)
        {

            $e = new stdclass();
            $e->id = $remeraAux->id;
            $e->slogan = $remeraAux->slogan;
            $e->size = $remeraAux->size;
            $e->price = $remeraAux->price;
            $e->color = $remeraAux->color;
            $e->manofacturer = new stdclass();
            $e->manofacturer->name = $remeraAux->manofacturer->name;
            $e->manofacturer->logo = $remeraAux->manofacturer->logo;
            $e->manofacturer->location = new stdclass();
            $e->manofacturer->location->country = $remeraAux->manofacturer->location->country;
            $e->manofacturer->location->city = $remeraAux->manofacturer->location->city;
            array_push($remerasFiltradas, $e);
        }

        if($filtro == "color")
            usort($remerasFiltradas, 'ordenColor');

        if($filtro == "pais")
        usort($remerasFiltradas, 'ordenPais');

        if($filtro == "tamanio")
        usort($remerasFiltradas, 'ordenTamanio');

        if(count($remerasFiltradas) > 0)
            $retorno = json_encode($remerasFiltradas,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        else
            $retorno = "{}";

        echo $retorno;
    break;

    case 'agregarRemera':
        $lineas = "";
        $remeras;
        $remerasArray = array();

        $file = fopen("./remeras.json", "r");
        while(!feof($file))
        {
            $lineas .= fgets($file);
        }
        fclose($file);

        $remeras = json_decode($lineas);

        foreach($remeras as $remeraAux)
        {
            $e = new stdclass();
            $e->id = $remeraAux->id;
            $e->slogan = $remeraAux->slogan;
            $e->size = $remeraAux->size;
            $e->price = $remeraAux->price;
            $e->color = $remeraAux->color;
            $e->manofacturer = new stdclass();
            $e->manofacturer->name = $remeraAux->manofacturer->name;
            $e->manofacturer->logo = $remeraAux->manofacturer->logo;
            $e->manofacturer->location = new stdclass();
            $e->manofacturer->location->country = $remeraAux->manofacturer->location->country;
            $e->manofacturer->location->city = $remeraAux->manofacturer->location->city;
            array_push($remerasArray, $e);
        }
        $e = new stdclass();
        $e->id = intval($_GET["id"]);
        $e->slogan = $_GET["slogan"];
        $e->size = $_GET["size"];
        $e->price = $_GET["price"];
        $e->color = $_GET["color"];
        $e->manofacturer = new stdclass();
        $e->manofacturer->name = $_GET["name"];
        $e->manofacturer->logo = $_GET["logo"];
        $e->manofacturer->location = new stdclass();
        $e->manofacturer->location->country = $_GET["country"];
        $e->manofacturer->location->city = $_GET["city"];
        array_push($remerasArray, $e);

        unlink("remeras.json");
        $file = fopen("./remeras.json", "a");
        $retorno = json_encode($remerasArray,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        $retorno = str_replace("}}},", "}}},\n", $retorno);
        fwrite($file, $retorno);
        fclose($file);
        header("location:index.html");
    break;

    case 'eliminarRemera':
        $id = $_GET["id"];
        $lineas = "";
        $remeras;
        $remerasArray = array();

        $file = fopen("./remeras.json", "r");
        while(!feof($file))
        {
            $lineas .= fgets($file);
        }
        fclose($file);
        
        $remeras = json_decode($lineas);

        foreach($remeras as $remeraAux)
        {
            if($remeraAux->id == $id)
            {
                continue;
            }
            else
            {
                $e = new stdclass();
                $e->id = $remeraAux->id;
                $e->slogan = $remeraAux->slogan;
                $e->size = $remeraAux->size;
                $e->price = $remeraAux->price;
                $e->color = $remeraAux->color;
                $e->manofacturer = new stdclass();
                $e->manofacturer->name = $remeraAux->manofacturer->name;
                $e->manofacturer->logo = $remeraAux->manofacturer->logo;
                $e->manofacturer->location = new stdclass();
                $e->manofacturer->location->country = $remeraAux->manofacturer->location->country;
                $e->manofacturer->location->city = $remeraAux->manofacturer->location->city;
                array_push($remerasArray, $e);
            }
        }

        unlink("remeras.json");
        $file = fopen("./remeras.json", "a");
        $retorno = json_encode($remerasArray,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        $retorno = str_replace("}}},", "}}},\n", $retorno);
        fwrite($file, $retorno);
        fclose($file);
        header("location:index.html");
    break;
}

function ordenColor($e, $eAux)
{
    if($e->color == $eAux->color)
    {
        return 0;
    }
    else if($e->color < $eAux->color)
    {
        return -1;
    }
    else
    {
        return 1;
    }
}

function ordenTamanio($e, $eAux)
{
    if($e->size == $eAux->size)
    {
        return 0;
    }
    else if($e->size < $eAux->size)
    {
        return -1;
    }
    else
    {
        return 1;
    }
}

function ordenPais($e, $eAux)
{
    if($e->manofacturer->location->country == $eAux->manofacturer->location->country)
    {
        return 0;
    }
    else if($e->manofacturer->location->country < $eAux->manofacturer->location->country)
    {
        return -1;
    }
    else
    {
        return 1;
    }
}


?>
