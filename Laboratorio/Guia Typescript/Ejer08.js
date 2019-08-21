"use strict";
/*function Factorial(numero : number) : number
{
    if(numero == 0)
    {
        return 1;
    }

    return numero * Factorial(numero - 1);
}*/
function Factorial(numero) {
    var total = 1;
    if (numero > 0) {
        for (var i = 1; i <= numero; i++) {
            total *= i;
        }
    }
    console.log(total);
}
module.exports = Factorial;
//# sourceMappingURL=Ejer08.js.map