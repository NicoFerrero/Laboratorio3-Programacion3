"use strict";
let conexion1 = new XMLHttpRequest();
let autos;
conexion1.open("GET", "traerAutos.php", true);
conexion1.onreadystatechange = () => {
    console.log(conexion1.readyState);
    if (conexion1.readyState == 4 && conexion1.status == 200) {
        alert(conexion1.responseText);
        autos = JSON.parse(conexion1.responseText);
        for (let i = 0; i < autos.length; i++) {
            console.log(autos[i].Id + "-" + autos[i].Marca + "-" + autos[i].Precio + "-" + autos[i].Color + "-" + autos[i].Modelo);
        }
    }
};
conexion1.send();
//# sourceMappingURL=main.js.map