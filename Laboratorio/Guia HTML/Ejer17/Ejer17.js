"use strict";
function EnviarPeliculas() {
    var peliculas = [""];
    if (document.getElementById("Troya").checked == true) {
        peliculas.push("troya");
    }
    if (document.getElementById("HP1").checked == true) {
        peliculas.push("Harry Potter 1");
    }
    if (document.getElementById("SW").checked == true) {
        peliculas.push("Star Wars");
    }
    if (document.getElementById("SR1").checked == true) {
        peliculas.push("Señor de los anillos y la comunidad de los anillos");
    }
    for (var i = 0; i < peliculas.length; i++) {
        console.log(peliculas[i] + "\n");
    }
}
//# sourceMappingURL=Ejer17.js.map