/// <reference path="./node_modules/@types/jquery/index.d.ts" />

/*function validar(): void{
    let legajo:string = (<HTMLInputElement>document.getElementById("legajo")).value;
    let clave:string = (<HTMLInputElement>document.getElementById("clave")).value;
    let xhr: XMLHttpRequest = new XMLHttpRequest();
    xhr.open('GET', './BACKEND/login' + `?legajo=${legajo}&clave=${clave}`, true);
    xhr.onreadystatechange = () =>{
        if (xhr.readyState == 4 && xhr.status == 200) {
            let response = JSON.parse(xhr.responseText);
            alert(response.exito);
            if (response) {
                location.assign("index.html");
            }
        }
    }
    xhr.send();
}*/

function Validar1(): void{
    let legajo = $("#legajo").val();
    let clave = $("#clave").val();
    $.ajax({
        type: 'GET',
        url: './BACKEND/login' + `?legajo=${legajo}&clave=${clave}`,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        async: true
    }).done(response => {
        alert(response.exito + "\n" + JSON.stringify(response.objEmpleado));
        if (response.exito) {
            location.assign("index.html");
        }
    }).fail((jqXHR, textStatus, errorThrown) => {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });
}
