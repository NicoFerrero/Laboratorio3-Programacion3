"use strict";
function ObtenerCoeficiente() {
    return 6.88;
}
function CalcularSalario() {
    var name = document.getElementById("name").value;
    var lastName = document.getElementById("lastName").value;
    var mail = document.getElementById("mail").value;
    var horas = parseInt(document.getElementById("horasTrabajadas").value, 10);
    var salario = horas * ObtenerCoeficiente();
    document.getElementById("salario").value = salario.toString();
    console.log("El empleado " + name + " " + lastName + " con mail " + mail + " cobra $" + salario + " por haber trabajado " + horas + " horas en el mes");
}
//# sourceMappingURL=Ejer23.js.map