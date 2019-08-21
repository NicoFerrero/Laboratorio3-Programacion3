"use strict";
window.onload = function () {
    MostrarLista();
};
function SubirFoto() {
    var xhr = new XMLHttpRequest();
    var foto = document.getElementById("foto");
    var nombre = document.getElementById("nombre").value;
    var legajo = document.getElementById("legajo").value;
    var form = new FormData();
    form.append('foto', foto.files[0]);
    form.append("nombre", nombre);
    form.append("legajo", legajo);
    form.append('op', "subirFoto");
    xhr.open('POST', './BACKEND/nexo.php', true);
    xhr.setRequestHeader("enctype", "multipart/form-data");
    if (nombre !== "" && legajo !== "") {
        xhr.send(form);
    }
    else {
        alert("Debe ingresar nombre y legajo");
    }
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log(xhr.responseText);
            var retJSON = JSON.parse(xhr.responseText);
            if (!retJSON.Ok) {
                console.error("NO se agrego el empleado!!!");
            }
            else {
                console.info("Empleado agregado!!!");
                document.getElementById("imgFoto").src = "./BACKEND/" + retJSON.Path;
                MostrarLista();
                document.getElementById("foto").value = "";
                document.getElementById("imgFoto").src = "./BACKEND/usr_default.jpg";
                document.getElementById("nombre").value = "";
                document.getElementById("legajo").value = "";
            }
        }
    };
}
function MostrarLista() {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', './BACKEND/nexo.php', true);
    xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
    xhr.send("op=mostrarListado");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("tabla").innerHTML = xhr.responseText;
        }
    };
}
function Eliminar(obj) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', './BACKEND/nexo.php', true);
    xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var retJSON = JSON.parse(xhr.responseText);
            if (!retJSON.Ok) {
                console.error("NO se elimino el empleado!!!");
            }
            else {
                console.info("Empleado eliminado!!!");
                MostrarLista();
            }
        }
    };
    if (confirm("Esta seguro que quiere eleiminar a " + obj.nombre + " legajo " + obj.legajo + "?")) {
        xhr.send("op=eliminar&obj=" + JSON.stringify(obj));
    }
}
function Modificar(obj) {
    var xhr = new XMLHttpRequest();
    var empleado = obj;
    document.getElementById("agregar").value = "Modificar";
    var nombre = document.getElementById("nombre").value = empleado.nombre;
    var legajo = document.getElementById("legajo").value = empleado.legajo;
    document.getElementById("legajo").readOnly = true;
    document.getElementById("imgFoto").src = "./BACKEND/" + obj.path;
    xhr.open('POST', './BACKEND/nexo.php', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var retJSON = JSON.parse(xhr.responseText);
            if (!retJSON.Ok) {
                console.error("NO se modifico el empleado!!!");
            }
            else {
                console.info("Empleado modificado!!!");
                MostrarLista();
                var nombre_1 = document.getElementById("nombre").value = "";
                var legajo_1 = document.getElementById("legajo").value = "";
                var foto = document.getElementById("foto").value = "";
                document.getElementById("agregar").value = "Agregar";
                document.getElementById("agregar").onclick = SubirFoto;
                document.getElementById("legajo").readOnly = false;
                document.getElementById("imgFoto").src = "./BACKEND/usr_default.jpg";
            }
        }
    };
    document.getElementById("agregar").onclick = function () {
        var form = new FormData();
        nombre = document.getElementById("nombre").value;
        legajo = document.getElementById("legajo").value;
        var foto = document.getElementById("foto");
        form.append('foto', foto.files[0]);
        form.append("nombre", nombre);
        form.append("legajo", legajo);
        form.append('op', "modificar");
        if (confirm("Esta seguro que desea modificar al empleado?")) {
            xhr.send(form);
        }
    };
}
//# sourceMappingURL=ejemplo.js.map