/// <reference path="./Ente.ts" />
/// <reference path="./Alien.ts" />

(<Window>window).onload = () => {
    RecuperatorioPrimerParcial.Manejadora.MostrarAliens();
    if (localStorage.getItem("Aliens_local_storage") === null) {
        RecuperatorioPrimerParcial.Manejadora.GuardarEnLocalStorage();
    }
}

namespace RecuperatorioPrimerParcial{
    export class Manejadora{
        public static AgregarAlien():void {
            let cuadrante: string = (<HTMLInputElement>document.getElementById("cuadrante")).value;
            let edad: number = parseInt((<HTMLInputElement>document.getElementById("edad")).value, 10);
            let altura: number = parseFloat((<HTMLInputElement>document.getElementById("altura")).value);
            let raza: string = (<HTMLInputElement>document.getElementById("raza")).value;
            let planetaOrigen: string = (<HTMLInputElement>document.getElementById("cboPlaneta")).value;
            let foto: any = (<HTMLInputElement>document.getElementById("foto"));
            let path: string = (<HTMLInputElement>document.getElementById("foto")).value;
            let pathFoto: string;
            if (path !== "") {
                pathFoto = cuadrante + "_" + (path.split('\\'))[2];
            } else {
                pathFoto = "alien_defecto.jpg";
            }

            let alien: Entidades.Alien = new Entidades.Alien(cuadrante, edad, altura, raza, planetaOrigen, pathFoto);


            let caso: string = "agregar";
            if ((<HTMLInputElement>document.getElementById("hdnIdModificacion")).value === "modificar") {
                caso = "modificar";
            }

            let form: FormData = new FormData();
            form.append("caso", caso);
            form.append("cadenaJson", alien.ToJSON());
            if (foto.files[0] !== null) {
                form.append("foto", foto.files[0]);
            }

            let conexion: XMLHttpRequest = new XMLHttpRequest();
            conexion.open("POST", "BACKEND/administrar.php", true);
            conexion.setRequestHeader('enctype', 'multipart/form-data');
            conexion.send(form);

            conexion.onreadystatechange = ()=> {
                if (conexion.status == 200 && conexion.readyState == 4) {
                    let rta: any = JSON.parse(conexion.responseText);
                    if (rta.TodoOK && rta.caso === "agregar") {
                        alert("Alien agregado");
                    } else if (rta.TodoOK && rta.caso === "modificar") {
                        alert("Alien modificado");
                        (<HTMLInputElement>document.getElementById("cuadrante")).readOnly = false;
                        (<HTMLInputElement>document.getElementById("raza")).readOnly = false;
                        (<HTMLInputElement>document.getElementById("btn-agregar")).value = "Agregar";
                        (<HTMLInputElement>document.getElementById("hdnIdModificacion")).value = "agregar";
                    }
                    localStorage.clear();
                    Manejadora.GuardarEnLocalStorage();
                    RecuperatorioPrimerParcial.Manejadora.MostrarAliens();
                    Manejadora.LimpiarCampos();
                }
            }

        }

        public static MostrarAliens(): void{
            let conexion: XMLHttpRequest = new XMLHttpRequest();
            conexion.open("POST", "BACKEND/administrar.php", true);
            conexion.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            conexion.send("caso=traer");

            let tabla = `<table border="1">
                            <thead>
                                <th>Cuadrante</th>
                                <th>Edad</th>
                                <th>Altura</th>
                                <th>Raza</th>
                                <th>Planeta Origen</th>
                                <th>Foto</th>
                                <th>Eliminar</th>
                                <th>Modificar</th>
                            </thead>`;

            conexion.onreadystatechange = ()=> {
                if (conexion.status == 200 && conexion.readyState == 4) {
                    let aliens: Array<any> = JSON.parse(conexion.responseText);
                    aliens.forEach((alien) => {
                        let alienAux: Entidades.Alien = new Entidades.Alien(alien.cuadrante, alien.edad, alien.altura, alien.raza, alien.planetaOrigen, alien.pathFoto);
                        tabla += `<tr>
                                    <td>${alienAux.cuadrante}</td>
                                    <td>${alienAux.edad}</td>
                                    <td>${alienAux.altura}</td>
                                    <td>${alienAux.raza}</td>
                                    <td>${alienAux.planetaOrigen}</td>
                                    <td><img src=./BACKEND/fotos/${alienAux.pathFoto} height="90" width="90"</img></td>
                                    <td><input type="button" value="Eliminar" id=${alienAux.ToJSON()} onclick="RecuperatorioPrimerParcial.Manejadora.EliminarAlien(id)"/></td>
                                    <td><input type="button" value="Modificar" id=${alienAux.ToJSON()} onclick="RecuperatorioPrimerParcial.Manejadora.ModificarAlien(id)"/></td>
                                  </tr>`
                    })
                    tabla += "</table>";
                    (<HTMLDivElement> document.getElementById("divTabla")).innerHTML = tabla;
                }
            }
        }

