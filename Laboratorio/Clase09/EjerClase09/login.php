<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Document</title>
</head>
<body class="bg-dark text-white-50">
    <div class="container">
        <div id="alert" class="container-fluid mt-5 alert fade show d-none" role="alert">
            <span id="msgAlert"></span>    
        </div>
        <div class="row min-vh-100 align-items-center">
            <div class="col-2 col-md-3"></div>
            <div class="col-8 col-md-6">
                <form id="loginForm" class="border p-4">
                    <div class="row">
                        <div class="col-12 text-center text-uppercase h3 mb-2">Login</div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-sm-2">
                            <label for="legajo" class="col-form-label">Legajo</label>
                        </div>
                        <div class="col-12 col-sm-10">
                            <input type="text" class="form-control" id="legajoLogin" name="legajoLogin">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-sm-2">
                            <label for="clave" class="col-form-label">Clave</label>
                        </div>
                        <div class="col-12 col-sm-10">
                        <input type="password" class="form-control" id="claveLogin" name="claveLogin">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <button type="submit" id="loginBtn" class="btn btn-outline-primary btn-block mb-2">Login<i class="ml-2 far fa-paper-plane"></i></button>
                        </div>
                        <div class="col-12 col-sm-6">
                            <button type="reset" class="btn btn-outline-danger btn-block mb-2">Cancelar<i class="ml-2 fas fa-ban"></i></button>
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-outline-info btn-block" data-toggle="modal" data-target="#crearModal">Crear Cuenta<i class="ml-2 fas fa-pen"></i></button>

                            <div class="modal fade" id="crearModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content bg-dark text-white-50">
                                        <div class="modal-body">
                                            <form id="registerForm" class="p-4">
                                                <div class="row">
                                                    <div class="col-12 text-center text-uppercase h3 mb-2">Ingrese sus datos</div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-12 col-sm-2">
                                                        <label for="nombre" class="col-form-label">Nombre</label>
                                                    </div>
                                                    <div class="col-12 col-sm-10">
                                                        <input type="text" class="form-control" id="nombre">
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-12 col-sm-2">
                                                        <label for="apellido" class="col-form-label">Apellido</label>
                                                    </div>
                                                    <div class="col-12 col-sm-10">
                                                        <input type="text" class="form-control" id="apellido">
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-12 col-sm-2">
                                                        <label for="legajo" class="col-form-label">Legajo</label>
                                                    </div>
                                                    <div class="col-12 col-sm-10">
                                                        <input type="text" class="form-control" id="legajo">
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-12 col-sm-2">
                                                        <label for="clave" class="col-form-label">Clave</label>
                                                    </div>
                                                    <div class="col-12 col-sm-10">
                                                        <input type="password" class="form-control" id="clave">
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-12 col-sm-2">
                                                        <label for="sueldo" class="col-form-label">Sueldo</label>
                                                    </div>
                                                    <div class="col-12 col-sm-10">
                                                        <input type="text" class="form-control" id="sueldo">
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-12 col-sm-2">
                                                        <label for="foto" class="col-form-label">Foto</label>
                                                    </div>
                                                    <div class="col-12 col-sm-10">
                                                        <input type="file" class="form-control-file" id="foto">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-sm-6">
                                                        <button type="button" id="crearBtn" class="btn btn-outline-primary btn-block mb-2">Crear<i class="ml-2 far fa-paper-plane"></i></button>
                                                    </div>
                                                    <div class="col-12 col-sm-6">
                                                        <button type="reset" class="btn btn-outline-danger btn-block mb-2">Cancelar<i class="ml-2 fas fa-ban"></i></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-2 col-md-3"></div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/45bb931b69.js"></script>
    <script src="./login.js"></script>
</body>
</html>