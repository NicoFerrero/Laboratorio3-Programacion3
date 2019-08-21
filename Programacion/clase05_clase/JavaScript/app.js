var Ajax = /** @class */ (function () {
    function Ajax() {
        var _this = this;
        this.Get = function (ruta, success, params, error) {
            if (params === void 0) { params = ""; }
            var parametros = params.length > 0 ? params : "";
            ruta = params.length > 0 ? ruta + "?" + parametros : ruta;
            _this._xhr.open('GET', ruta);
            _this._xhr.send();
            _this._xhr.onreadystatechange = function () {
                if (_this._xhr.readyState === Ajax.DONE) {
                    if (_this._xhr.status === Ajax.OK) {
                        success(_this._xhr.responseText);
                    }
                    else {
                        if (error !== undefined) {
                            error(_this._xhr.status);
                        }
                    }
                }
            };
        };
        this.Post = function (ruta, success, params, error) {
            if (params === void 0) { params = ""; }
            var parametros = params.length > 0 ? params : "";
            _this._xhr.open('POST', ruta, true);
            _this._xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
            _this._xhr.send(parametros);
            _this._xhr.onreadystatechange = function () {
                if (_this._xhr.readyState === Ajax.DONE) {
                    if (_this._xhr.status === Ajax.OK) {
                        success(_this._xhr.responseText);
                    }
                    else {
                        if (error !== undefined) {
                            error(_this._xhr.status);
                        }
                    }
                }
            };
        };
        this._xhr = new XMLHttpRequest();
        Ajax.DONE = 4;
        Ajax.OK = 200;
    }
    return Ajax;
}());
/// <reference path="ajax.ts" />
var Main;
(function (Main) {
    var ajax = new Ajax();
    function EstablecerConexion() {
        var parametros = "queHago=establecerConexion";
        ajax.Post("administracion.php", Success, parametros, Fail);
    }
    Main.EstablecerConexion = EstablecerConexion;
    function EjecutarConsulta() {
        var parametros = "queHago=ejecutarConsulta";
        ajax.Post("administracion.php", Success, parametros, Fail);
    }
    Main.EjecutarConsulta = EjecutarConsulta;
    function MostrarConsulta() {
        var parametros = "queHago=mostrarConsulta";
        ajax.Post("administracion.php", Success, parametros, Fail);
    }
    Main.MostrarConsulta = MostrarConsulta;
    function EjecutarInsert() {
        var parametros = "queHago=ejecutarInsert";
        ajax.Post("administracion.php", Success, parametros, Fail);
    }
    Main.EjecutarInsert = EjecutarInsert;
    function EjecutarUpdate() {
        var parametros = "queHago=ejecutarUpdate";
        ajax.Post("administracion.php", Success, parametros, Fail);
    }
    Main.EjecutarUpdate = EjecutarUpdate;
    function EjecutarDelete() {
        var parametros = "queHago=ejecutarDelete";
        ajax.Post("administracion.php", Success, parametros, Fail);
    }
    Main.EjecutarDelete = EjecutarDelete;
    function Success(retorno) {
        console.clear();
        console.log(retorno);
        document.getElementById("divResulado").innerHTML = retorno;
    }
    function Fail(retorno) {
        console.clear();
        console.log(retorno);
        alert("Ha ocurrido un ERROR!!!");
    }
})(Main || (Main = {}));
