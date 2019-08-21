"use strict";
function ValidarPalabra(palabra) {
    var mayus = 0;
    var minus = 0;
    var mensaje;
    for (var i = 0; i < palabra.length; i++) {
        if (palabra[i] == palabra[i].toUpperCase()) {
            mayus++;
        }
        else {
            minus++;
        }
    }
    if (mayus > 0 && minus == 0) {
        mensaje = "La palabra solo tiene mayusculas";
    }
    else if (mayus == 0 && minus > 0) {
        mensaje = "La palabra solo tiene minusculas";
    }
    else {
        mensaje = "La palabra es mixta";
    }
    console.log(mensaje);
}
ValidarPalabra("Arbol");
ValidarPalabra("arbol");
ValidarPalabra("ARBOL");
//# sourceMappingURL=Ejer10.js.map