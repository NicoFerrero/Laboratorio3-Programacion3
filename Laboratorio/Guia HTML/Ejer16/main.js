"use strict";
function Manejadora() {
    var nombre = document.getElementById("nombre").value;
    var mail = document.getElementById("mail").value;
    var dni = parseInt(document.getElementById("dni").value);
    var cv = document.getElementById("cv").value;
    var form = document.getElementById("formulario");
    console.log("Nombre: " + nombre + " mail: " + mail + " dni: " + dni + " cv: " + cv);
    form.reset();
}
//# sourceMappingURL=main.js.map