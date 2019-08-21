"use strict";
function Operar() {
    var num1 = parseInt(document.getElementById("num1").value, 10);
    var num2 = parseInt(document.getElementById("num2").value, 10);
    var resultado = 0;
    var rdoOpElement = document.getElementsByName("rdoOp");
    var operador;
    for (var i = 0; i < rdoOpElement.length; i++) {
        if (rdoOpElement[i].checked) {
            operador = rdoOpElement[i].value;
            break;
        }
    }
    switch (operador) {
        case "+":
            resultado = num1 + num2;
            break;
        case "-":
            resultado = num1 - num2;
            break;
        case "*":
            resultado = num1 * num2;
            break;
        case "/":
            if (num2 != 0) {
                resultado = num1 / num2;
            }
            break;
    }
    document.getElementById("res").value = (resultado).toString();
}
//# sourceMappingURL=Ejer21.js.map