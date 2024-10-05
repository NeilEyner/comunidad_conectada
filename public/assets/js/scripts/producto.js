

function mas1(){
    var cant=document.getElementById('var-val');
    var val=parseInt(cant.innerHTML);
    var prod=document.getElementById('product-quanity');
    var max=prod.max;
    if(val<max){
        cant.innerHTML=val+1;
        prod.value=val+1;
    }
}

function menos1(){
    var cant=document.getElementById('var-val');
    var val=parseInt(cant.innerHTML);
    var prod=document.getElementById('product-quanity');
    var min=prod.min;
    if(val>1){
        cant.innerHTML=val-1;
        prod.value=val-1;
    }
}

function anadirProducto(ruta,idA,idP,cant,precio){
    ruta=ruta+'anadirprod/'+idA+'/'+idP+'/'+cant+'/'+precio;
    var bodyData = 'idA=' + encodeURIComponent(idA) +
                    '&idP=' + encodeURIComponent(idP)+
                    '&cant=' + encodeURIComponent(cant);
    console.log(cant);
    fetch(ruta, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: ruta // Enviar el ID del producto como POST
    })
    .then(response => response.json()) // Parsear la respuesta JSON
    .then(data => {
        // console.log(JSON.stringify(data))
        // console.log(JSON.stringify(data.status))
        if(data.status==0){
            window.location.href = data.ruta;
        }

        if(data.status==2){
            alert('No hay suficiente stock');
        }

        // if(location.pathname=='/carrito'){
        //     recargaCarrito();
        // }
        console.log(location.pathname.substring(28,36));
        if(location.pathname.substring(28,36)=='producto'){
            window.location.reload()
        }
        document.getElementById('shopcart_dropdown').reload();
        recargaCarrito()
    })
    .catch(error => {
        console.error('Error:', error); // Manejar errores
    });
    
}

function recargaCarrito(){
    console.log('recargado');
}

function obtenervalor(){
    var cant=document.getElementById('product-quanity');
    console.log(cant.value);
}