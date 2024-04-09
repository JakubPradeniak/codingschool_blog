function vytvorOdkaz(href, text) {
    const odkaz = document.createElement('a');

    odkaz.href = href;
    odkaz.textContent = text;
    odkaz.classList.add('odkaz');
    odkaz.style.paddingLeft = "1rem";

    return odkaz;
}


const logo = document.getElementById('logo')

logo.style.color = "red";

logo.remove();

const navigace = document.querySelector('nav');

navigace.prepend(logo);

const odkaz = vytvorOdkaz("/jina-stranka", "Odkaz");

navigace.append(odkaz);
navigace.append(
    vytvorOdkaz("/test", "Další odkaz")
);


console.log(document.forms['profil']['jmeno']);

console.log(document.forms['registrace']['podminky'].checked)

const fomrularovaPole = document.forms['registrace'].elements;

console.log(fomrularovaPole);

for (let i = 0; i < fomrularovaPole.length; i++) {
    const element = fomrularovaPole[i];
    console.log(`Pole s názvem ${element.name} je ${element.required ? 'povinný' : 'nepovinný'}`);
}

// primitivni zpusob utoku na aplikaci - muselo by se dostat do DB (typicky rovnou <script>kod</script>)
const skodlivyKod = document.createElement('script');
skodlivyKod.innerText = "console.log('odposlouchavani klavesnice');"

document.body.append(skodlivyKod);
