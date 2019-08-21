"use strict";
/// <reference path="./Ente.ts" />
/// <reference path="./Alien.ts" />
window.onload = function () {
    RecuperatorioPrimerParcial.Manejadora.MostrarAliens();
    if (localStorage.getItem("Aliens_local_storage") === null) {
        RecuperatorioPrimerParcial.Manejadora.GuardarEnLocalStorage();
    }
};
var RecuperatorioPrimerParcial;
(function (RecuperatorioPrimerParcial) {
    var Manejadora = /** @class */ (function () {
        function Manejadora() {
        }
        Manejadora.AgregarAlien = function () {
            var cuadrante = document.getElementById("cuadrante").value;
            var edad = parseInt(document.getElementById("edad").value, 10);
            var altura = parseFloat(document.getElementById("altura").value);
            var raza = document.getElementById("raza").value;
            var planetaOrigen = document.getElementById("cboPlaneta").value;
            var foto = document.getElementById("foto");
            var path = document.getElementById("foto").value;
            var pathFoto;
            if (path !== "") {
                pathFoto = cuadrante + "_" + (path.split('\\'))[2];
            }
            else {
                pathFoto = "alien_defecto.jpg";
            }
            var alien = new Entidades.Alien(cuadrante, edad, altura, raza, planetaOrigen, pathFoto);
            var caso = "agregar";
            if (document.getElementById("hdnIdModificacion").value === "modificar") {
                caso = "modificar";
            }
            var form = new FormData();
            form.append("caso", caso);
            form.append("cadenaJson", alien.ToJSON());
            if (foto.files[0] !== null) {
                form.append("foto", foto.files[0]);
            }
            var conexion = new XMLHttpRequest();
            conexion.open("POST", "BACKEND/administrar.php", true);
            conexion.setRequestHeader('enctype', 'multipart/form-data');
            conexion.send(form);
            conexion.onreadystatechange = function () {
                if (conexion.status == 200 && conexion.readyState == 4) {
                    var rta = JSON.parse(conexion.responseText);
                    if (rta.TodoOK && rta.caso === "agregar") {
                        alert("Alien agregado");
                    }
                    else if (rta.TodoOK && rta.caso === "modificar") {
                        alert("Alien modificado");
                        document.getElementById("cuadrante").readOnly = false;
                        document.getElementById("raza").readOnly = false;
                        document.getElementById("btn-agregar").value = "Agregar";
                        document.getElementById("hdnIdModificacion").value = "agregar";
                    }
                    localStorage.clear();
                    Manejadora.GuardarEnLocalStorage();
                    RecuperatorioPrimerParcial.Manejadora.MostrarAliens();
                    Manejadora.LimpiarCampos();
                }
            };
        };
        Manejadora.MostrarAliens = function () {
            var conexion = new XMLHttpRequest();
            conexion.open("POST", "BACKEND/administrar.php", true);
            conexion.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            conexion.send("caso=traer");
            var tabla = "<table border=\"1\">\n                            <thead>\n                                <th>Cuadrante</th>\n                                <th>Edad</th>\n                                <th>Altura</th>\n                                <th>Raza</th>\n                                <th>Planeta Origen</th>\n                                <th>Foto</th>\n                                <th>Eliminar</th>\n                                <th>Modificar</th>\n                            </thead>";
            conexion.onreadystatechange = function () {
                if (conexion.status == 200 && conexion.readyState == 4) {
                    var aliens = JSON.parse(conexion.responseText);
                    aliens.forEach(function (alien) {
                        var alienAux = new Entidades.Alien(alien.cuadrante, alien.edad, alien.altura, alien.raza, alien.planetaOrigen, alien.pathFoto);
                        tabla += "<tr>\n                                    <td>" + alienAux.cuadrante + "</td>\n                                    <td>" + alienAux.edad + "</td>\n                                    <td>" + alienAux.altura + "</td>\n                                    <td>" + alienAux.raza + "</td>\n                                    <td>" + alienAux.planetaOrigen + "</td>\n                                    <td><img src=./BACKEND/fotos/" + alienAux.pathFoto + " height=\"90\" width=\"90\"</img></td>\n                                    <td><input type=\"button\" value=\"Eliminar\" id=" + alienAux.ToJSON() + " onclick=\"RecuperatorioPrimerParcial.Manejadora.EliminarAlien(id)\"/></td>\n                                    <td><input type=\"button\" value=\"Modificar\" id=" + alienAux.ToJSON() + " onclick=\"RecuperatorioPrimerParcial.Manejadora.ModificarAlien(id)\"/></td>\n                                  </tr>";
                    });
                    tabla += "</table>";
                    document.getElementById("divTabla").innerHTML = tabla;
                }
            };
        };
        Manejadora.GuardarEnLocalStorage = function () {
            var conexion = new XMLHttpRequest();
            conexion.open("POST", "BACKEND/administrar.php", true);
            conexion.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            conexion.send("caso=traer");
            conexion.onreadystatechange = function () {
                if (conexion.readyState == 4 && conexion.status == 200) {
                    localStorage.setItem("Aliens_local_storage", (conexion.responseText));
                }
            };
        };
        Manejadora.VerificarExistencia = function () {
            var cuadrante = document.getElementById("cuadrante").value;
            var raza = document.getElementById("raza").value;
            var existe = false;
            if (localStorage.getItem("Aliens_local_storage") !== "") {
                var aliens = JSON.parse(localStorage.getItem("Aliens_local_storage"));
                for (var i = 0; i < aliens.length; i++) {
                    if (cuadrante == aliens[i].cuadrante && raza == aliens[i].raza) {
                        console.log("YA EXISTE UN ALIEN CON ESA RAZA Y CUADRANTE");
                        alert("YA EXISTE UN ALIEN CON ESA RAZA Y CUADRANTE");
                        existe = true;
                        break;
                    }
                }
                if (existe != true) {
                    Manejadora.AgregarAlien();
                }
            }
        };
        Manejadora.ObtenerAliensPorCuadrante = function () {
            var auxContador = new Array();
            var auxLocalStorage = "";
            if (localStorage.getItem("Aliens_local_storage") !== "") {
                auxLocalStorage = localStorage.getItem("Aliens_local_storage");
                var auxJson = JSON.parse(auxLocalStorage);
                for (var _i = 0, auxJson_1 = auxJson; _i < auxJson_1.length; _i++) {
                    var alien = auxJson_1[_i];
                    if (auxContador[alien.cuadrante] === undefined) {
                        auxContador[alien.cuadrante] = 0;
                    }
                    auxContador[alien.cuadrante]++;
                }
                var auxMax = undefined;
                var auxMin = undefined;
                for (var cuadrante in auxContador) {
                    if (auxMax === undefined && auxMin === undefined) {
                        auxMax = auxContador[cuadrante];
                        auxMin = auxContador[cuadrante];
                    }
                    var cantAliens = auxContador[cuadrante];
                    if (auxMax < cantAliens) {
                        auxMax = cantAliens;
                    }
                    if (auxMin > cantAliens) {
                        auxMin = cantAliens;
                    }
                }
                var cuadrantesMax = new Array();
                var cuadrantesMin = new Array();
                for (var cuadrante in auxContador) {
                    if (auxContador[cuadrante] == auxMax) {
                        cuadrantesMax.push(cuadrante);
                    }
                    else if (auxContador[cuadrante] == auxMin) {
                        cuadrantesMin.push(cuadrante);
                    }
                }
                var mensaje = "El/Los cuadrantes con mas aliens son ";
                if (cuadrantesMax.length > 0) {
                    for (var _a = 0, cuadrantesMax_1 = cuadrantesMax; _a < cuadrantesMax_1.length; _a++) {
                        var cuadrante = cuadrantesMax_1[_a];
                        mensaje += "\n-" + cuadrante;
                    }
                    mensaje += "\nCon " + auxMax;
                    console.log(mensaje);
                }
                if (cuadrantesMin.length > 0) {
                    mensaje = "El/Los cuadrantes con menos aliens son ";
                    for (var _b = 0, cuadrantesMin_1 = cuadrantesMin; _b < cuadrantesMin_1.length; _b++) {
                        var cuadrante = cuadrantesMin_1[_b];
                        mensaje += "\n-" + cuadrante;
                    }
                    mensaje += "\nCon " + auxMin;
                    console.log(mensaje);
                }
            }
        };
        Manejadora.EliminarAlien = function (id) {
            var conexion = new XMLHttpRequest();
            conexion.open("POST", "BACKEND/administrar.php", true);
            conexion.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            var alien = JSON.parse(id);
            conexion.onreadystatechange = function () {
                if (conexion.readyState == 4 && conexion.status == 200) {
                    var rta = JSON.parse(conexion.responseText);
                    if (rta.TodoOK) {
                        localStorage.clear();
                        Manejadora.GuardarEnLocalStorage();
                        console.log("OBJETO BORRADO");
                        Manejadora.MostrarAliens();
                    }
                    console.log(conexion.responseText);
                }
            };
            if (confirm("Desea borrar el alien del cuadrante " + alien.cuadrante + " y la raza " + alien.raza)) {
                conexion.send("caso=eliminar&cadenaJson=" + id);
            }
        };
        Manejadora.ModificarAlien = function (id) {
            var alien = JSON.parse(id);
            document.getElementById("btn-agregar").value = "Modificar";
            var cuadrante = document.getElementById("cuadrante").value = alien.cuadrante;
            document.getElementById("cuadrante").readOnly = true;
            document.getElementById("raza").readOnly = true;
            var edad = document.getElementById("edad").value = alien.edad;
            var altura = document.getElementById("altura").value = alien.altura;
            var raza = document.getElementById("raza").value = alien.raza;
            var planetaOrigen = document.getElementById("cboPlaneta").value = alien.planetaOrigen;
            document.getElementById("imgFoto").src = "./BACKEND/fotos/" + alien.pathFoto;
            document.getElementById("hdnIdModificacion").value = "modificar";
        };
        Manejadora.CargarPlanetas = function () {
            var selector = document.getElementById("cboPlaneta");
            do {
                selector.remove(0);
            } while (selector.length > 0);
            var conexion = new XMLHttpRequest();
            conexion.open("POST", "BACKEND/administrar.php", true);
            conexion.onreadystatechange = function () {
                if (conexion.readyState == 4 && conexion.status == 200) {
                    var planetas = JSON.parse(conexion.responseText);
                    for (var i = 0; i < planetas.length; i++) {
                        var opcion = document.createElement("option");
                        opcion.text = planetas[i].descripcion;
                        selector.add(opcion);
                    }
                    document.getElementById("cboPlaneta").selectedIndex = 0;
                }
            };
            conexion.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            conexion.send("caso=planetas");
        };
        Manejadora.FiltrarPorPlaneta = function () {
            var planeta = document.getElementById("cboPlaneta").value;
            var tabla = "<table border=\"1\">\n                            <thead>\n                                <th>Cuadrante</th>\n                                <th>Edad</th>\n                                <th>Altura</th>\n                                <th>Raza</th>\n                                <th>Planeta Origen</th>\n                                <th>Foto</th>\n                                <th>Eliminar</th>\n                                <th>Modificar</th>\n                            </thead>";
            var conexion = new XMLHttpRequest();
            conexion.open("POST", "BACKEND/administrar.php", true);
            conexion.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            conexion.send("caso=filtrar&planeta=" + planeta);
            conexion.onreadystatechange = function () {
                if (conexion.readyState == 4 && conexion.status == 200) {
                    var aliens = JSON.parse(conexion.responseText);
                    aliens.forEach(function (alien) {
                        var alienAux = new Entidades.Alien(alien.cuadrante, alien.edad, alien.altura, alien.raza, alien.planetaOrigen, alien.pathFoto);
                        tabla += "<tr>\n                                    <td>" + alienAux.cuadrante + "</td>\n                                    <td>" + alienAux.edad + "</td>\n                                    <td>" + alienAux.altura + "</td>\n                                    <td>" + alienAux.raza + "</td>\n                                    <td>" + alienAux.planetaOrigen + "</td>\n                                    <td><img src=./BACKEND/fotos/" + alienAux.pathFoto + " height=\"90\" width=\"90\"</img></td>\n                                    <td><input type=\"button\" value=\"Eliminar\" id=" + alienAux.ToJSON() + " onclick=\"RecuperatorioPrimerParcial.Manejadora.EliminarAlien(id)\"/></td>\n                                    <td><input type=\"button\" value=\"Modificar\" id=" + alienAux.ToJSON() + " onclick=\"RecuperatorioPrimerParcial.Manejadora.ModificarAlien(id)\"/></td>\n                                  </tr>";
                    });
                    tabla += "</table>";
                    document.getElementById("divTabla").innerHTML = tabla;
                }
            };
        };
        Manejadora.LimpiarCampos = function () {
            document.getElementById("cuadrante").value = "";
            document.getElementById("edad").value = "";
            document.getElementById("altura").value = "";
            document.getElementById("raza").value = "";
            document.getElementById("cboPlaneta").selectedIndex = 0;
            document.getElementById("foto").value = "";
            document.getElementById("imgFoto").src = "./BACKEND/fotos/alien_defecto.jpg";
        };
        return Manejadora;
    }());
    RecuperatorioPrimerParcial.Manejadora = Manejadora;
})(RecuperatorioPrimerParcial || (RecuperatorioPrimerParcial = {}));
//# sourceMappingURL=Manejadora.js.map