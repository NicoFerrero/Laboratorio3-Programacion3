/// <reference path="./Mascota.ts" />
/// <reference path="./Perro.ts" />
/// <reference path="./IParte2.ts" />

/*(<Window>window).onload = () => {
    PrimerParcial.Manejadora.MostrarPerrosBaseDatos();
}*/

namespace PrimerParcial{
    export class Manejadora implements IParte2{

        public static AgregarPerroJSON():void{
            let tamanio: string = (<HTMLInputElement>document.getElementById("tamanio")).value;
            let edad: number = parseInt((<HTMLInputElement>document.getElementById("edad")).value, 10);
            let precio: number = parseFloat((<HTMLInputElement>document.getElementById("precio")).value);
            let nombre: string = (<HTMLInputElement>document.getElementById("nombre")).value;
            let raza: string = (<HTMLInputElement>document.getElementById("cboRaza")).value;
            let foto: any = (<HTMLInputElement>document.getElementById("foto"));
            let path: string = (<HTMLInputElement>document.getElementById("foto")).value;
            let fecha = new Date();
            let pathFoto: string;
            if (path !== "") {
                pathFoto = nombre + "." + `${fecha.getDate()}${fecha.getMonth()}${fecha.getFullYear()}_${fecha.getHours()}${fecha.getMinutes()}${fecha.getSeconds()}.jpg`;
            } else {
                pathFoto = "perro_default.png";
            }

            let perro: Entidades.Perro = new Entidades.Perro(tamanio, edad, precio, nombre, raza, pathFoto);

            let form: FormData = new FormData();
            form.append("caso", "agregar");
            form.append("cadenaJson", perro.ToJSON());
            if (foto.files[0] !== null) {
                form.append("foto", foto.files[0]);
            }

            let conexion: XMLHttpRequest = new XMLHttpRequest();
            conexion.open("POST", "BACKEND/agregar_json.php", true);
            conexion.setRequestHeader('enctype', 'multipart/form-data');
            if(Manejadora.AdministrarValidaciones()){
                Manejadora.AdministrarSpinner(true);
                conexion.send(form);
            }
            conexion.onreadystatechange = ()=> {
                if (conexion.status == 200 && conexion.readyState == 4) {
                    let rta: any = JSON.parse(conexion.responseText);
                    if (rta.TodoOK && rta.caso === "agregar") {
                        alert("Perro agregado");
                    }
                    Manejadora.LimpiarCampos();
                    Manejadora.MostrarJSON();
                    Manejadora.AdministrarSpinner(false);
                }
            }
        }

        public static MostrarJSON():void{
            let conexion: XMLHttpRequest = new XMLHttpRequest();
            conexion.open("POST", "BACKEND/traer_json.php", true);
            conexion.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            conexion.send("caso=traer");
            Manejadora.AdministrarSpinner(true);

            let tabla = `<table border="1" id="tabla">
                            <thead>
                                <th>Tamanño</th>
                                <th>Edad</th>
                                <th>Precio</th>
                                <th>Nombre</th>
                                <th>Raza</th>
                                <th>Foto</th>
                                <th>Eliminar</th>
                                <th>Modificar</th>
                            </thead>`;

            conexion.onreadystatechange = ()=> {
                if (conexion.status == 200 && conexion.readyState == 4) {
                    let perros: Array<any> = JSON.parse(conexion.responseText);
                    perros.forEach((perro) => {
                        let perroAux: Entidades.Perro = new Entidades.Perro(perro.tamanio, perro.edad, perro.precio, perro.nombre, perro.raza, perro.pathFoto);
                        tabla += `<tr>
                                    <td>${perroAux.tamanio}</td>
                                    <td>${perroAux.edad}</td>
                                    <td>${perroAux.precio}</td>
                                    <td>${perroAux.nombre}</td>
                                    <td>${perroAux.raza}</td>
                                    <td><img src=./BACKEND/fotos/${perroAux.pathFoto} height="90" width="90"</img></td>
                                    <td><input type="button" value="Eliminar" id=${perroAux.ToJSON()} onclick=""/></td>
                                    <td><input type="button" value="Modificar" id=${perroAux.ToJSON()} onclick=""/></td>
                                  </tr>`
                    })
                    tabla += "</table>";
                    (<HTMLDivElement> document.getElementById("divTabla")).innerHTML = tabla;
                    Manejadora.AdministrarSpinner(false);
                }
            }
        }