        public static GuardarEnLocalStorage(): void{
            let conexion: XMLHttpRequest = new XMLHttpRequest();
            conexion.open("POST", "BACKEND/administrar.php", true);
            conexion.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            conexion.send("caso=traer");

            conexion.onreadystatechange = () =>
            {
                if(conexion.readyState == 4 && conexion.status == 200)
                {
                    localStorage.setItem("Aliens_local_storage", (conexion.responseText));
                }
            }
        }

        public static VerificarExistencia() : void
        {
            let cuadrante : string = (<HTMLInputElement> document.getElementById("cuadrante")).value;
            let raza : string = (<HTMLInputElement> document.getElementById("raza")).value;
            let existe: boolean = false;
            if (localStorage.getItem("Aliens_local_storage") !== "") {
                let aliens: Array<any> = JSON.parse(<string>localStorage.getItem("Aliens_local_storage"));
                for (let i = 0; i < aliens.length; i++){
                    if (cuadrante == aliens[i].cuadrante && raza == aliens[i].raza) {
                        console.log("YA EXISTE UN ALIEN CON ESA RAZA Y CUADRANTE");
                        alert("YA EXISTE UN ALIEN CON ESA RAZA Y CUADRANTE");
                        existe = true;
                        break;
                    }
                }

                if(existe != true)
                {
                    Manejadora.AgregarAlien();
                }
            }

        }

        public static ObtenerAliensPorCuadrante() : void {
            let auxContador : Array<number> = new Array<number>();
            let auxLocalStorage : any = "";

            if(localStorage.getItem("Aliens_local_storage") !== "") {
                auxLocalStorage = (<string>localStorage.getItem("Aliens_local_storage"));

                let auxJson : any = (<any> JSON.parse(auxLocalStorage));

                for(let alien of auxJson) {
                    if(auxContador[alien.cuadrante] === undefined) {
                        auxContador[alien.cuadrante]=0;
                    }
                    auxContador[alien.cuadrante]++;
                }

                let auxMax : any = undefined;
                let auxMin : any = undefined;

                for (let cuadrante in auxContador) {
                    if(auxMax === undefined && auxMin === undefined) {
                        auxMax = auxContador[cuadrante];
                        auxMin = auxContador[cuadrante];
                    }

                    let cantAliens= auxContador[cuadrante];

                    if(auxMax < cantAliens) {
                        auxMax = cantAliens;
                    }
                    if(auxMin>cantAliens) {
                        auxMin = cantAliens;
                    }
                }

                let cuadrantesMax = new Array<string>();
                let cuadrantesMin = new Array<string>();

                for (let cuadrante in auxContador) {
                    if(auxContador[cuadrante] == auxMax) {
                        cuadrantesMax.push(cuadrante);
                    }
                    else if (auxContador[cuadrante] == auxMin) {
                        cuadrantesMin.push(cuadrante);
                    }
                }

                let mensaje : string = "El/Los cuadrantes con mas aliens son ";
                if(cuadrantesMax.length > 0) {
                    for(let cuadrante of cuadrantesMax) {
                        mensaje+="\n-"+cuadrante;
                    }
                    mensaje+="\nCon "+auxMax;
                    console.log(mensaje);
                }

                if(cuadrantesMin.length > 0) {
                    mensaje= "El/Los cuadrantes con menos aliens son ";
                    for(let cuadrante of cuadrantesMin) {
                        mensaje+="\n-"+cuadrante;
                    }
                    mensaje+="\nCon "+auxMin;
                    console.log(mensaje);
                }
            }
        }

        public static EliminarAlien(id : string) : void{
            let conexion : XMLHttpRequest = new XMLHttpRequest();
            conexion.open("POST","BACKEND/administrar.php" , true);
            conexion.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            let alien: any = JSON.parse(id);
            conexion.onreadystatechange = () =>
            {
                if(conexion.readyState == 4 && conexion.status == 200)
                {
                    let rta: any = JSON.parse(conexion.responseText);
                    if(rta.TodoOK)
                    {
                        localStorage.clear();
                        Manejadora.GuardarEnLocalStorage();
                        console.log("OBJETO BORRADO");
                        Manejadora.MostrarAliens();
                    }
                    console.log(conexion.responseText);
                }
            }

            if (confirm(`Desea borrar el alien del cuadrante ${alien.cuadrante} y la raza ${alien.raza}`)) {
                conexion.send("caso=eliminar&cadenaJson=" + id);
            }
        }

