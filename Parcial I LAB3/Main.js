var __extends = (this && this.__extends) || (function () {
    var extendStatics = function (d, b) {
        extendStatics = Object.setPrototypeOf ||
            ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
            function (d, b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
        return extendStatics(d, b);
    }
    return function (d, b) {
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
var Entidades;
(function (Entidades) {
    var Mascota = /** @class */ (function () {
        function Mascota(tamanio, edad, precio) {
            this.tamanio = tamanio;
            this.edad = edad;
            this.precio = precio;
        }
        Mascota.prototype.ToString = function () {
            return "\"tamanio\":\"" + this.tamanio + "\",\"edad\":" + this.edad + ",\"precio\":" + this.precio + ",";
        };
        return Mascota;
    }());
    Entidades.Mascota = Mascota;
})(Entidades || (Entidades = {}));
/// <reference path="./Mascota.ts" />
var Entidades;
(function (Entidades) {
    var Perro = /** @class */ (function (_super) {
        __extends(Perro, _super);
        function Perro(tamanio, edad, precio, nombre, raza, pathFoto) {
            var _this = _super.call(this, tamanio, edad, precio) || this;
            _this.nombre = nombre;
            _this.raza = raza;
            _this.pathFoto = pathFoto;
            return _this;
        }
        Perro.prototype.ToJSON = function () {
            return "{" + _super.prototype.ToString.call(this) + "\"nombre\":\"" + this.nombre + "\",\"raza\":\"" + this.raza + "\",\"pathFoto\":\"" + this.pathFoto + "\"}";
        };
        return Perro;
    }(Entidades.Mascota));
    Entidades.Perro = Perro;
})(Entidades || (Entidades = {}));
/// <reference path="./Mascota.ts" />
/// <reference path="./Perro.ts" />
/// <reference path="./IParte2.ts" />
/*(<Window>window).onload = () => {
    PrimerParcial.Manejadora.MostrarPerrosBaseDatos();
}*/
var PrimerParcial;
(function (PrimerParcial) {
    var Manejadora = /** @class */ (function () {
        function Manejadora() {
        }
        Manejadora.AgregarPerroJSON = function () {
            var tamanio = document.getElementById("tamanio").value;
            var edad = parseInt(document.getElementById("edad").value, 10);
            var precio = parseFloat(document.getElementById("precio").value);
            var nombre = document.getElementById("nombre").value;
            var raza = document.getElementById("cboRaza").value;
            var foto = document.getElementById("foto");
            var path = document.getElementById("foto").value;
            var fecha = new Date();
            var pathFoto;
            if (path !== "") {
                pathFoto = nombre + "." + ("" + fecha.getDate() + fecha.getMonth() + fecha.getFullYear() + "_" + fecha.getHours() + fecha.getMinutes() + fecha.getSeconds() + ".jpg");
            }
            else {
                pathFoto = "perro_default.png";
            }
            var perro = new Entidades.Perro(tamanio, edad, precio, nombre, raza, pathFoto);
            var form = new FormData();
            form.append("caso", "agregar");
            form.append("cadenaJson", perro.ToJSON());
            if (foto.files[0] !== null) {
                form.append("foto", foto.files[0]);
            }
            var conexion = new XMLHttpRequest();
            conexion.open("POST", "BACKEND/agregar_json.php", true);
            conexion.setRequestHeader('enctype', 'multipart/form-data');
            if (Manejadora.AdministrarValidaciones()) {
                Manejadora.AdministrarSpinner(true);
                conexion.send(form);
            }
            conexion.onreadystatechange = function () {
                if (conexion.status == 200 && conexion.readyState == 4) {
                    var rta = JSON.parse(conexion.responseText);
                    if (rta.TodoOK && rta.caso === "agregar") {
                        alert("Perro agregado");
                    }
                    Manejadora.LimpiarCampos();
                    Manejadora.MostrarJSON();
                    Manejadora.AdministrarSpinner(false);
                }
            };
        };
        Manejadora.MostrarJSON = function () {
            var conexion = new XMLHttpRequest();
            conexion.open("POST", "BACKEND/traer_json.php", true);
            conexion.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            conexion.send("caso=traer");
            Manejadora.AdministrarSpinner(true);
            var tabla = "<table border=\"1\" id=\"tabla\">\n                            <thead>\n                                <th>Taman\u00F1o</th>\n                                <th>Edad</th>\n                                <th>Precio</th>\n                                <th>Nombre</th>\n                                <th>Raza</th>\n                                <th>Foto</th>\n                                <th>Eliminar</th>\n                                <th>Modificar</th>\n                            </thead>";
            conexion.onreadystatechange = function () {
                if (conexion.status == 200 && conexion.readyState == 4) {
                    var perros = JSON.parse(conexion.responseText);
                    perros.forEach(function (perro) {
                        var perroAux = new Entidades.Perro(perro.tamanio, perro.edad, perro.precio, perro.nombre, perro.raza, perro.pathFoto);
                        tabla += "<tr>\n                                    <td>" + perroAux.tamanio + "</td>\n                                    <td>" + perroAux.edad + "</td>\n                                    <td>" + perroAux.precio + "</td>\n                                    <td>" + perroAux.nombre + "</td>\n                                    <td>" + perroAux.raza + "</td>\n                                    <td><img src=./BACKEND/fotos/" + perroAux.pathFoto + " height=\"90\" width=\"90\"</img></td>\n                                    <td><input type=\"button\" value=\"Eliminar\" id=" + perroAux.ToJSON() + " onclick=\"\"/></td>\n                                    <td><input type=\"button\" value=\"Modificar\" id=" + perroAux.ToJSON() + " onclick=\"\"/></td>\n                                  </tr>";
                    });
                    tabla += "</table>";
                    document.getElementById("divTabla").innerHTML = tabla;
                    Manejadora.AdministrarSpinner(false);
                }
            };
        };
        Manejadora.AgregarPerroEnBaseDeDatos = function () {
            var tamanio = document.getElementById("tamanio").value;
            var edad = parseInt(document.getElementById("edad").value, 10);
            var precio = parseFloat(document.getElementById("precio").value);
            var nombre = document.getElementById("nombre").value;
            var raza = document.getElementById("cboRaza").value;
            var foto = document.getElementById("foto");
            var path = document.getElementById("foto").value;
            var fecha = new Date();
            var pathFoto;
            if (path !== "") {
                pathFoto = nombre + "." + ("" + fecha.getDate() + fecha.getMonth() + fecha.getFullYear() + "_" + fecha.getHours() + fecha.getMinutes() + fecha.getSeconds() + ".jpg");
            }
            else {
                pathFoto = "perro_default.jpg";
            }
            var perro = new Entidades.Perro(tamanio, edad, precio, nombre, raza, pathFoto);
            var form = new FormData();
            var caso = "agregarBD";
            if (document.getElementById("hdnIdModificacion").value === "modificar") {
                caso = "modificar";
                form.append("perroModificar", localStorage.getItem("perroModificar"));
            }
            form.append("caso", caso);
            form.append("cadenaJson", perro.ToJSON());
            if (foto.files[0] !== null) {
                form.append("foto", foto.files[0]);
            }
            var conexion = new XMLHttpRequest();
            conexion.open("POST", "BACKEND/agregar_bd.php", true);
            conexion.setRequestHeader('enctype', 'multipart/form-data');
            if (Manejadora.AdministrarValidaciones()) {
                Manejadora.AdministrarSpinner(true);
                conexion.send(form);
            }
            conexion.onreadystatechange = function () {
                if (conexion.status == 200 && conexion.readyState == 4) {
                    var rta = JSON.parse(conexion.responseText);
                    if (rta.TodoOK && rta.caso === "agregar") {
                        alert("Perro agregado");
                    }
                    else if (rta.TodoOK && rta.caso === "modificar") {
                        alert("Perro modificado");
                        document.getElementById("nombre").readOnly = false;
                        document.getElementById("btn-agregar").value = "Agregar en BD";
                        document.getElementById("hdnIdModificacion").value = "agregar";
                    }
                    localStorage.clear();
                    Manejadora.LimpiarCampos();
                    Manejadora.MostrarPerrosBaseDatos();
                    Manejadora.AdministrarSpinner(false);
                }
            };
        };
        Manejadora.VerificarExistencia = function () {
            var edad = document.getElementById("edad").value;
            var raza = document.getElementById("cboRaza").value;
            var existe = false;
            if (localStorage.getItem("perros_bd") !== "") {
                var perros = JSON.parse(localStorage.getItem("perros_bd"));
                for (var i = 0; i < perros.length; i++) {
                    if (edad == perros[i].edad && raza == perros[i].raza) {
                        console.log("YA EXISTE UN PERRO CON ESA RAZA Y EDAD");
                        alert("YA EXISTE UN PERRO CON ESA RAZA Y EDAD");
                        existe = true;
                        break;
                    }
                }
                if (existe != true) {
                    Manejadora.AgregarPerroEnBaseDeDatos();
                }
            }
        };
        Manejadora.MostrarPerrosBaseDatos = function () {
            var conexion = new XMLHttpRequest();
            conexion.open("POST", "BACKEND/traer_bd.php", true);
            conexion.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            conexion.send("caso=traerBD");
            Manejadora.AdministrarSpinner(true);
            var tabla = "<table border=\"1\" id=\"tabla\">\n                            <thead>\n                                <th>Taman\u00F1o</th>\n                                <th>Edad</th>\n                                <th>Precio</th>\n                                <th>Nombre</th>\n                                <th>Raza</th>\n                                <th>Foto</th>\n                                <th>Eliminar</th>\n                                <th>Modificar</th>\n                            </thead>";
            conexion.onreadystatechange = function () {
                if (conexion.status == 200 && conexion.readyState == 4) {
                    var perros = JSON.parse(conexion.responseText);
                    localStorage.setItem("perros_bd", conexion.responseText);
                    perros.forEach(function (perro) {
                        var perroAux = new Entidades.Perro(perro.tamanio, perro.edad, perro.precio, perro.nombre, perro.raza, perro.pathFoto);
                        tabla += "<tr>\n                                    <td>" + perroAux.tamanio + "</td>\n                                    <td>" + perroAux.edad + "</td>\n                                    <td>" + perroAux.precio + "</td>\n                                    <td>" + perroAux.nombre + "</td>\n                                    <td>" + perroAux.raza + "</td>\n                                    <td><img src=./BACKEND/fotos/" + perroAux.pathFoto + " height=\"90\" width=\"90\"</img></td>\n                                    <td><input type=\"button\" value=\"Eliminar\" id=" + perroAux.ToJSON() + " onclick=\"PrimerParcial.Manejadora.Eliminar(id)\"/></td>\n                                    <td><input type=\"button\" value=\"Modificar\" id=" + perroAux.ToJSON() + " onclick=\"PrimerParcial.Manejadora.Modificar(id)\"/></td>\n                                  </tr>";
                    });
                    tabla += "</table>";
                    document.getElementById("divTabla").innerHTML = tabla;
                    Manejadora.AdministrarSpinner(false);
                }
            };
        };
        Manejadora.Eliminar = function (id) {
            var manejadora = new Manejadora();
            manejadora.EliminarPero(id);
        };
        Manejadora.Modificar = function (id) {
            var manejadora = new Manejadora();
            manejadora.ModificarPerro(id);
        };
        Manejadora.prototype.EliminarPero = function (id) {
            var conexion = new XMLHttpRequest();
            conexion.open("POST", "BACKEND/eliminar_bd.php", true);
            conexion.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            var perro = JSON.parse(id);
            Manejadora.AdministrarSpinner(true);
            conexion.onreadystatechange = function () {
                if (conexion.readyState == 4 && conexion.status == 200) {
                    var rta = JSON.parse(conexion.responseText);
                    if (rta.TodoOK) {
                        localStorage.clear();
                        console.log("OBJETO BORRADO");
                        Manejadora.MostrarPerrosBaseDatos();
                    }
                    console.log(conexion.responseText);
                    Manejadora.AdministrarSpinner(false);
                }
            };
            if (confirm("Desea borrar el perro " + perro.nombre + " y la raza " + perro.raza)) {
                conexion.send("caso=eliminar&cadenaJson=" + id);
            }
        };
        Manejadora.prototype.ModificarPerro = function (id) {
            var perro = JSON.parse(id);
            document.getElementById("btn-agregar").value = "Modificar en BD";
            var nombre = document.getElementById("nombre").value = perro.nombre;
            document.getElementById("nombre").readOnly = true;
            var edad = document.getElementById("edad").value = perro.edad;
            var precio = document.getElementById("precio").value = perro.precio;
            var raza = document.getElementById("cboRaza").value = perro.raza;
            var tamanio = document.getElementById("tamanio").value = perro.tamanio;
            document.getElementById("imgFoto").src = "./BACKEND/fotos/" + perro.pathFoto;
            document.getElementById("hdnIdModificacion").value = "modificar";
            localStorage.setItem("perroModificar", id);
        };
        Manejadora.ObtenerPerrosPorTamanio = function () {
            var auxContador = new Array();
            var auxLocalStorage = "";
            if (localStorage.getItem("perros_bd") !== "") {
                auxLocalStorage = localStorage.getItem("perros_bd");
                var auxJson = JSON.parse(auxLocalStorage);
                for (var _i = 0, auxJson_1 = auxJson; _i < auxJson_1.length; _i++) {
                    var perro = auxJson_1[_i];
                    if (auxContador[perro.tamanio] === undefined) {
                        auxContador[perro.tamanio] = 0;
                    }
                    auxContador[perro.tamanio]++;
                }
                var auxMax = undefined;
                var auxMin = undefined;
                for (var tamanio in auxContador) {
                    if (auxMax === undefined && auxMin === undefined) {
                        auxMax = auxContador[tamanio];
                        auxMin = auxContador[tamanio];
                    }
                    var cantPerros = auxContador[tamanio];
                    if (auxMax < cantPerros) {
                        auxMax = cantPerros;
                    }
                    if (auxMin > cantPerros) {
                        auxMin = cantPerros;
                    }
                }
                var tamaniosMax = new Array();
                var tamaniosMin = new Array();
                for (var tamanio in auxContador) {
                    if (auxContador[tamanio] == auxMax) {
                        tamaniosMax.push(tamanio);
                    }
                    else if (auxContador[tamanio] == auxMin) {
                        tamaniosMin.push(tamanio);
                    }
                }
                var mensaje = "El/Los tamaños con mas perros son ";
                if (tamaniosMax.length > 0) {
                    for (var _a = 0, tamaniosMax_1 = tamaniosMax; _a < tamaniosMax_1.length; _a++) {
                        var tamanio = tamaniosMax_1[_a];
                        mensaje += "\n-" + tamanio;
                    }
                    mensaje += "\nCon " + auxMax;
                    console.log(mensaje);
                }
                if (tamaniosMin.length > 0) {
                    mensaje = "El/Los tamaños con menos perros son ";
                    for (var _b = 0, tamaniosMin_1 = tamaniosMin; _b < tamaniosMin_1.length; _b++) {
                        var tamanio = tamaniosMin_1[_b];
                        mensaje += "\n-" + tamanio;
                    }
                    mensaje += "\nCon " + auxMin;
                    console.log(mensaje);
                }
            }
        };
        Manejadora.CargarRazasJSON = function () {
            var selector = document.getElementById("cboRaza");
            do {
                selector.remove(0);
            } while (selector.length > 0);
            var conexion = new XMLHttpRequest();
            conexion.open("GET", "BACKEND/razas.php", true);
            Manejadora.AdministrarSpinner(true);
            conexion.onreadystatechange = function () {
                if (conexion.readyState == 4 && conexion.status == 200) {
                    var planetas = JSON.parse(conexion.responseText);
                    for (var i = 0; i < planetas.length; i++) {
                        var opcion = document.createElement("option");
                        opcion.text = planetas[i].descripcion;
                        selector.add(opcion);
                    }
                    document.getElementById("cboRaza").selectedIndex = 0;
                    Manejadora.AdministrarSpinner(false);
                }
            };
            conexion.send();
        };
        Manejadora.FiltrarPerrosPorRaza = function () {
            var raza = document.getElementById("cboRaza").value;
            var tabla = "<table border=\"1\" id=\"tabla\">\n                            <thead>\n                                <th>Taman\u00F1o</th>\n                                <th>Edad</th>\n                                <th>Precio</th>\n                                <th>Nombre</th>\n                                <th>Raza</th>\n                                <th>Foto</th>\n                                <th>Eliminar</th>\n                                <th>Modificar</th>\n                            </thead>";
            var conexion = new XMLHttpRequest();
            conexion.open("POST", "BACKEND/filtrar.php", true);
            conexion.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            conexion.send("raza=" + raza);
            Manejadora.AdministrarSpinner(true);
            conexion.onreadystatechange = function () {
                if (conexion.readyState == 4 && conexion.status == 200) {
                    var perros = JSON.parse(conexion.responseText);
                    perros.forEach(function (perro) {
                        var perroAux = new Entidades.Perro(perro.tamanio, perro.edad, perro.precio, perro.nombre, perro.raza, perro.pathFoto);
                        tabla += "<tr>\n                                    <td>" + perroAux.tamanio + "</td>\n                                    <td>" + perroAux.edad + "</td>\n                                    <td>" + perroAux.precio + "</td>\n                                    <td>" + perroAux.nombre + "</td>\n                                    <td>" + perroAux.raza + "</td>\n                                    <td><img src=./BACKEND/fotos/" + perroAux.pathFoto + " height=\"90\" width=\"90\"</img></td>\n                                    <td><input type=\"button\" value=\"Eliminar\" id=" + perroAux.ToJSON() + " onclick=\"PrimerParcial.Manejadora.Eliminar(id)\"/></td>\n                                    <td><input type=\"button\" value=\"Modificar\" id=" + perroAux.ToJSON() + " onclick=\"PrimerParcial.Manejadora.Modificar(id)\"/></td>\n                                </tr>";
                    });
                    tabla += "</table>";
                    document.getElementById("divTabla").innerHTML = tabla;
                    Manejadora.AdministrarSpinner(false);
                }
            };
        };
        Manejadora.AdministrarSpinner = function (mostrar) {
            var div = document.getElementById("divSpinner");
            var img = document.getElementById("imgSpinner");
            if (mostrar) {
                div.style.display = "block";
                div.style.top = "50%";
                div.style.left = "45%";
                img.src = "./BACKEND/gif-load.gif";
            }
            if (!mostrar) {
                div.style.display = "none";
                img.src = "";
            }
        };
        Manejadora.ValidarCamposVacios = function (id) {
            var rta = true;
            if (document.getElementById(id).value.length == 0) {
                rta = false;
                console.log("Debe completar el campo " + document.getElementById(id).name);
            }
            return rta;
        };
        Manejadora.ValidarEdad = function (value) {
            var rta = true;
            if (value < 0 || value > 17 || isNaN(value) == true) {
                rta = false;
                console.log("El valor ingresado debe estar entre los rangos 0 y 18");
            }
            return rta;
        };
        Manejadora.ValidarRaza = function (raza, razas) {
            var rta = false;
            razas.forEach(function (razaAux) {
                if (razaAux.toLowerCase() === raza.toLowerCase()) {
                    rta = true;
                }
            });
            if (!rta) {
                console.log("Ingreso una raza que no es valida");
            }
            return rta;
        };
        Manejadora.AdministrarSpanError = function (id, ocultar) {
            if (id == "tamanio" && ocultar == true) {
                var span = document.getElementById("spanTamanio");
                span.style.display = "inline";
            }
            else if (id == "tamanio" && ocultar == false) {
                var span = document.getElementById("spanTamanio");
                span.style.display = "none";
            }
            if (id == "edad" && ocultar == true) {
                var span = document.getElementById("spanEdad");
                span.style.display = "inline";
            }
            else if (id == "edad" && ocultar == false) {
                var span = document.getElementById("spanEdad");
                span.style.display = "none";
            }
            if (id == "precio" && ocultar == true) {
                var span = document.getElementById("spanPrecio");
                span.style.display = "inline";
            }
            else if (id == "precio" && ocultar == false) {
                var span = document.getElementById("spanPrecio");
                span.style.display = "none";
            }
            if (id == "nombre" && ocultar == true) {
                var span = document.getElementById("spanNombre");
                span.style.display = "inline";
            }
            else if (id == "nombre" && ocultar == false) {
                var span = document.getElementById("spanNombre");
                span.style.display = "none";
            }
            if (id == "cboRaza" && ocultar == true) {
                var span = document.getElementById("spanRaza");
                span.style.display = "inline";
            }
            else if (id == "cboRaza" && ocultar == false) {
                var span = document.getElementById("spanRaza");
                span.style.display = "none";
            }
        };
        Manejadora.VerificarValidaciones = function () {
            var rta = true;
            var campos = document.getElementsByTagName("span");
            for (var i = 0; i < campos.length; i++) {
                if (campos[i].style.display == "inline") {
                    rta = false;
                    break;
                }
            }
            return rta;
        };
        Manejadora.AdministrarValidaciones = function () {
            var rta = true;
            var campos = document.getElementsByTagName("input");
            var edad = parseInt(document.getElementById("edad").value, 10);
            var raza = document.getElementById("cboRaza");
            for (var i = 0; i < campos.length; i++) {
                if (campos[i].type == "text") {
                    Manejadora.AdministrarSpanError(campos[i].id, false);
                }
            }
            for (var i = 0; i < campos.length; i++) {
                if (campos[i].type == "text") {
                    if (!Manejadora.ValidarCamposVacios(campos[i].id)) {
                        Manejadora.AdministrarSpanError(campos[i].id, true);
                    }
                }
            }
            if (!Manejadora.ValidarEdad(edad)) {
                Manejadora.AdministrarSpanError(campos[1].id, true);
            }
            if (!Manejadora.ValidarRaza(raza.value, ["labrador", "caniche"])) {
                Manejadora.AdministrarSpanError(raza.id, true);
            }
            if (!Manejadora.VerificarValidaciones()) {
                rta = false;
            }
            return rta;
        };
        Manejadora.Toggle = function (col) {
            var columna = document.getElementById(col);
            var colAaux = parseInt(col.split("-")[1], 10);
            var tabla = document.getElementById("tabla");
            if (tabla !== null && columna !== null) {
                var n = tabla.rows.length;
                var i, tr, td;
                if (columna.checked) {
                    for (i = 0; i < n; i++) {
                        tr = tabla.rows[i];
                        if (tr.cells.length > colAaux) {
                            td = tr.cells[colAaux];
                            td.style.display = "none";
                        }
                    }
                }
                else {
                    for (i = 0; i < n; i++) {
                        tr = tabla.rows[i];
                        if (tr.cells.length > colAaux) {
                            td = tr.cells[colAaux];
                            td.style.display = "table-cell";
                        }
                    }
                }
            }
        };
        Manejadora.LimpiarCampos = function () {
            document.getElementById("tamanio").value = "";
            document.getElementById("edad").value = "";
            document.getElementById("precio").value = "";
            document.getElementById("nombre").value = "";
            document.getElementById("cboRaza").selectedIndex = 0;
            document.getElementById("foto").value = "";
            document.getElementById("imgFoto").src = "./BACKEND/fotos/perro_default.png";
        };
        return Manejadora;
    }());
    PrimerParcial.Manejadora = Manejadora;
})(PrimerParcial || (PrimerParcial = {}));
