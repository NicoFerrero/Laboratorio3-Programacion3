$(document).ready(()=> {
    $("#autoForm").bootstrapValidator({
        message: "Campo invalido",
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            marca: {
                validators: {
                    notEmpty: {
                        message: 'El campo marca es requerido'
                    }
                },
                stringLength: {
                    inclusive: true,
                    max: 30,
                    message: "La marca puede contener 30 caracteres como maximo"
                }
            },
            color: {
                validators: {
                    notEmpty: {
                        message: 'El campo color es requerido'
                    },
                    stringLength: {
                        inclusive: true,
                        max: 15,
                        message: "El color puede contener 15 caracteres como maximo"
                    }
                }
            },
            precio: {
                validators: {
                    notEmpty: {
                        message: 'El campo precio es requerido'
                    },
                stringLength:{
                    inclusive: true,
                    max: 50000,
                    min: 600000,
                    message: "El precio debe estar entre 50000 y 600000"
                }
            },
            modelo: {
                validators: {
                    notEmpty: {
                        message: 'El campo modelo es requerido'
                    },
                    stringLength: {
                        inclusive: true,
                        max: 30,
                        message: "El modelo puede contener 30 caracteres como maximo"
                    }
                }
            }
        }
    }
    });

    $("#btnEnviar").off('click').click(function () {
        $('#autoForm').bootstrapValidator('revalidateField', 'marca');
        $('#autoForm').bootstrapValidator('revalidateField', 'color');
        $('#autoForm').bootstrapValidator('revalidateField', 'precio');
        $('#autoForm').bootstrapValidator('revalidateField', 'modelo');
    });
});