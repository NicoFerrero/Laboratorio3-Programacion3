"use strict";
function Test(numero, cadena) {
    if (cadena) {
        for (var i = 0; i < numero; i++) {
            console.log(cadena + "\n");
        }
    }
    else {
        console.log("" + (numero - (numero * 2)));
    }
}
Test(2, "Como te va");
//# sourceMappingURL=Ejer03.js.map