$(document).ready(()=> {
    $("#loginForm").bootstrapValidator({
        message: "Campo invalido",
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            mailLogin: {
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
            passwordLogin: {
                message: "La contraseña es invalido",
                validators: {
                    notEmpty: {
                        message: "La constraseña no puede estar vacia"
                    },
                    stringLength: {
                        min: 4,
                        max: 8,
                        message: "La constraseña debe contener entre 4 y 8 caracteres"
                    }
                }
            }
        }
    });

    $("#btnEnviarLogin").off('click').click(function () {
        $('#loginForm').bootstrapValidator('revalidateField', 'mailLogin');
        $('#loginForm').bootstrapValidator('revalidateField', 'passwordLogin');
    });
});