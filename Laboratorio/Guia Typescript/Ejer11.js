"use strict";
function InvertirCadena(palabra) {
    var len = palabra.length;
    var cadena = "";
    while (len >= 0) {
        cadena += palabra.charAt(len);
        len--;
    }
    return cadena;
}
function ValidarPalindromo(palabra) {
    var cadena = "";
    var cadenaInvertida = "";
    var arrayString = palabra.split(' ');
    for (var i = 0; i < arrayString.length; i++) {
        if (arrayString[i] != "") {
            cadena += arrayString[i];
            cadenaInvertida += arrayString[i];
        }
    }
    if (cadena.toLowerCase() == InvertirCadena(cadenaInvertida).toLowerCase()) {
        console.log("La cadena ingresada es un palindromo");
    }
    else {
        console.log("La cadena ingresada no es un palindromo");
    }
}
ValidarPalindromo("La ruta nos aporto otro paso natural");
ValidarPalindromo("Hola");
//# sourceMappingURL=Ejer11.js.map