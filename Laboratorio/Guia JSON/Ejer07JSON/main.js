"use strict";
let conexion = new XMLHttpRequest();
let auto;
conexion.open("GET", "traerAuto.php", true);
conexion.onreadystatechange = () => {
    console.log(conexion.readyState);
    if (conexion.readyState == 4 && conexion.status == 200) {
        alert(conexion.responseText);
        auto = JSON.parse(conexion.responseText);
        console.log(auto.Marca);
        alert(auto.Marca);
    }
};
conexion.send();
//# sourceMappingURL=main.js.map