function Test(numero: number, cadena?: String): void{
    if (cadena) {
        for (let i = 0; i < numero; i++){
            console.log(`${cadena}\n`);
        }
    }
    else {
        console.log(`${ numero - (numero * 2)}`);
    }
}

Test(2, "Como te va");