        public static ModificarAlien(id : string) : void{
            let alien: any = JSON.parse(id);
            (<HTMLInputElement>document.getElementById("btn-agregar")).value = "Modificar";
            let cuadrante: string = (<HTMLInputElement>document.getElementById("cuadrante")).value = alien.cuadrante;
            (<HTMLInputElement>document.getElementById("cuadrante")).readOnly = true;
            (<HTMLInputElement>document.getElementById("raza")).readOnly = true;
            let edad : number = (<HTMLInputElement> document.getElementById("edad")).value = alien.edad;
            let altura : number = (<HTMLInputElement> document.getElementById("altura")).value = alien.altura;
            let raza : string = (<HTMLInputElement> document.getElementById("raza")).value = alien.raza;
            let planetaOrigen: string = (<HTMLSelectElement>document.getElementById("cboPlaneta")).value = alien.planetaOrigen;
            (<HTMLImageElement>document.getElementById("imgFoto")).src = `./BACKEND/fotos/${alien.pathFoto}`;
            (<HTMLInputElement>document.getElementById("hdnIdModificacion")).value = "modificar";
        }

        public static CargarPlanetas() : void{
            let selector = (<HTMLSelectElement> document.getElementById("cboPlaneta"));
            do{
                selector.remove(0);
            }while(selector.length > 0)

            let conexion : XMLHttpRequest = new XMLHttpRequest();
            conexion.open("POST", "BACKEND/administrar.php", true);

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
                    (<HTMLSelectElement> document.getElementById("cboPlaneta")).selectedIndex = 0;
                }
            }

            conexion.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            conexion.send("caso=planetas");
        }

        public static FiltrarPorPlaneta(): void{
            let planeta: string = (<HTMLInputElement>document.getElementById("cboPlaneta")).value;
            let tabla = `<table border="1">
                            <thead>
                                <th>Cuadrante</th>
                                <th>Edad</th>
                                <th>Altura</th>
                                <th>Raza</th>
                                <th>Planeta Origen</th>
                                <th>Foto</th>
                                <th>Eliminar</th>
                                <th>Modificar</th>
                            </thead>`;
            let conexion : XMLHttpRequest = new XMLHttpRequest();
            conexion.open("POST", "BACKEND/administrar.php", true);
            conexion.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            conexion.send("caso=filtrar&planeta=" + planeta);

            conexion.onreadystatechange = () =>
            {
                if(conexion.readyState == 4 && conexion.status == 200)
                {
                    let aliens: Array<any> = JSON.parse(conexion.responseText);
                    aliens.forEach((alien) => {
                        let alienAux: Entidades.Alien = new Entidades.Alien(alien.cuadrante, alien.edad, alien.altura, alien.raza, alien.planetaOrigen, alien.pathFoto);
                        tabla += `<tr>
                                    <td>${alienAux.cuadrante}</td>
                                    <td>${alienAux.edad}</td>
                                    <td>${alienAux.altura}</td>
                                    <td>${alienAux.raza}</td>
                                    <td>${alienAux.planetaOrigen}</td>
                                    <td><img src=./BACKEND/fotos/${alienAux.pathFoto} height="90" width="90"</img></td>
                                    <td><input type="button" value="Eliminar" id=${alienAux.ToJSON()} onclick="RecuperatorioPrimerParcial.Manejadora.EliminarAlien(id)"/></td>
                                    <td><input type="button" value="Modificar" id=${alienAux.ToJSON()} onclick="RecuperatorioPrimerParcial.Manejadora.ModificarAlien(id)"/></td>
                                  </tr>`
                    })
                    tabla += "</table>";
                    (<HTMLDivElement> document.getElementById("divTabla")).innerHTML = tabla;
                }
            }
        }

        private static LimpiarCampos() :void {
            (<HTMLInputElement> document.getElementById("cuadrante")).value = "";
            (<HTMLInputElement> document.getElementById("edad")).value = "";
            (<HTMLInputElement> document.getElementById("altura")).value = "";
            (<HTMLInputElement> document.getElementById("raza")).value = "";
            (<HTMLSelectElement> document.getElementById("cboPlaneta")).selectedIndex = 0;
            (<HTMLInputElement>document.getElementById("foto")).value = "";
            (<HTMLImageElement>document.getElementById("imgFoto")).src = "./BACKEND/fotos/alien_defecto.jpg";
        }
    }
}