        public static AgregarPerroEnBaseDeDatos():void{
            let tamanio: string = (<HTMLInputElement>document.getElementById("tamanio")).value;
            let edad: number = parseInt((<HTMLInputElement>document.getElementById("edad")).value, 10);
            let precio: number = parseFloat((<HTMLInputElement>document.getElementById("precio")).value);
            let nombre: string = (<HTMLInputElement>document.getElementById("nombre")).value;
            let raza: string = (<HTMLInputElement>document.getElementById("cboRaza")).value;
            let foto: any = (<HTMLInputElement>document.getElementById("foto"));
            let path: string = (<HTMLInputElement>document.getElementById("foto")).value;
            let fecha = new Date();
            let pathFoto: string;
            if (path !== "") {
                pathFoto = nombre + "." + `${fecha.getDate()}${fecha.getMonth()}${fecha.getFullYear()}_${fecha.getHours()}${fecha.getMinutes()}${fecha.getSeconds()}.jpg`;
            } else {
                pathFoto = "perro_default.jpg";
            }

            let perro: Entidades.Perro = new Entidades.Perro(tamanio, edad, precio, nombre, raza, pathFoto);
            let form: FormData = new FormData();
            let caso: string = "agregarBD";
            if ((<HTMLInputElement>document.getElementById("hdnIdModificacion")).value === "modificar") {
                caso = "modificar";
                form.append("perroModificar", <string>localStorage.getItem("perroModificar"));
            }


            form.append("caso", caso);
            form.append("cadenaJson", perro.ToJSON());
            if (foto.files[0] !== null) {
                form.append("foto", foto.files[0]);
            }

            let conexion: XMLHttpRequest = new XMLHttpRequest();
            conexion.open("POST", "BACKEND/agregar_bd.php", true);
            conexion.setRequestHeader('enctype', 'multipart/form-data');
            if(Manejadora.AdministrarValidaciones()){
                Manejadora.AdministrarSpinner(true);
                conexion.send(form);
            }

            conexion.onreadystatechange = ()=> {
                if (conexion.status == 200 && conexion.readyState == 4) {
                    let rta: any = JSON.parse(conexion.responseText);
                    if (rta.TodoOK && rta.caso === "agregar") {
                        alert("Perro agregado");
                    } else if (rta.TodoOK && rta.caso === "modificar") {
                        alert("Perro modificado");
                        (<HTMLInputElement>document.getElementById("nombre")).readOnly = false;
                        (<HTMLInputElement>document.getElementById("btn-agregar")).value = "Agregar en BD";
                        (<HTMLInputElement>document.getElementById("hdnIdModificacion")).value = "agregar";
                    }
                    localStorage.clear();
                    Manejadora.LimpiarCampos();
                    Manejadora.MostrarPerrosBaseDatos();
                    Manejadora.AdministrarSpinner(false);
                }
            }
        }

        public static VerificarExistencia() : void{
            let edad : string = (<HTMLInputElement> document.getElementById("edad")).value;
            let raza : string = (<HTMLInputElement> document.getElementById("cboRaza")).value;
            let existe: boolean = false;
            if (localStorage.getItem("perros_bd") !== "") {
                let perros: Array<any> = JSON.parse(<string>localStorage.getItem("perros_bd"));
                for (let i = 0; i < perros.length; i++){
                    if (edad == perros[i].edad && raza == perros[i].raza) {
                        console.log("YA EXISTE UN PERRO CON ESA RAZA Y EDAD");
                        alert("YA EXISTE UN PERRO CON ESA RAZA Y EDAD");
                        existe = true;
                        break;
                    }
                }

                if(existe != true)
                {
                    Manejadora.AgregarPerroEnBaseDeDatos();
                }
            }
        }

