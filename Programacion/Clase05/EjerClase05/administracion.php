<?php

date_default_timezone_set("America/Argentina/Buenos_Aires");
$date = date("Y_m_d");

$que_hago = $_POST["op"];
$id = $_POST["id"];
$titulo = $_POST["titulo"];
$interprete = $_POST["interprete"];
$anio = $_POST["anio"];

$foto = $_FILES["foto"]["name"];
$nombreFoto = $date . "_" . $titulo . "." . pathinfo($foto, PATHINFO_EXTENSION);
$destino = "Fotos/CDS/" . $nombreFoto;
$destinoBorrar = "Fotos/CDS/";

switch($que_hago)
{
    case "conectarme":
        $conexion = mysql_connect("localhost", "root", "");
        if(!$conexion)
        {
            echo "Fallo la conexion!!!";
        }
        else
        {
            echo "Conexion exitosa";
            mysql_close($conexion);
        }
        break;

    case "ejecutar":
        $conexion = mysql_connect("localhost", "root", "");
        if(!$conexion)
        {
            echo "Fallo la conexion!!!";
        }
        else
        {
            echo "Conexion exitosa</br>";
            $query = mysql_db_query("cdcol", "Select * from cds");
            var_dump($query);
            mysql_close($conexion);
        }
        break;

    case "traerTodo":
        $conexion = mysql_connect("localhost", "root", "");
        if(!$conexion)
        {
            echo "Fallo la conexion!!!";
        }
        else
        {
            echo "Conexion exitosa</br>";
            $query = mysql_db_query("cdcol", "Select * from cds");
            if(mysql_num_rows($query) > 0)
            {
                while($row = mysql_fetch_array($query, MYSQL_ASSOC))
                {
                    echo "</br>" . $row["id"] . "</br>";
                    echo $row["titel"] . "</br>";
                    echo $row["interpret"] . "</br>";
                    echo $row["jahr"] . "</br>";
                    echo $row["foto"] . "</br>";
                } 
            } 
            mysql_close($conexion);
        }
        break;

    case "traerUno":
        $conexion = mysql_connect("localhost", "root", "");
        if(!$conexion)
        {
            echo "Fallo la conexion!!!";
        }
        else
        {
            echo "Conexion exitosa" . "</br>";
            $query = mysql_db_query("cdcol", "Select * from cds where id=" . $id);
            if(mysql_num_rows($query) > 0)
            {
                while($row = mysql_fetch_array($query, MYSQL_ASSOC))
                {
                    echo "</br>" . $row["id"] . "</br>";
                    echo $row["titel"] . "</br>";
                    echo $row["interpret"] . "</br>";
                    echo $row["jahr"] . "</br>";
                    echo $row["foto"];
                }
            }
            else
            {
                echo "El ID ingresado no existe";
            }
            mysql_close($conexion);
        }
        break;

    case "agregar":
        $conexion = mysql_connect("localhost", "root", "");
        if(!$conexion)
        {
            echo "Fallo la conexion!!!";
        }
        else
        {
            //var_dump($_POST);
            echo "Conexion exitosa</br>";
            $query = mysql_db_query("cdcol", "insert into cds(titel, interpret, jahr, foto) values('" . $titulo . "', '" . $interprete . "', " . $anio . ", '" . $nombreFoto . "')");
            //echo mysql_error();
            echo "Se agrego el ID " . mysql_insert_id();
            if(isset($foto))
            {
                move_uploaded_file($_FILES["foto"]["tmp_name"], $destino);
            }
            mysql_close($conexion);
        }
        break;

    case "modificar":
        $conexion = mysql_connect("localhost", "root", "");
        if(!$conexion)
        {
            echo "Fallo la conexion!!!";
        }
        else
        {
            echo "Conexion exitosa</br>";
            $query = mysql_db_query("cdcol", "Select * from cds where id=" . $id);
            unlink($destinoBorrar . mysql_fetch_array($query)["foto"]);
            $query = mysql_db_query("cdcol", "update cds set titel ='". $titulo . "', interpret='" . $interprete . "', jahr=" . $anio . ", foto='" . $nombreFoto . "' where id=" . $id);
            if(isset($foto))
            {
                move_uploaded_file($_FILES["foto"]["tmp_name"], $destino);
            }
            echo "Modificacion con exito";
            //echo mysql_error();
            mysql_close($conexion);
        }
        break;

    case "borrar":
            $conexion = mysql_connect("localhost", "root", "");
            if(!$conexion)
            {
                echo "Fallo la conexion!!!";
            }
            else
            {
                echo "Conexion exitosa</br>";
                $query = mysql_db_query("cdcol", "Select * from cds where id=" . $id);
                //var_dump(mysql_fetch_array($query)["foto"]);
                unlink($destinoBorrar . mysql_fetch_array($query)["foto"]);
                $query = mysql_db_query("cdcol", "delete from cds where id=" . $id);
                mysql_close($conexion);
            }
            break;

    default:
        echo "La opcion elegida no es correcta!!!";
        break;
}

?>