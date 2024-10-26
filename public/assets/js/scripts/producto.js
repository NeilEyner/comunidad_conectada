

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
    var rutac=ruta+'anadirprod/'+idA+'/'+idP+'/'+cant+'/'+precio;
    var bodyData = 'idA=' + encodeURIComponent(idA) +
                    '&idP=' + encodeURIComponent(idP)+
                    '&cant=' + encodeURIComponent(cant);
    fetch(rutac, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: ruta // Enviar el ID del producto como POST
    })
    .then(response => response.json()) // Parsear la respuesta JSON
    .then(data => {
        // console.log(JSON.stringify(data.carrito))
         console.log(data.carrito)
        // console.log(JSON.stringif(data.status))
        if(data.status==0){
            window.location.href = data.ruta;
        }

        if(data.status==2){
            alert('No hay suficiente stock');
        }

        // if(location.pathname=='/carrito'){
        //     recargaCarrito();
        // }
        if(location.pathname.substring(28,36)=='producto'){
            window.location.reload()
        }
        // document.getElementById('shopcart_dropdown').reload();
        // recargaCarrito(JSON.stringify(data.carrito),ruta)
        recargaCarrito(data.carrito,ruta)
        var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
        document.getElementById('btn-mod-cancelar').innerHTML='Aceptar';
        // document.getElementById('exampleModalLabel').innerHTML='Un Producto Añadido'
        document.getElementById('mod-body').innerHTML='Un producto ha sido añadido al carrito';
        document.getElementById('accept').setAttribute('hidden','true');
        document.getElementById('exampleModalLabel').setAttribute('hidden','true');
        myModal.show();
    })
    .catch(error => {
        console.error('Error:', error); // Manejar errores
    });
    
}

function recargaCarrito(carrito,ruta){
    console.log('recargado');
    console.log(carrito.length);
    var len=carrito.length;

    // var carrito=JSON.parse(localStorage.getItem('carrito'));
    var html='';
    if(carrito.length>0){
    html+=' <div class="cart_droptitle"><h4 class="text_lg">'+ carrito.length+' Productos</h4></div>'
    //for (const prod of carrito) {
    prod=''
    // for (carrito in prod) {
    var prod;
        for (let i = 0; i < len; i++) {
            prod = carrito[i]
        html+='    <div class="cartsdrop_wrap">'
        html+=        '<a href="" class="single_cartdrop mb-3" style="text-decoration:none">'
        html+=            '<span class="remove_cart"><i class="las la-times"></i></span>'
        html+=            '<div class="cartdrop_img">'
        html+=                '<img loading="lazy"  src="'+ruta+prod.Imagen_URL+'" alt="product">'
        html+=            '</div>'
        html+=            '<div class="cartdrop_cont"><h5 class=" mb-0 ">'
        html+=                prod.Nombre
        html+=                '<p class="mb-0 text_xs text_p">x'+prod.Cantidad+'<span class="ms-2">'+prod.Precio+'</span></p>'
        html+=        '</div></a></div>'
    }
    html+=        '<div class="total_cartdrop">'
    html+=         '<h5 class=" text-uppercase mb-0">Sub Total:</h5>'
    html+=         '<h5 class=" mb-0 ms-2">'+prod.Total+'</h5>'
    html+=     '</div>'
    html+=     '<div class=" d-flex mt-3">'
    html+=         '<a href="'+ruta+'carrito " class="default_btn w-50  px-1"  style="text-decoration:none;">Ver Carrito</a>'
    html+=             '<a href="'+ruta+'pagos/metodo_pago/'+prod.ID+'" class="default_btn second ms-3 w-50  px-1" style="text-decoration:none;">Pagar</a>'
    html+=     '</div>'
        
        
        }else{
            html+='<div class="cartsdrop_wrap"><h5 class="text-center">No hay productos en el carrito</h5></div>'
        }
        html+='</div>'
        document.getElementById('carrito-m').innerHTML=html;
        
        
}

function obtenervalor(){
    var cant=document.getElementById('product-quanity');
    console.log(cant.value);
}


