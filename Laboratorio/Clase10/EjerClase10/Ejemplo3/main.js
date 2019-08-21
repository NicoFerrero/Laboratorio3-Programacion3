$(document).ready(()=>{
    $("#loginForm").bootstrapValidator({
        message: "Campo invalido",
        feedbackIcons:{
            valid: "glyphicon glyphicon-ok",
            invalid: "glyphicon glyphicon-remove",
            validating: "glyphicon glyphicon-refresh" 
        },
        fields:{
            usuario:{
                message: "El nombre de usuario no es valido",
                validators:{
                    notEmpty:{
                        message: "El campo no puede estar vacio"
                    }
                }
            },
            pass:{
                message: "La contraseña no es valida",
                validators:{
                    notEmpty:{
                        message: "El campo no puede estar vacio"
                    },
                    stringLength:{
                        min: 6,
                        max: 18,
                        message: "El campo debe tener entre 6 y 18 caracteres"
                    }
                }
            }
        }
    }).on("success.form.bv", (e)=>{
        e.preventDefault();
        alert("Submit");
    });
});