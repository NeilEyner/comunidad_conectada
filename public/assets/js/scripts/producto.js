

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
    html+=' <div class="cart_droptitle"><h4 class="text_lg">'+ 'TAMAÑO DEL CARRITO'+' Productos</h4></div>'
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
    html+=         '<a href="'+ruta+'/carrito " class="default_btn w-50  px-1"  style="text-decoration:none;">Ver Carrito</a>'
    html+=             '<a href="checkout.html" class="default_btn second ms-3 w-50  px-1" style="text-decoration:none;">Pagar</a>'
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