function editCarr(ruta,idC,idP,idA,stock,cantidad,precio,diferencia){
    console.log(diferencia+'stock'+stock+"dsfjls");
    if(cantidad+diferencia<=0){
        eliminar(ruta, idC, idP, idA);
        return;
    }
    if(diferencia>stock){
        alert('No hay suficiente stock');
        return;
    }else{
        console.log(diferencia+'stock'+stock);
    cantidad=cantidad+diferencia;
    var rutac=ruta+'carritoedit/'+idC+'/'+idP+'/'+idA+'/'+precio+'/'+diferencia;
    var bodyData = 'idC=' + encodeURIComponent(idC) +
                    '&idP=' + encodeURIComponent(idP)+
                    '&idA=' + encodeURIComponent(idA) +
                    '&precio=' + encodeURIComponent(precio)+
                    '&dif=' + encodeURIComponent(diferencia);
    console.log(rutac)
    fetch(rutac, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: ruta // Enviar el ID del producto como POST
    })
    .then(response => response.json()) // Parsear la respuesta JSON
    .then(data => {
          console.log(JSON.stringify(data))
        //  carrito=JSON.stringify(data.carrito);
        // console.log(data.carrito.Total);
        ruta='\''+ruta+'\'';
        console.log(ruta);
        console.log(data.cantProd);
        
            document.getElementById('total').innerHTML=data.carrito.Total+' Bs.';
            document.getElementById('pre-'+idP+'-'+idA).innerHTML=data.carrito.Cantidad*data.carrito.Precio+' Bs.';
            document.getElementById('pre2-'+idP+'-'+idA).innerHTML=data.carrito.Cantidad*data.carrito.Precio+' Bs.';
            document.getElementById('var-val-'+idP+'-'+idA).innerHTML=data.carrito.Cantidad;
            document.getElementById('carr-btn-menos-'+idP+'-'+idA).setAttribute('onclick','editCarr('+ruta+','+idC+','+idP+ ','+idA+','+stock+','+data.carrito.Cantidad+','+data.carrito.Precio+',-1)');
            document.getElementById('carr-btn-mas-'+idP+'-'+idA).setAttribute('onclick','editCarr('+ruta+','+idC+','+idP+ ','+idA+','+stock+','+data.carrito.Cantidad+','+data.carrito.Precio+',1)');
        
    })
    .catch(error => {
        console.error('Error:', error); // Manejar errores
    });
}
    
}

function eliminar(ruta, idC, idP, idA){
    // alert('seguro que desea eliminar el producto del carrito?');

       var res= confirm("Quieres eliminar el producto del carrito?");
    if (res == true) {
        var rutac=ruta+'carreliminarprod';
        var bodyData = 'idC=' + encodeURIComponent(idC) +
                        '&idP=' + encodeURIComponent(idP)+
                        '&idA=' + encodeURIComponent(idA);
        console.log(rutac)
        fetch(rutac, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: bodyData // Enviar el ID del producto como POST
        })
        .then(response => response.json()) // Parsear la respuesta JSON
        .then(data => {
            console.log(JSON.stringify(data))
            //  carrito=JSON.stringify(data.carrito);
            // console.log(data.carrito.Total);
            ruta='\''+ruta+'\'';
            console.log(ruta);
            if(data.cantProd==0){
                document.getElementById('list-carr').innerHTML='No hay Productos en el carrito';
                document.getElementById('total').innerHTML='0 Bs.';
                document.getElementById('btn-carr-pag').innerHTML='';
                document.getElementById('res-carr').innerHTML='';

    
            }else{
            document.getElementById('total').innerHTML=data.total+' Bs.';
            document.getElementById('prod-carr-'+idC+'-'+idP+'-'+idA).remove();
            document.getElementById('res-'+idC+'-'+idP+'-'+idA).innerHTML='';
            }
        })
        .catch(error => {
            console.error('Error:', error); // Manejar errores
        });
    }
    
}
function actualizarCarrHeader(carrito){


}