        public static MostrarPerrosBaseDatos():void{
            let conexion: XMLHttpRequest = new XMLHttpRequest();
            conexion.open("POST", "BACKEND/traer_bd.php", true);
            conexion.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            conexion.send("caso=traerBD");
            Manejadora.AdministrarSpinner(true);

            let tabla = `<table border="1" id="tabla">
                            <thead>
                                <th>Tamanño</th>
                                <th>Edad</th>
                                <th>Precio</th>
                                <th>Nombre</th>
                                <th>Raza</th>
                                <th>Foto</th>
                                <th>Eliminar</th>
                                <th>Modificar</th>
                            </thead>`;

            conexion.onreadystatechange = ()=> {
                if (conexion.status == 200 && conexion.readyState == 4) {
                    let perros: Array<any> = JSON.parse(conexion.responseText);
                    localStorage.setItem("perros_bd", conexion.responseText);
                    perros.forEach((perro) => {
                        let perroAux: Entidades.Perro = new Entidades.Perro(perro.tamanio, perro.edad, perro.precio, perro.nombre, perro.raza, perro.pathFoto);
                        tabla += `<tr>
                                    <td>${perroAux.tamanio}</td>
                                    <td>${perroAux.edad}</td>
                                    <td>${perroAux.precio}</td>
                                    <td>${perroAux.nombre}</td>
                                    <td>${perroAux.raza}</td>
                                    <td><img src=./BACKEND/fotos/${perroAux.pathFoto} height="90" width="90"</img></td>
                                    <td><input type="button" value="Eliminar" id=${perroAux.ToJSON()} onclick="PrimerParcial.Manejadora.Eliminar(id)"/></td>
                                    <td><input type="button" value="Modificar" id=${perroAux.ToJSON()} onclick="PrimerParcial.Manejadora.Modificar(id)"/></td>
                                  </tr>`
                    })
                    tabla += "</table>";
                    (<HTMLDivElement> document.getElementById("divTabla")).innerHTML = tabla;
                    Manejadora.AdministrarSpinner(false);
                }
            }
        }

        static Eliminar(id: string): void {
            let manejadora: Manejadora = new Manejadora();
            manejadora.EliminarPero(id);
        }

        static Modificar(id: string): void{
            let manejadora: Manejadora = new Manejadora();
            manejadora.ModificarPerro(id);
        }

        EliminarPero(id: string): void {
            let conexion : XMLHttpRequest = new XMLHttpRequest();
            conexion.open("POST","BACKEND/eliminar_bd.php" , true);
            conexion.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            let perro: any = JSON.parse(id);
            Manejadora.AdministrarSpinner(true);
            conexion.onreadystatechange = () =>
            {
                if(conexion.readyState == 4 && conexion.status == 200)
                {
                    let rta: any = JSON.parse(conexion.responseText);
                    if(rta.TodoOK)
                    {
                        localStorage.clear();
                        console.log("OBJETO BORRADO");
                        Manejadora.MostrarPerrosBaseDatos();
                    }
                    console.log(conexion.responseText);
                    Manejadora.AdministrarSpinner(false);
                }
            }

            if (confirm(`Desea borrar el perro ${perro.nombre} y la raza ${perro.raza}`)) {
                conexion.send("caso=eliminar&cadenaJson=" + id);
            }
        }

