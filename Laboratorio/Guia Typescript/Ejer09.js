"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var Factorial = require("./Ejer08");
var Cubo = require("./Ejer06");
function ValidarNumero(numero) {
    if (numero >= 0) {
        Factorial(numero);
    }
    else {
        Cubo(numero);
    }
}
ValidarNumero(-2);
//# sourceMappingURL=Ejer09.js.map