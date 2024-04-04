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
