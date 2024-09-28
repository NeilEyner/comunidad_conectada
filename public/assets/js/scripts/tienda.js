
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