        ModificarPerro(id: string): void {
            let perro: any = JSON.parse(id);
            (<HTMLInputElement>document.getElementById("btn-agregar")).value = "Modificar en BD";
            let nombre: string = (<HTMLInputElement>document.getElementById("nombre")).value = perro.nombre;
            (<HTMLInputElement>document.getElementById("nombre")).readOnly = true;
            let edad : number = (<HTMLInputElement> document.getElementById("edad")).value = perro.edad;
            let precio : number = (<HTMLInputElement> document.getElementById("precio")).value = perro.precio;
            let raza : string = (<HTMLInputElement> document.getElementById("cboRaza")).value = perro.raza;
            let tamanio: string = (<HTMLSelectElement>document.getElementById("tamanio")).value = perro.tamanio;
            (<HTMLImageElement>document.getElementById("imgFoto")).src = `./BACKEND/fotos/${perro.pathFoto}`;
            (<HTMLInputElement>document.getElementById("hdnIdModificacion")).value = "modificar";
            localStorage.setItem("perroModificar", id);
        }

        static ObtenerPerrosPorTamanio(): void{
            let auxContador : Array<number> = new Array<number>();
            let auxLocalStorage : any = "";

            if(localStorage.getItem("perros_bd") !== "") {
                auxLocalStorage = (<string>localStorage.getItem("perros_bd"));

                let auxJson : any = (<any> JSON.parse(auxLocalStorage));

                for(let perro of auxJson) {
                    if(auxContador[perro.tamanio] === undefined) {
                        auxContador[perro.tamanio]=0;
                    }
                    auxContador[perro.tamanio]++;
                }

                let auxMax : any = undefined;
                let auxMin : any = undefined;

                for (let tamanio in auxContador) {
                    if(auxMax === undefined && auxMin === undefined) {
                        auxMax = auxContador[tamanio];
                        auxMin = auxContador[tamanio];
                    }

                    let cantPerros= auxContador[tamanio];

                    if(auxMax < cantPerros) {
                        auxMax = cantPerros;
                    }
                    if(auxMin>cantPerros) {
                        auxMin = cantPerros;
                    }
                }

                let tamaniosMax = new Array<string>();
                let tamaniosMin = new Array<string>();

                for (let tamanio in auxContador) {
                    if(auxContador[tamanio] == auxMax) {
                        tamaniosMax.push(tamanio);
                    }
                    else if (auxContador[tamanio] == auxMin) {
                        tamaniosMin.push(tamanio);
                    }
                }

                let mensaje : string = "El/Los tamaños con mas perros son ";
                if(tamaniosMax.length > 0) {
                    for(let tamanio of tamaniosMax) {
                        mensaje+="\n-"+tamanio;
                    }
                    mensaje+="\nCon "+auxMax;
                    console.log(mensaje);
                }

                if(tamaniosMin.length > 0) {
                    mensaje= "El/Los tamaños con menos perros son ";
                    for(let tamanio of tamaniosMin) {
                        mensaje+="\n-"+tamanio;
                    }
                    mensaje+="\nCon "+auxMin;
                    console.log(mensaje);
                }
            }
        }

        public static CargarRazasJSON() : void{
            let selector = (<HTMLSelectElement> document.getElementById("cboRaza"));
            do{
                selector.remove(0);
            }while(selector.length > 0)

            let conexion : XMLHttpRequest = new XMLHttpRequest();
            conexion.open("GET", "BACKEND/razas.php", true);
            Manejadora.AdministrarSpinner(true);
            conexion.onreadystatechange = () =>
            {
                if(conexion.readyState == 4 && conexion.status == 200)
                {
                    let planetas: any = JSON.parse(conexion.responseText);
                    for(let i = 0; i < planetas.length; i++)
                    {
                        let opcion = document.createElement("option");
                        opcion.text = planetas[i].descripcion;
                        selector.add(opcion);
                    }
                    (<HTMLSelectElement> document.getElementById("cboRaza")).selectedIndex = 0;
                    Manejadora.AdministrarSpinner(false);
                }
            }
            conexion.send();
        }

