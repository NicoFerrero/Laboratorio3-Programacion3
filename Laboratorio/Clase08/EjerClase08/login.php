<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="login.css">
    <title>Document</title>
</head>
<body>
    <form>
        <table>
            <thead>
                <th colspan="2">Ingreso</th>
            </thead>
            <tr>
                <td colspan="2"><label for="legajo"><span>legajo</span></label></td>
            </tr>
            <tr>
                <td colspan="2"><input type="text" name="legajo" id="legajo"></td>
            </tr>
            <tr>
                <td colspan="2"><label for="clave"><span>clave</span></label></td>
            </tr>
            <tr>
                <td colspan="2"><input type="text" name="clave" id="clave"></td>
            </tr>
            <tr>
                <td><input type="button" value="Aceptar" id="btnAceptar" class="aceptar" onclick="Validar1()"></td>
                <td><input type="button" value="Cancelar" id="btnCancelar" class="cancelar"></td>
            </tr>
        </table>
    </form>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="./login.js"></script>
</body>
</html>