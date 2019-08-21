
(<Window>window).onload = () => {
    MostrarLista();
}
/*! Comentario visible en .js

Función para subir una foto al servidor web y
mostrarla en un tag img, utilizando AJAX

*/

//Comentario no visible en .js

/*Comentario no visible en .js */

function SubirFoto() : void {

    //INSTANCIO OBJETO PARA REALIZAR COMUNICACIONES ASINCRONICAS
    let xhr : XMLHttpRequest = new XMLHttpRequest();

    //RECUPERO LA IMAGEN SELECCIONADA POR EL USUARIO
    let foto : any = (<HTMLInputElement> document.getElementById("foto"));
    let nombre : string = (<HTMLInputElement>document.getElementById("nombre")).value;
    let legajo : string = (<HTMLInputElement>document.getElementById("legajo")).value;

    //INSTANCIO OBJETO FORMDATA
    let form : FormData = new FormData();

    //AGREGO PARAMETROS AL FORMDATA:

    //PARAMETRO RECUPERADO POR $_FILES
    form.append('foto', foto.files[0]);
    form.append("nombre", nombre);
    form.append("legajo", legajo);

    //PARAMETRO RECUPERADO POR $_POST O $_GET (SEGUN CORRESPONDA)
    form.append('op', "subirFoto");

    //METODO; URL; ASINCRONICO?
    xhr.open('POST', './BACKEND/nexo.php', true);

    //ESTABLEZCO EL ENCABEZADO DE LA PETICION
    xhr.setRequestHeader("enctype", "multipart/form-data");

    //ENVIO DE LA PETICION
    if (nombre !== "" && legajo !== "") {
        xhr.send(form);
    } else {
        alert("Debe ingresar nombre y legajo");
    }


    //FUNCION CALLBACK
    xhr.onreadystatechange = () => {

        if (xhr.readyState == 4 && xhr.status == 200) {

            console.log(xhr.responseText);

            let retJSON = JSON.parse(xhr.responseText);
            if(!retJSON.Ok){
                console.error("NO se agrego el empleado!!!");
            }
            else{
                console.info("Empleado agregado!!!");
                (<HTMLImageElement> document.getElementById("imgFoto")).src = "./BACKEND/" + retJSON.Path;
                MostrarLista();
                (<HTMLInputElement>document.getElementById("foto")).value = "";
                (<HTMLInputElement> document.getElementById("imgFoto")).src = "./BACKEND/usr_default.jpg";
                (<HTMLInputElement>document.getElementById("nombre")).value = "";
                (<HTMLInputElement>document.getElementById("legajo")).value = "";
            }
        }
    };
}

function MostrarLista():void{
    let xhr : XMLHttpRequest = new XMLHttpRequest();
    xhr.open('POST', './BACKEND/nexo.php', true);
    xhr.setRequestHeader("content-type","application/x-www-form-urlencoded");
    xhr.send("op=mostrarListado");

    xhr.onreadystatechange = () => {

        if (xhr.readyState == 4 && xhr.status == 200) {

            (<HTMLDivElement>document.getElementById("tabla")).innerHTML = xhr.responseText;
        }
    };
}

function Eliminar(obj : any):void{
    let xhr : XMLHttpRequest = new XMLHttpRequest();
    xhr.open('POST', './BACKEND/nexo.php', true);
    xhr.setRequestHeader("content-type","application/x-www-form-urlencoded");

    xhr.onreadystatechange = () => {

        if (xhr.readyState == 4 && xhr.status == 200) {
            let retJSON = JSON.parse(xhr.responseText);
            if(!retJSON.Ok){
                console.error("NO se elimino el empleado!!!");
            }
            else{
                console.info("Empleado eliminado!!!");
                MostrarLista();
            }
        }
    };

    if(confirm("Esta seguro que quiere eleiminar a " + obj.nombre + " legajo " + obj.legajo + "?")){
        xhr.send("op=eliminar&obj=" + JSON.stringify(obj));
    }
}

function Modificar(obj : any):void{
    let xhr: XMLHttpRequest = new XMLHttpRequest();

    let empleado: any = obj;
    (<HTMLInputElement>document.getElementById("agregar")).value = "Modificar";
    let nombre : string = (<HTMLInputElement>document.getElementById("nombre")).value = empleado.nombre;
    let legajo : string = (<HTMLInputElement>document.getElementById("legajo")).value = empleado.legajo;
    (<HTMLInputElement>document.getElementById("legajo")).readOnly = true;
    (<HTMLInputElement>document.getElementById("imgFoto")).src = "./BACKEND/" + obj.path;

    xhr.open('POST', './BACKEND/nexo.php', true);

    xhr.onreadystatechange = () => {

        if (xhr.readyState == 4 && xhr.status == 200) {
            let retJSON = JSON.parse(xhr.responseText);
            if(!retJSON.Ok){
                console.error("NO se modifico el empleado!!!");
            }
            else{
                console.info("Empleado modificado!!!");
                MostrarLista();
                let nombre : string = (<HTMLInputElement>document.getElementById("nombre")).value = "";
                let legajo: string = (<HTMLInputElement>document.getElementById("legajo")).value = "";
                let foto: any = (<HTMLInputElement>document.getElementById("foto")).value = "";
                (<HTMLInputElement>document.getElementById("agregar")).value = "Agregar";
                (<HTMLInputElement>document.getElementById("agregar")).onclick = SubirFoto;
                (<HTMLInputElement>document.getElementById("legajo")).readOnly = false;
                (<HTMLInputElement>document.getElementById("imgFoto")).src = "./BACKEND/usr_default.jpg";
            }
        }
    };

    (<HTMLInputElement>document.getElementById("agregar")).onclick = () => {
        let form : FormData = new FormData();
        nombre = (<HTMLInputElement>document.getElementById("nombre")).value;
        legajo = (<HTMLInputElement>document.getElementById("legajo")).value
        let foto : any = (<HTMLInputElement> document.getElementById("foto"));
        form.append('foto', foto.files[0]);
        form.append("nombre", nombre);
        form.append("legajo", legajo);

        form.append('op', "modificar");
        if (confirm("Esta seguro que desea modificar al empleado?")) {
            xhr.send(form);
        }
    };

}