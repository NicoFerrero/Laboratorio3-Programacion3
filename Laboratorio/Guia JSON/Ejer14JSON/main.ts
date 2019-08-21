
class Manejadora
{
    public static GenerarTabla() : void
    {
        let conexion2 : XMLHttpRequest = new XMLHttpRequest();
        let remeras : any;
        let tabla : string = "<table border='1'><tr><th>ID</th><th>SLOGAN</th><th>SIZE</th><th>PRICE</th><th>COLOR</th><th>MAN.NAME</th><th>MAN.LOGO</th><th>MAN.LOC.COUNTRY</th><th>MAN.LOC.CITY</th><th>ACCION</th></tr>";
        conexion2.open("GET", "administrarRemeras.php?op=traerRemeras", true);
        conexion2.onreadystatechange = () =>
        {
            console.log(conexion2.readyState);
            if(conexion2.readyState == 4 && conexion2.status == 200)
            {
                remeras = JSON.parse(conexion2.responseText);
                for(let i = 0; i < remeras.length; i++)
                {
                    tabla += "<tr><td>" + remeras[i].id + "</td><td>" + remeras[i].slogan + "</td><td>" + remeras[i].size + "</td><td>" + remeras[i].price + "</td><td>" + remeras[i].color + "</td><td>" + remeras[i].manofacturer.name + "</td><td><img src='" + remeras[i].manofacturer.logo + "' width='90' height='90' </img></td><td>" + remeras[i].manofacturer.location.country + "</td><td>" + remeras[i].manofacturer.location.city + "</td><td><a href='administrarRemeras.php?op=eliminarRemera&id=" + remeras[i].id + "' name='eliminar'>Eliminar</a></td></tr>"; 
                }
                tabla += "</table>";
                (<HTMLDivElement> document.getElementById("tabla")).innerHTML = tabla;
            }
        }
        conexion2.send();
    }

    public static FiltrarPorPais() : void
    {
        let conexion2 : XMLHttpRequest = new XMLHttpRequest();
        let remeras : any;
        let filtro : string = (<HTMLInputElement> document.getElementById("filtrar")).value;
        let tabla : string = "<table border='1'><tr><th>ID</th><th>SLOGAN</th><th>SIZE</th><th>PRICE</th><th>COLOR</th><th>MAN.NAME</th><th>MAN.LOGO</th><th>MAN.LOC.COUNTRY</th><th>MAN.LOC.CITY</th><th>ACCION</th></tr>";
        conexion2.open("GET", "administrarRemeras.php?op=traerRemerasFiltradas&filtrar=" + filtro, true);
        conexion2.onreadystatechange = () =>
        {
            console.log(conexion2.readyState);
            if(conexion2.readyState == 4 && conexion2.status == 200)
            {
                remeras = JSON.parse(conexion2.responseText);
                for(let i = 0; i < remeras.length; i++)
                {
                    tabla += "<tr><td>" + remeras[i].id + "</td><td>" + remeras[i].slogan + "</td><td>" + remeras[i].size + "</td><td>" + remeras[i].price + "</td><td>" + remeras[i].color + "</td><td>" + remeras[i].manofacturer.name + "</td><td><img src='" + remeras[i].manofacturer.logo + "' width='90' height='90' </img></td><td>" + remeras[i].manofacturer.location.country + "</td><td>" + remeras[i].manofacturer.location.city + "</td><td><a href='administrarRemeras.php?op=eliminarRemera&id=" + remeras[i].id + "' name='eliminar'>Eliminar</a></td></tr>"; 
                }
                tabla += "</table>";
                (<HTMLDivElement> document.getElementById("tabla")).innerHTML = tabla;
            }
        }
        conexion2.send();
    }

    public static FiltrarPorCampo() : void
    {
        let conexion2: XMLHttpRequest = new XMLHttpRequest();
        let remeras : any;
        let filtro : string = (<HTMLSelectElement> document.getElementById("filtro")).value;
        let campo  = (<HTMLInputElement> document.getElementById("filtrar"));
        campo.value = filtro;
        let tabla : string = "<table border='1'><tr><th>ID</th><th>SLOGAN</th><th>SIZE</th><th>PRICE</th><th>COLOR</th><th>MAN.NAME</th><th>MAN.LOGO</th><th>MAN.LOC.COUNTRY</th><th>MAN.LOC.CITY</th></tr>";
        conexion2.open("GET", "administrarRemeras.php?op=traerRemerasFiltradasPorCampo&filtrar=" + campo.value, true);
        conexion2.onreadystatechange = () =>
        {
            console.log(conexion2.readyState);
            if(conexion2.readyState == 4 && conexion2.status == 200)
            {
                remeras = JSON.parse(conexion2.responseText);
                for(let i = 0; i < remeras.length; i++)
                {
                    tabla += "<tr><td>" + remeras[i].id + "</td><td>" + remeras[i].slogan + "</td><td>" + remeras[i].size + "</td><td>" + remeras[i].price + "</td><td>" + remeras[i].color + "</td><td>" + remeras[i].manofacturer.name + "</td><td><img src='" + remeras[i].manofacturer.logo + "' width='90' height='90' </img></td><td>" + remeras[i].manofacturer.location.country + "</td><td>" + remeras[i].manofacturer.location.city + "</td></tr>"; 
                }
                tabla += "</table>";
                (<HTMLDivElement> document.getElementById("tabla")).innerHTML = tabla;
            }
        }
        conexion2.send();
    }
}
