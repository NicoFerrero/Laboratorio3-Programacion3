$(document).ready(()=> {
    $("#registroForm").bootstrapValidator({
        message: "Campo invalido",
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            mail: {
                message: "El mail es invalido",
                validators: {
                    notEmpty: {
                        message: "El mail no puede estar vacio"
                    },
                    emailAdress: {
                        message: "El mail no es valido"
                    }
                }
            },
            password: {
                message: "La contraseña es invalida",
                validators: {
                    notEmpty: {
                        message: "La constraseña no puede estar vacia"
                    },
                    stringLength: {
                        min: 4,
                        max: 8,
                        message: "La constraseña debe contener entre 4 y 8 caracteres"
                    },
                    identical: {
                        field: 'confirm',
                        message: 'La clave debe coincidir'
                    }
                }
            },
            confirm: {
                message: "La contraseña es invalida",
                validators: {
                    notEmpty: {
                        message: "La constraseña no puede estar vacia"
                    },
                    stringLength: {
                        min: 4,
                        max: 8,
                        message: "La constraseña debe contener entre 4 y 8 caracteres"
                    },
                    identical: {
                        field: 'password',
                        message: 'La clave debe coincidir'
                    }
                }
            },
            apellido: {
                message: "El apellido es invalido",
                validators: {
                    notEmpty: {
                        message: "La constraseña no puede estar vacio"
                    },
                    stringLength: {
                        inclusive: true,
                        max: 15,
                        message: "La constraseña puede contener 15 caracteres como maximo"
                    }
                }
            },
            nombre: {
                message: "El nombre es invalido",
                validators: {
                    notEmpty: {
                        message: "El nombre no puede estar vacio"
                    },
                    stringLength: {
                        inclusive: true,
                        max: 10,
                        message: "El nombre puede contener 10 caracteres como maximo"
                    }
                }
            },foto: {
                validators: {
                    notEmpty: {
                        message: 'La foto es requerida.'
                    },
                    file: {
                        extension: 'jpeg,png,jpg',
                        type: 'image/jpeg,image/png,image/jpg',
                        message: 'El archivo seleccionado debe ser jpeg o png'
                    }
                }
            }
        }
    });

    $("#btnEnviar").off('click').click(function () {
        $('#registroForm').bootstrapValidator('revalidateField', 'nombre');
        $('#registroForm').bootstrapValidator('revalidateField', 'apellido');
        $('#registroForm').bootstrapValidator('revalidateField', 'mail');
        $('#registroForm').bootstrapValidator('revalidateField', 'foto');
        $('#registroForm').bootstrapValidator('revalidateField', 'password');
        $('#registroForm').bootstrapValidator('revalidateField', 'confirm');
    });
});