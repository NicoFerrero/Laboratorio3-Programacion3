function ParImpar(numero: number): void{
    if (numero % 2 == 0) {
        console.log(`El numero ${numero} es par, siendo ${numero} el numero recibido como parametro`);
    }
    else {
        console.log(`El numero ${numero} es impar, siendo ${numero} el numero recibido como parametro`);
    }
}

ParImpar(2);

ParImpar(1);