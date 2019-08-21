"use strict";
function ValidarFormato(fecha) {
    var patron = "^([0-9]{2})-([0-9]{2})-([0-9]{4})$";
    if (fecha.match(patron)) {
        return true;
    }
    else {
        return false;
    }
}
function ValidarFecha(fecha) {
    if (ValidarFormato(fecha)) {
        var dia = fecha.split("-");
        var mes = fecha.split("-");
        var signo = "";
        switch (mes[1]) {
            case "01":
                if (dia[0] > "21") {
                    signo = "ACUARIO";
                }
                else {
                    signo = "CAPRICORNIO";
                }
                break;
            case "02":
                if (dia[0] > "19") {
                    signo = "PISCIS";
                }
                else {
                    signo = "ACUARIO";
                }
                break;
            case "03":
                if (dia[0] > "20") {
                    signo = "ARIES";
                }
                else {
                    signo = "PISCIS";
                }
                break;
            case "04":
                if (dia[0] > "20") {
                    signo = "TAURO";
                }
                else {
                    signo = "ARIES";
                }
                break;
            case "05":
                if (dia[0] > "21") {
                    signo = "GEMINIS";
                }
                else {
                    signo = "TAURO";
                }
                break;
            case "06":
                if (dia[0] > "20") {
                    signo = "CANCER";
                }
                else {
                    signo = "GEMINIS";
                }
                break;
            case "07":
                if (dia[0] > "22") {
                    signo = "LEO";
                }
                else {
                    signo = "CANCER";
                }
                break;
            case "08":
                if (dia[0] > "21") {
                    signo = "VIRGO";
                }
                else {
                    signo = "LEO";
                }
                break;
            case "09":
                if (dia[0] > "22") {
                    signo = "LIBRA";
                }
                else {
                    signo = "VIRGO";
                }
                break;
            case "10":
                if (dia[0] > "22") {
                    signo = "ESCORPION";
                }
                else {
                    signo = "LIBRA";
                }
                break;
            case "11":
                if (dia[0] > "21") {
                    signo = "SAGITARIO";
                }
                else {
                    signo = "ESCORPIO";
                }
                break;
            case "12":
                if (dia[0] > "21") {
                    signo = "CAPRICORNIO";
                }
                else {
                    signo = "SAGITARIO";
                }
                break;
        }
        console.log(signo);
    }
    else {
        console.log("El formato de la fecha es erroneo");
    }
}
ValidarFecha("04-05-1994");
ValidarFecha("050-05-2015");
ValidarFecha("07-09-1997");
ValidarFecha("05-050-2015");
ValidarFecha("01-11-1962");
ValidarFecha("05-05-20154");
ValidarFecha("23-02-1958");
//# sourceMappingURL=Ejer12.js.map