/// <reference path="./node_modules/@types/jquery/index.d.ts"/>

function HolaMundo()
{
    if($("#txtNombre").val()==="1234")
    {
        $("#txtSegundo").val("hola Mundo");
    }
    else
    {
        $("#txtSegundo").val("incorrecta");

    }

}

function HolaMundo2()
{
    let nombre = $("#txtNombre");
    let resultado=$("#txtSegundo");

    if(nombre.val()==="1234")
    {
        resultado.val("hola Mundo");

        //obtengo por "id"
        $("#p1").html("Sos un crack compa descubriste la contraseña");

        //obtengo por nombre de "tag"
        //$("p").html("Sos un crack compa descubriste la contraseña");

    }
    else
    {
        resultado.val("incorrecta");
    }

}

function HolaMundo3()
{
    let nombre:any = $("#txtNombre").val();
    let resultado=$("#txtSegundo");

    let formData : FormData =new FormData();

    formData.append("contraseña",nombre);

    $.ajax({
        //formato de envio si "POST" o "GET"
        type: 'POST',

        //direccion que va a recibir los datos
        url: "./prueba07.php",

        //dataType indica el formato de retorno
        dataType: "json",

        //cahce, contentType y processData poner el "false" si trabajamos con archivos
        cache: false,
        contentType: false,
        processData: false,

        //indica el formato de envio
        data: formData,

        //si es de manera asincronica o no
        async: true
    })
    .done(function(objJson)
    {
        if(objJson.Exito==true)
        {
            $("#txtSegundo").val("Hola Mundo");
            $("#p1").html("Sos un crack compa descubriste la contraseña");
        }
        else
        {
            $("#txtSegundo").val("Incorrecto");
        }

    }
    );



}