<?php
require_once "AccesoDatos.php";
$razaAux = $_POST["raza"];
$string = "";
$objetoDatos = AccesoDatos::ObtenerObjetoAcceso();
$consulta = $objetoDatos->RetornarConsulta("SELECT * FROM perros"); //Se prepara la consulta, aquí se podrían poner los alias
$consulta->execute();
$consulta->setFetchMode(PDO::FETCH_NUM);
while ($fila = $consulta->fetch()) {
    if($razaAux != $fila[5]){
        continue;
    }
    $string .= '{"tamanio":"' . $fila[1] . '", "edad":' . $fila[2] . ', "precio":' . $fila[3] . ',"nombre":"' . $fila[4] . '","raza":"' . $fila[5] . '","pathFoto":"' . $fila[6] . '"},';
}
$string = substr($string, 0, strlen($string)-1);
echo ('['.$string.']');

?>