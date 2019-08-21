"use strict";
var Entidades;
(function (Entidades) {
    var Mascota = /** @class */ (function () {
        function Mascota(tamanio, edad, precio) {
            this.tamanio = tamanio;
            this.edad = edad;
            this.precio = precio;
        }
        Mascota.prototype.ToString = function () {
            return "\"tamanio\":\"" + this.tamanio + "\",\"edad\":" + this.edad + ",\"precio\":" + this.precio + ",";
        };
        return Mascota;
    }());
    Entidades.Mascota = Mascota;
})(Entidades || (Entidades = {}));
//# sourceMappingURL=Mascota.js.map