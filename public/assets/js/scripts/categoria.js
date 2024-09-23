function cambiarCat(id){
    var count=0;
    var cat = document.getElementById('cat-'+id);
    if(cat.hidden){
        cat.hidden = false;
        if(document.getElementById('cat-00').hidden==false){
            document.getElementById('cat-00').hidden= true;
        }
    }else{
        cat.hidden = true;
        
    }
    var prods= document.getElementsByName('prod');
    for (let i = 0; i < prods.length; i++) {
        const prod = prods[i];
        prod.hidden = true;
    }
    var cats = document.getElementsByName('cat');
    for (let i = 0; i < cats.length; i++) {
        const cat = cats[i];
        if(cat.hidden == false){
            count++;
            var prods= document.getElementsByClassName(cat.id);
            for (let i = 0; i < prods.length; i++) {
                const prod = prods[i];
                prod.hidden = false;
            }
        }
    }

    if(count==0){
        catTodos();
    }

}

function catTodos(){
    var cats = document.getElementsByName('cat');
    for (let i = 0; i < cats.length; i++) {
        const cat = cats[i];
        cat.hidden = true;
    }

    var prods= document.getElementsByName('prod');
    for (let i = 0; i < prods.length; i++) {
        const prod = prods[i];
        prod.hidden = false;
    }
    document.getElementById('cat-00').hidden= false;
}