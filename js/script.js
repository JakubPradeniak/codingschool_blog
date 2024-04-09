function spojDvaRetezce(retezec_1, retezec_2) {
    if (retezec_1 === undefined || retezec_1.length === 0) {
        console.log("retezec_1 je prázdný");
    } else if (retezec_2 === undefined || retezec_2.length === 0) {
        console.log("retezec_2 je prázdný");
    } else {
        return retezec_1 + " " + retezec_2;
    }

    return "";
}


let casProZobrazeniPopUpZpravy = 5000;

var skryjPopUp = 5000;

const ahoj = "Ahoj";
let svete = "světe!";


let zprava = ahoj + " " + svete;

console.log(ahoj);
console.log(svete);
console.log(zprava);

const spojeneRetezce = spojDvaRetezce(ahoj, svete);
zprava = spojDvaRetezce("Test", "spojení");

console.log(spojeneRetezce);
console.log(zprava);
console.log(spojDvaRetezce("test", ""));

function provedPetkratFor() {
    let pocetIteraci;
    for (let i = 0; i < 5; i++) {
        console.log(`Iterace číslo ${i}!`);
        console.log("Iterace číslo " + i + "!")
        pocetIteraci = i + 1;
    }
    console.log(`Cyklus byl ukončen po ${pocetIteraci} iteracích.`)
}

provedPetkratFor();

const pismena = ['a', 'b', 'c', 'd'];

console.log(pismena[3]);

let spojPismena = "";
for (let i = 0; i < pismena.length; i++) {
    if (pismena[i] === 'c') {
        break;
    }
    
    console.log(pismena[i]);
    // konkatenace - způsob 1
    // spojPismena = spojPismena + pismena[i];
    // konkatenace - zkrácený zápis
    spojPismena += pismena[i];
}

console.log(spojPismena)

let spojPismena2 = "";

function spojovaniPismen(pismeno) {
    console.log(pismeno);
    spojPismena2 += pismeno;
}

pismena.forEach(spojovaniPismen);

pismena.forEach((pismeno, index) => {
    console.log(pismeno, index);
    spojPismena2 += pismeno;
});

console.log(spojPismena2)