let objJSON : any = {
    "CodBarra" : 1000,
    "nombre": "tomate",
    "precio": 50
};

let producto : string = JSON.stringify(objJSON);

console.log(producto);
