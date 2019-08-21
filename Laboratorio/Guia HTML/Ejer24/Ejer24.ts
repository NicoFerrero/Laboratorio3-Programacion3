function ValidarIngreso() : void
{
    let name : string = (<HTMLInputElement> document.getElementById("name")).value;
    let lastName : string = (<HTMLInputElement> document.getElementById("lastName")).value;
    let dni : string = (<HTMLInputElement> document.getElementById("dni")).value;
    let sexo : string = (<HTMLInputElement> document.getElementById("sexo")).value;

    if(name == "" || lastName == "" )
    {
        console.log("El nombre o el apellido no se completaron");
    }
    
    if(!/^([0-9])*$/.test(dni) || dni == "")
    //if(!isNaN(parseInt(dni, 10)))
    {
        console.log("El dni no es numerico o el campo esta vacio");
    }

    if(sexo.length != 1)
    {
        console.log("Este campo debe contener un caracter");
    }
    else
    {
        for(let i = 0; i < sexo.length; i++)
        {
            if(sexo[i].toLowerCase() != "m" && sexo[i].toLowerCase() != "f")
            {
                console.log("Este campo solo admite los caracteres m o f");
            }
        }
    }
}