        public static FiltrarPerrosPorRaza(): void{
            let raza: string = (<HTMLInputElement>document.getElementById("cboRaza")).value;
            let tabla = `<table border="1" id="tabla">
                            <thead>
                                <th>Tamanño</th>
                                <th>Edad</th>
                                <th>Precio</th>
                                <th>Nombre</th>
                                <th>Raza</th>
                                <th>Foto</th>
                                <th>Eliminar</th>
                                <th>Modificar</th>
                            </thead>`;
            let conexion : XMLHttpRequest = new XMLHttpRequest();
            conexion.open("POST", "BACKEND/filtrar.php", true);
            conexion.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            conexion.send("raza=" + raza);
            Manejadora.AdministrarSpinner(true);
            conexion.onreadystatechange = () =>
            {
                if(conexion.readyState == 4 && conexion.status == 200)
                {
                    let perros: Array<any> = JSON.parse(conexion.responseText);
                    perros.forEach((perro) => {
                        let perroAux: Entidades.Perro = new Entidades.Perro(perro.tamanio, perro.edad, perro.precio, perro.nombre, perro.raza, perro.pathFoto);
                        tabla += `<tr>
                                    <td>${perroAux.tamanio}</td>
                                    <td>${perroAux.edad}</td>
                                    <td>${perroAux.precio}</td>
                                    <td>${perroAux.nombre}</td>
                                    <td>${perroAux.raza}</td>
                                    <td><img src=./BACKEND/fotos/${perroAux.pathFoto} height="90" width="90"</img></td>
                                    <td><input type="button" value="Eliminar" id=${perroAux.ToJSON()} onclick="PrimerParcial.Manejadora.Eliminar(id)"/></td>
                                    <td><input type="button" value="Modificar" id=${perroAux.ToJSON()} onclick="PrimerParcial.Manejadora.Modificar(id)"/></td>
                                </tr>`
                    })
                    tabla += "</table>";
                    (<HTMLDivElement> document.getElementById("divTabla")).innerHTML = tabla;
                    Manejadora.AdministrarSpinner(false);
                }
            }
        }

        private static AdministrarSpinner(mostrar : boolean):void{
            let div = <HTMLDivElement> document.getElementById("divSpinner");
            let img = <HTMLImageElement> document.getElementById("imgSpinner");

            if(mostrar){
                div.style.display = "block";
                div.style.top = "50%";
                div.style.left = "45%"
                img.src = "./BACKEND/gif-load.gif";
            }

            if(!mostrar){
                div.style.display = "none";
                img.src = "";
            }
        }

        private static ValidarCamposVacios(id : string) : boolean
        {
            let rta : boolean = true;

            if((<HTMLInputElement> document.getElementById(id)).value.length == 0)
            {
                rta = false;
                console.log("Debe completar el campo " + (<HTMLInputElement> document.getElementById(id)).name);
            }

            return rta;
        }

        private static ValidarEdad(value : number) : boolean
        {
            let rta : boolean = true;

            if(value < 0 || value > 17 || isNaN(value) == true)
            {
                rta = false;
                console.log(`El valor ingresado debe estar entre los rangos 0 y 18`);
            }

            return rta;
        }

        private static ValidarRaza(raza:string, razas:string[]):boolean{
            let rta : boolean = false;

            razas.forEach((razaAux)=>{
                if(razaAux.toLowerCase() === raza.toLowerCase()){
                    rta = true;
                }
            });
            if (!rta) {
                console.log(`Ingreso una raza que no es valida`);
            }
            return rta;
        }

