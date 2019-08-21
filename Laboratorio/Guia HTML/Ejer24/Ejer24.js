"use strict";
function ValidarIngreso() {
    var name = document.getElementById("name").value;
    var lastName = document.getElementById("lastName").value;
    var dni = document.getElementById("dni").value;
    var sexo = document.getElementById("sexo").value;
    if (name == "" || lastName == "") {
        console.log("El nombre o el apellido no se completaron");
    }
    if (!/^([0-9])*$/.test(dni) || dni == "") 
    //if(!isNaN(parseInt(dni, 10)))
    {
        console.log("El dni no es numerico o el campo esta vacio");
    }
    if (sexo.length != 1) {
        console.log("Este campo debe contener un caracter");
    }
    else {
        for (var i = 0; i < sexo.length; i++) {
            if (sexo[i].toLowerCase() != "m" && sexo[i].toLowerCase() != "f") {
                console.log("Este campo solo admite los caracteres m o f");
            }
        }
    }
}
//# sourceMappingURL=Ejer24.js.map