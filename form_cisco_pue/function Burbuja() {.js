function Burbuja() {
    let arrMunicipis = ['Abrera', 'Aguilar de Segarra', 'Aiguafreda', 'Alella','Alpens', 'Arenys de Mar', 'Arenys de Munt', 'Argentona', 'Argençola', 'Artés','Avinyonet del Penedès', 'Avinyó', 'Avià', 'Badalona', 'Badia del Vallès','Bagà', 'Balenyà', 'Balsareny', 'Barberà del Vallès', 'Barcelona', 'Begues','Bellprat', 'Berga', 'Bigues i Riells', 'Borredà', 'Cabrera d\'Anoia', 'Cabrerade Mar', 'Cabrils', 'Calaf', 'Calders', 'Caldes d\'Estrac', 'Caldes de Montbui','Calella', 'Calldetenes', 'Callús', 'Calonge de Segarra'];    
    var n, i, k, aux;
    n = arrMunicipis.length;
    console.log("Array desordenat ",arrMunicipis); // Mostramos, por consola, la lista desordenada
    // Algoritmo de burbuja
    for (k = 1; k < n; k++) {
        for (i = 0; i < (n - k); i++) {
            if (arrMunicipis[i].match(/[aàeèéàiíoóuú]/gi).length > arrMunicipis[i + 1].match(/[aàeèéàiíoóuú]/gi).length) {
                aux = arrMunicipis[i];
                arrMunicipis[i] = arrMunicipis[i + 1];
                arrMunicipis[i + 1] = aux;
            }
        }
    }

    console.log("Array ordenat ",arrMunicipis); // Mostramos, por consola, la lista ya ordenada
}

function treureAccents(r){
    r = r.replace(new RegExp(/[àáâãäå]/g),"a");
    r = r.replace(new RegExp(/[èéêë]/g),"e");
    r = r.replace(new RegExp(/[ìíîï]/g),"i");
    r = r.replace(new RegExp(/[òóôõö]/g),"o");
    r = r.replace(new RegExp(/[ùúûü]/g),"u");
    return r;
};

function numVocals(ciutat){
    return ciutat.match(/[aeiou]/gi).length
}

function Burbuja2() {
    let arrMunicipis = ['Abrera', 'Aguilar de Segarra', 'Aiguafreda', 'Alella','Alpens', 'Arenys de Mar', 'Arenys de Munt', 'Argentona', 'Argençola', 'Artés','Avinyonet del Penedès', 'Avinyó', 'Avià', 'Badalona', 'Badia del Vallès','Bagà', 'Balenyà', 'Balsareny', 'Barberà del Vallès', 'Barcelona', 'Begues','Bellprat', 'Berga', 'Bigues i Riells', 'Borredà', 'Cabrera d\'Anoia', 'Cabrerade Mar', 'Cabrils', 'Calaf', 'Calders', 'Caldes d\'Estrac', 'Caldes de Montbui','Calella', 'Calldetenes', 'Callús', 'Calonge de Segarra'];    
    var n, i, k, aux;
    n = arrMunicipis.length;
    console.log("Array desordenat ",arrMunicipis); // Mostramos, por consola, la lista desordenada
    // Algoritmo de burbuja
    for (k = 1; k < n; k++) {
        for (i = 0; i < (n - k); i++) {
            if (numVocals(treureAccents(arrMunicipis[i])) > numVocals(treureAccents(arrMunicipis[i + 1]))) {
                aux = arrMunicipis[i];
                arrMunicipis[i] = arrMunicipis[i + 1];
                arrMunicipis[i + 1] = aux;
            }
        }
    }

    console.log("Array ordenat ",arrMunicipis); // Mostramos, por consola, la lista ya ordenada
}

Burbuja2();