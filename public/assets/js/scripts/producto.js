

// function mostrarProdCat(cats,pag=1){
//     var productosMostrados=0;
//     var count=0;
//     var mostrados=new Set();
//     var prods= document.getElementsByName('prod');
//     for (let i = 0; i < prods.length; i++) {
//         const prod = prods[i];
//         prod.hidden = true;
//     }
//     for (let i = 0; i < cats.length; i++) {
//         const cat = cats[i];
//         if(cat.hidden == false){
//             count++;
//             var prods= document.getElementsByClassName(cat.id);
//             for (let j = 0; j < prods.length; j++) {
//                 mostrados.add(prods[j])
//             }
//         }
//     }

//     //console.log(mostrados.size)
//     var nProd=0
//     for (const element of mostrados.values()) {
        
//         if((pag-1)*6<nProd+1 && nProd+1<=6*pag)
//             element.hidden = false;
//         nProd++;
//     }

//     if(mostrados.size==0){
//         document.getElementById('prod-Message').innerHTML='<h1 class="text-center">No hay productos en esta categoria</h1>';
//     }else{
//         document.getElementById('prod-Message').innerHTML='';
//     }
//     return [count,mostrados.size];
// }

// function mostrarTodos(pag=1){
//     var count=0;
//     var prods= document.getElementsByName('prod');
//     var nProd=0;
//     for (let i = 0; i < prods.length; i++) {
//         const prod = prods[i];
//             prod.hidden = true;
        
//     }
//     for (let i = 0; i < prods.length; i++) {
//         const prod = prods[i];
//         if(((pag-1)*6)<i+1 && i+1<=(6*pag))
//             prod.hidden = false;
//         nProd++;
        
//     }
//     document.getElementById('prod-Message').innerHTML='';
//     return nProd;
// }

// export  {mostrarProdCat, mostrarTodos};
// export default {mostrarProdCat, mostrarTodos};