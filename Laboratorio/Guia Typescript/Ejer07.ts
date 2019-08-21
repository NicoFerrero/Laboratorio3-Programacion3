/*function ValidarPrimos() : void
{
    var i : number;
    var j : number;
    var primos : number;

    for(i = 2; i <= 72; i++)
    {
        primos = 0;

        for(j = 1; j < 72; j++)
        {
            if(i % j == 0)
            {
                primos++;
            }
        }

        if(primos == 2)
        {
            console.log(i);
        }
    }
}*/

function ValidarPrimos() : void
{
    var i : number = 2;
    var j : number;
    var primos : number = 0;
    var contador : number;

    while(primos < 20)
    {
        contador = 0;

        for(j = 1; j <= i; j++)
        {
            if(i % j == 0)
            {
                contador++;
            }
        }

        if(contador == 2)
        {
            console.log(i);
            primos++;
        }

        i++
    }
}

ValidarPrimos();

