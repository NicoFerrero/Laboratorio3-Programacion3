/*function Factorial(numero : number) : number
{
    if(numero == 0)
    {
        return 1;
    }

    return numero * Factorial(numero - 1);
}*/

function Factorial(numero : number) : void
{
    let total : number = 1;
    if(numero > 0)
    {
        for(let i : number = 1; i <= numero; i++)
        {
            total *= i;
        }
    }

    console.log(total);
}

//console.log(Factorial(5));
//Factorial(3);

export = Factorial;