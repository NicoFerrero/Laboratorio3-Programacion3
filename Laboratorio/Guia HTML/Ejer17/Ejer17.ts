function EnviarPeliculas() : void
{
    let peliculas : Array<string> = [""];

    if((<HTMLInputElement> document.getElementById("Troya")).checked == true) 
    {
        peliculas.push("troya");
    } 
    if((<HTMLInputElement> document.getElementById("HP1")).checked == true) 
    {
        peliculas.push("Harry Potter 1");
    } 
    if((<HTMLInputElement> document.getElementById("SW")).checked == true) 
    {
        peliculas.push("Star Wars");
    } 
    if((<HTMLInputElement> document.getElementById("SR1")).checked == true) 
    {
        peliculas.push("Señor de los anillos y la comunidad de los anillos");
    } 

    for(let i = 0; i < peliculas.length; i++)
    {
        console.log(`${peliculas[i]}\n`)
    }
}