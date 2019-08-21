function ValidarPalabra(palabra : string) : void
{
    let mayus : number = 0;
    let minus : number = 0;
    let mensaje : string;

    for(let i : number = 0; i < palabra.length; i++)
    {
        if(palabra[i] == palabra[i].toUpperCase())
        {
            mayus++;
        }
        else
        {
            minus++;
        }
    }

    if(mayus > 0 && minus == 0)
    {
        mensaje = "La palabra solo tiene mayusculas";
    }
    else if(mayus == 0 && minus > 0)
    {
        mensaje = "La palabra solo tiene minusculas";
    }
    else
    {
        mensaje = "La palabra es mixta";
    }

    console.log(mensaje);
}

ValidarPalabra("Arbol");
ValidarPalabra("arbol");
ValidarPalabra("ARBOL");
