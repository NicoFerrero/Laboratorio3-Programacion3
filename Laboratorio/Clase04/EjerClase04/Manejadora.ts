namespace AJAX{

    export function Saludar():void{
        let xmlhttp : XMLHttpRequest = new XMLHttpRequest();
        let respuesta;
        
        xmlhttp.open("GET", "administrar.php", true);
        xmlhttp.send();

        xmlhttp.onreadystatechange = () =>{
            if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
                respuesta = xmlhttp.responseText;
                (<HTMLDivElement>document.getElementById("div_mostrar")).innerHTML = respuesta;
                console.log(respuesta);
                alert(respuesta);
            }
        };
    }

    function Ingresar():void{
        let xmlhttp : XMLHttpRequest = new XMLHttpRequest();
        let nombre : string = (<HTMLInputElement>document.getElementById("nombre")).value;
        let respuesta : string;
        
        xmlhttp.open("GET", "administrar.php?accion=2&nombre=" + nombre, true);
        xmlhttp.send();
        
        xmlhttp.onreadystatechange = () =>{
            if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
                respuesta = xmlhttp.responseText;
                if(respuesta == "1"){
                    MostrarTabla();
                    console.log("Nombre Agregado");
                    alert("Nombre Agregado");
                }
                else{
                    console.log("No se pudo guardar el nombre");
                    alert("No se pudo guardar el nombre");
                }
            }
        };
    }

    function MostrarTabla():void{
        let xmlhttp : XMLHttpRequest = new XMLHttpRequest();
        let respuesta : string;
        
        xmlhttp.open("GET", "administrar.php?accion=3", true);
        xmlhttp.send();

        xmlhttp.onreadystatechange = () =>{
            if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
                respuesta = xmlhttp.responseText;
                (<HTMLDivElement>document.getElementById("div_mostrar")).innerHTML = respuesta;
            }
        };
    }

    export function Verificar(){
        let xmlhttp : XMLHttpRequest = new XMLHttpRequest();
        let nombre : string = (<HTMLInputElement>document.getElementById("nombre")).value;
        let respuesta : string;
        
        xmlhttp.open("GET", "administrar.php?accion=4&nombre=" + nombre, true);
        xmlhttp.send();

        xmlhttp.onreadystatechange = () =>{
            if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
                respuesta = xmlhttp.responseText;
                if(respuesta == "0"){
                    Ingresar();
                }
                else{
                    console.log("No se puede agregar el nombre ya existe");
                    alert("No se puede agregar el nombre ya existe");
                }
            }
        };
    }
}