        private static AdministrarSpanError(id : string, ocultar : boolean) : void{
            if(id == "tamanio" && ocultar == true)
            {
                let span = document.getElementById("spanTamanio");
                (<HTMLSpanElement> span).style.display = "inline";
            }
            else if(id == "tamanio" && ocultar == false)
            {
                let span = document.getElementById("spanTamanio");
                (<HTMLSpanElement> span).style.display = "none";
            }

            if(id == "edad" && ocultar == true)
            {
                let span = document.getElementById("spanEdad");
                (<HTMLSpanElement> span).style.display = "inline";
            }
            else if(id == "edad" && ocultar == false)
            {
                let span = document.getElementById("spanEdad");
                (<HTMLSpanElement> span).style.display = "none";
            }

            if(id == "precio" && ocultar == true)
            {
                let span = document.getElementById("spanPrecio");
                (<HTMLSpanElement> span).style.display = "inline";
            }
            else if(id == "precio" && ocultar == false)
            {
                let span = document.getElementById("spanPrecio");
                (<HTMLSpanElement> span).style.display = "none";
            }

            if(id == "nombre" && ocultar == true)
            {
                let span = document.getElementById("spanNombre");
                (<HTMLSpanElement> span).style.display = "inline";
            }
            else if(id == "nombre" && ocultar == false)
            {
                let span = document.getElementById("spanNombre");
                (<HTMLSpanElement> span).style.display = "none";
            }

            if(id == "cboRaza" && ocultar == true)
            {
                let span = document.getElementById("spanRaza");
                (<HTMLSpanElement> span).style.display = "inline";
            }
            else if(id == "cboRaza" && ocultar == false)
            {
                let span = document.getElementById("spanRaza");
                (<HTMLSpanElement> span).style.display = "none";
            }
        }

        private static VerificarValidaciones() : boolean
        {
            let rta : boolean = true;
            let campos = document.getElementsByTagName("span");

            for(let i = 0; i < campos.length; i++)
            {
                if(campos[i].style.display == "inline")
                {
                    rta = false;
                    break;
                }
            }

            return rta;
        }

        private static AdministrarValidaciones():boolean{
            let rta = true;
            let campos = document.getElementsByTagName("input");
            let edad: number = parseInt((<HTMLInputElement>document.getElementById("edad")).value, 10);
            let raza = (<HTMLInputElement>document.getElementById("cboRaza"));

            for(let i = 0; i < campos.length; i++)
            {
                if(campos[i].type == "text")
                {
                    Manejadora.AdministrarSpanError(campos[i].id, false);
                }
            }

            for(let i = 0; i < campos.length; i++)
            {
                if(campos[i].type == "text"){
                    if(!Manejadora.ValidarCamposVacios(campos[i].id)){
                        Manejadora.AdministrarSpanError(campos[i].id, true);
                    }
                }
            }

            if(!Manejadora.ValidarEdad(edad)){
                Manejadora.AdministrarSpanError(campos[1].id, true);
            }

            if (!Manejadora.ValidarRaza(raza.value, ["labrador", "caniche"])) {
                Manejadora.AdministrarSpanError(raza.id, true);
            }

            if(!Manejadora.VerificarValidaciones()){
                rta = false;
            }

            return rta;
        }

        public static Toggle(col: string): void{
            var columna : any = <HTMLInputElement>document.getElementById(col)
            var colAaux : number = parseInt(col.split("-")[1], 10);
            var tabla : any = <HTMLTableElement>document.getElementById("tabla");
            if (tabla !== null && columna !== null) {
                var n : number = tabla.rows.length;
                var i : number, tr, td;

                if (columna.checked) {
                    for (i = 0; i < n; i++) {
                        tr = tabla.rows[i];
                        if (tr.cells.length > colAaux) {
                            td = tr.cells[colAaux];
                            td.style.display = "none";
                        }
                    }
                } else {
                    for (i = 0; i < n; i++) {
                        tr = tabla.rows[i];
                        if (tr.cells.length > colAaux) {
                            td = tr.cells[colAaux];
                            td.style.display = "table-cell";
                        }
                    }
                }
            }
        }

        private static LimpiarCampos() :void {
            (<HTMLInputElement> document.getElementById("tamanio")).value = "";
            (<HTMLInputElement> document.getElementById("edad")).value = "";
            (<HTMLInputElement> document.getElementById("precio")).value = "";
            (<HTMLInputElement> document.getElementById("nombre")).value = "";
            (<HTMLSelectElement> document.getElementById("cboRaza")).selectedIndex = 0;
            (<HTMLInputElement>document.getElementById("foto")).value = "";
            (<HTMLImageElement>document.getElementById("imgFoto")).src = "./BACKEND/fotos/perro_default.png";
        }
    }
}