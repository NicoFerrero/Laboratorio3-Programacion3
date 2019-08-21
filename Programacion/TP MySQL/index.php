<?php

$opciones = $_POST["op"];
$numeroProd = $_POST["numeroProd"];
$nombreProd = $_POST["nombreProd"];
$precioProd = $_POST["precioProd"];
$tamanioProd = $_POST["tamanioProd"];
$numeroProv = $_POST["numeroProv"];
$nombreProv = $_POST["nombreProv"];
$localidad = $_POST["localidad"];

switch($opciones)
{
    case 1:
        $conexion = mysql_connect("localhost", "root", "");
        if(!$conexion)
        {
            echo "Fallo la conexion!!!";
        }
        else
        {
            echo "Conexion exitosa</br>";
            $query = mysql_db_query("utn", "SELECT * FROM productos ORDER BY pNombre ASC");
            if(mysql_num_rows($query) > 0)
            {
                while($row = mysql_fetch_array($query))
                {
                    echo "</br>" . $row[0] . "-" . $row[1] . "-" . $row[2] . "-" . $row[3];
                }
            }
            mysql_close($conexion);
        }
    break;

    case 2:
        $conexion = mysql_connect("localhost", "root", "");
        if(!$conexion)
        {
            echo "Fallo la conexion!!!";
        }
        else
        {
            echo "Conexion exitosa</br>";
            $query = mysql_db_query("utn", "SELECT * FROM provedores WHERE Localidad='Quilmes'");
            if(mysql_num_rows($query) > 0)
            {
                while($row = mysql_fetch_array($query))
                {
                    echo "</br>" . $row[0] . "-" . $row[1] . "-" . $row[2] . "-" . $row[3];
                }
            }
            mysql_close($conexion);
        }
    break;

    case 3:
        $conexion = mysql_connect("localhost", "root", "");
        if(!$conexion)
        {
            echo "Fallo la conexion!!!";
        }
        else
        {
            echo "Conexion exitosa</br>";
            $query = mysql_db_query("utn", "SELECT * FROM envios WHERE cantidad >= 200 AND cantidad <= 300");
            if(mysql_num_rows($query) > 0)
            {
                while($row = mysql_fetch_array($query))
                {
                    echo "</br>" . $row[0] . "-" . $row[1] . "-" . $row[2];
                }
            }
            mysql_close($conexion);
        }
    break;

    case 4:
        $conexion = mysql_connect("localhost", "root", "");
        if(!$conexion)
        {
            echo "Fallo la conexion!!!";
        }
        else
        {
            echo "Conexion exitosa</br>";
            $total = 0;
            $query = mysql_db_query("utn", "SELECT * FROM envios");
            if(mysql_num_rows($query) > 0)
            {
                while($row = mysql_fetch_array($query))
                {
                    $total += $row[2];
                }
                echo  "Total de cantidades: " . $total;
            }
            mysql_close($conexion);
        }
    break;

    case 5:
        $conexion = mysql_connect("localhost", "root", "");
        if(!$conexion)
        {
            echo "Fallo la conexion!!!";
        }
        else
        {
            echo "Conexion exitosa</br>";
            $query = mysql_db_query("utn", "SELECT * FROM envios LIMIT 3");
            if(mysql_num_rows($query) > 0)
            {
                while($row = mysql_fetch_array($query))
                {
                    echo "</br>" . $row[0];
                }
            }
            mysql_close($conexion);
        }
    break;

    case 6:
        $conexion = mysql_connect("localhost", "root", "");
        if(!$conexion)
        {
            echo "Fallo la conexion!!!";
        }
        else
        {
            echo "Conexion exitosa</br>";
            $query = mysql_db_query("utn", "SELECT provedores.Nombre, productos.pNombre FROM ((envios INNER JOIN provedores ON envios.Numero=provedores.Numero) INNER JOIN productos ON envios.pNumero=productos.pNumero) ORDER BY envios.Numero ASC"); 
            if(mysql_num_rows($query) > 0)
            {
                while($row = mysql_fetch_array($query))
                {
                    echo "</br>" . $row[0] . "-" . $row[1];
                }
            }
            mysql_close($conexion);
        }
    break;

    case 7:
        $conexion = mysql_connect("localhost", "root", "");
        if(!$conexion)
        {
            echo "Fallo la conexion!!!";
        }
        else
        {
            echo "Conexion exitosa</br>";
            $total;
            $query = mysql_db_query("utn", "SELECT Numero, productos.Precio, Cantidad FROM envios INNER JOIN productos ON envios.pNumero=productos.pNumero");
            if(mysql_num_rows($query) > 0)
            {
                while($row = mysql_fetch_array($query))
                {
                    $total = 0;
                    $total = $row[1] * $row[2];
                    echo "</br>" . $row[0] . "-" . $total;
                }
            }
            mysql_close($conexion);
        }
    break;

    case 8:
        $conexion = mysql_connect("localhost", "root", "");
        if(!$conexion)
        {
            echo "Fallo la conexion!!!";
        }
        else
        {
            echo "Conexion exitosa</br>";
            $total = 0;
            $query = mysql_db_query("utn", "SELECT Cantidad FROM envios WHERE Numero=102 AND pNumero=1");
            if(mysql_num_rows($query) > 0)
            {
                while($row = mysql_fetch_array($query))
                {
                    $total += $row[0];
                }
                echo "Total de prod 1 enviado por prov 102: " . $total;
            }
            mysql_close($conexion);
        }
    break;

    case 9:
        $conexion = mysql_connect("localhost", "root", "");
        if(!$conexion)
        {
            echo "Fallo la conexion!!!";
        }
        else
        {
            echo "Conexion exitosa</br>";
            $total = 0;
            $query = mysql_db_query("utn", "SELECT provedores.Localidad, pNumero FROM envios INNER JOIN provedores ON envios.Numero=provedores.Numero WHERE provedores.Localidad='Avellaneda'");
            if(mysql_num_rows($query) > 0)
            {
                while($row = mysql_fetch_array($query))
                {
                    echo "</br>" . $row[1];
                }
            }
            mysql_close($conexion);
        }
    break;

    case 10:
        $conexion = mysql_connect("localhost", "root", "");
        if(!$conexion)
        {
            echo "Fallo la conexion!!!";
        }
        else
        {
            echo "Conexion exitosa</br>";
            $query = mysql_db_query("utn", "SELECT * FROM provedores WHERE Nombre LIKE '%I%' OR Nombre LIKE '%i%'");
            if(mysql_num_rows($query) > 0)
            {
                while($row = mysql_fetch_array($query))
                {
                    echo "</br>" . $row[0] . "-" . $row[1] . "-" . $row[2] . "-" . $row[3];
                }
            }
            mysql_close($conexion);
        }
    break;

    case 11:
        $conexion = mysql_connect("localhost", "root", "");
        if(!$conexion)
        {
            echo "Fallo la conexion!!!";
        }
        else
        {
            echo "Conexion exitosa</br>";
            $query = mysql_db_query("utn", "INSERT INTO productos(pNumero, pNombre, Precio, Tamanio) values(" . $numeroProd . ", '" . $nombreProd . "', " . $precioProd . ", '" . $tamanioProd . "')");
            mysql_close($conexion);
        }
    break;

    case 12:
        $conexion = mysql_connect("localhost", "root", "");
        if(!$conexion)
        {
            echo "Fallo la conexion!!!";
        }
        else
        {
            echo "Conexion exitosa</br>";
            $query = mysql_db_query("utn", "INSERT INTO provedores(Numero) values(" . $numeroProv . ")");
            mysql_close($conexion);
        }
    break;

    case 13:
        $conexion = mysql_connect("localhost", "root", "");
        if(!$conexion)
        {
            echo "Fallo la conexion!!!";
        }
        else
        {
            echo "Conexion exitosa</br>";
            $query = mysql_db_query("utn", "INSERT INTO provedores(Numero, Nombre, Localidad) values(" . $numeroProv . ", '" . $nombreProv . "', '" . $localidad . "')");
            mysql_close($conexion);
        }
    break;

    case 14:
        $conexion = mysql_connect("localhost", "root", "");
        if(!$conexion)
        {
            echo "Fallo la conexion!!!";
        }
        else
        {
            echo "Conexion exitosa</br>";
            $query = mysql_db_query("utn", "UPDATE productos SET Precio=97.50 WHERE Tamanio='Grande'");
            mysql_close($conexion);
        }
    break;

    case 15:
    break;

    case 16:
        $conexion = mysql_connect("localhost", "root", "");
        if(!$conexion)
        {
            echo "Fallo la conexion!!!";
        }
        else
        {
            echo "Conexion exitosa</br>";
            $query = mysql_db_query("utn", "DELETE FROM productos WHERE pNumero=1");
            mysql_close($conexion);
        }
    break;

    case 17:
    break;
}

?>