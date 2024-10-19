
function paginarTienda(n){
    var paginas=document.getElementById('pag-t');
    var disabled='';
    var active='active';
    var i=1;
    paginas.innerHTML='';
    while (n>0) {
        if(i==1){
            disabled='disabled';
            active='active';
        }
        else{
            disabled='';
            active=' text-dark';
        }
        paginas.innerHTML+='<li id="pag-'+i+'" class="page-item '+disabled+'" onclick="mostrarpag('+i+')" name="paginas"> <a id="pag-a-'+i+'" class="page-link '+active+' rounded-0 mr-3 shadow-sm border-top-0 border-left-0" href="#" tabindex="-1">'+i+'</a></li>';
        n--;
        i++;
    }
}

function mostrarpag(pag){
    var cats = document.getElementsByName('cat');
    if(document.getElementById('cat-00').hidden)
        mostrarProdCat(cats,pag)
    else
        mostrarTodos(pag)
    moverPag(pag);
}   

function moverPag(pag){
    
    var paginas=document.getElementById('pag-t').childElementCount;
    for (let i = 1; i <= paginas; i++) {
        var pagina=document.getElementById('pag-'+i)
        var paginaA=document.getElementById('pag-a-'+i)
        if(i==pag){
            
            pagina.className+=" disabled";
            paginaA.className+=" active"
            paginaA.classList.remove('text-dark')
        }else{
            pagina.classList.remove('disabled')
            paginaA.className+=" text-dark"
            paginaA.classList.remove('active')
        }
    }
}

function modEstr(num){

    for (let i = 1; i <= 5; i++) {
        document.getElementById('mod-star-'+i).classList.remove('text-warning');
        document.getElementById('mod-star-'+i).className+=" text-muted";
    }

    for (let i = 1; i <= num; i++) {
        document.getElementById('mod-star-'+i).classList.remove('text-muted');
        document.getElementById('mod-star-'+i).className+=" text-warning";
    }
    document.getElementById('star-val').value=num;
    
    // document.getElementById('mod-star-1').classList.remove('text-muted');
    // document.getElementById('mod-star-1').className+=" text-warning";
    // pagina.className+=" disabled";
    //         paginaA.className+=" active"
    //         paginaA.classList.remove('text-dark')
}

function puntuar(ruta,idP,idA){

    // var res= confirm("¿Que puntuacion le das al producto?");
    console.log('puntuar');
    var punt=document.getElementById('star-val').value;
    if(punt==0){
        alert('Seleccione una puntuacion');
        return;
    }
    // var val=punt.value;
    var rutac=ruta+'calificar/'+idP+'/'+idA+'/'+punt;
    console.log(rutac);
    fetch(rutac, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: rutac // Enviar el ID del producto como POST
    })
    .then(response => response.json()) // Parsear la respuesta JSON
    .then(data => {
        console.log(JSON.stringify(data))
        console.log(data.idArtesano)

        if(data.status==0){
            alert('No se pudo puntuar el producto');
        }
        if(data.status==1){
            // alert('Gracias por puntuar el producto');
            document.getElementById('heart-'+idP+'-'+idA).classList.remove('far');
            document.getElementById('heart-'+idP+'-'+idA).className+=" fa";
            var estrellas='';
            var puntos=data.puntaje;
            for (let i = 1; i <= 5; i++) {
                if(puntos>=1){
                    estrellas+='<i class="text-warning fa fa-star"></i>';
                }else{
                    if(puntos>=0.29 && puntos<=0.8){
                        estrellas+= '<i class="text-warning fa fa-star-half-alt"></i>';
                    }else{
                        estrellas+='<i class="text-muted fa fa-star"></i>';
                    }
                }
                puntos--;
                // estrellas+='<i class="fa fa-star text-warning"></i>';
            }
            document.getElementById('estr-ti-'+idP+'-'+idA).innerHTML=estrellas;
        }
    })
    .catch(error => {
        console.error('Error:', error); // Manejar errores
    });
}

async function mostrarPunt(ruta,idP,idA){
    var modal=document.getElementById('exampleModal');
    var estrellas='';
    estrellas+='<input  type="hidden" name="product-quanity" id="star-val" value="0" >'
    estrellas+='<ul class="list-unstyled d-flex justify-content-center mb-1"><li>'
    estrellas+=            '<a class="btn p-0 m-0"  onclick="modEstr(1)"><i id="mod-star-1" class=" text-muted fa fa-star"></i></a>'
    estrellas+=           '<a class="btn p-0 m-0"  onclick="modEstr(2)"><i id="mod-star-2" class=" text-muted fa fa-star"></i></a>'
    estrellas+=           '<a class="btn p-0 m-0"  onclick="modEstr(3)"><i id="mod-star-3" class=" text-muted fa fa-star"></i></a>'
    estrellas+=          '<a class="btn p-0 m-0"  onclick="modEstr(4)"><i id="mod-star-4" class=" text-muted fa fa-star"></i></a>'
    estrellas+=          '<a class="btn p-0 m-0"  onclick="modEstr(5)"><i id="mod-star-5" class=" text-muted fa fa-star"></i></a>'
    document.getElementById('mod-body').innerHTML=estrellas;
    document.getElementById('accept').onclick=function(){puntuar(ruta,idP,idA)};
    var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
    myModal.show();
    // $('#exampleModal').modal('show');
}