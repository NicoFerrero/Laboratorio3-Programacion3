function InvertirCadena(palabra : string) : string
{
    var len : number = palabra.length;
    var cadena : string = "";

    while(len >= 0)
    {
        cadena += palabra.charAt(len);
        len--;
    }

    return cadena;
}

function ValidarPalindromo(palabra : string) : void
{
    var cadena : string = "";
    var cadenaInvertida : string = "";
    var arrayString : string[] = palabra.split(' ');

    for(var i : number = 0; i < arrayString.length; i++)
    {
        if(arrayString[i] != "")
        {
            cadena += arrayString[i];
            cadenaInvertida += arrayString[i];
        }
    }

    if(cadena.toLowerCase() == InvertirCadena(cadenaInvertida).toLowerCase())
    {
        console.log("La cadena ingresada es un palindromo");
    }
    else
    {
        console.log("La cadena ingresada no es un palindromo");
    }
}


ValidarPalindromo("La ruta nos aporto otro paso natural");
ValidarPalindromo("Hola");
