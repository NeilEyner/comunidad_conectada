
    <!-- Modal -->
    <div class="modal fade bg-white" id="templatemo_search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="w-100 pt-1 mb-5 text-right">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="get" class="modal-content modal-body border-0 p-0">
                <div class="input-group mb-2">
                    <input type="text" class="form-control" id="inputModalSearch" name="q" placeholder="Search ...">
                    <button type="submit" class="input-group-text bg-success text-light">
                        <i class="fa fa-fw fa-search text-white"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- Start Content Page -->
    <div class="container-fluid bg-light py-5">
        <div class="col-md-6 m-auto text-center">
            <h1 class="h1">Comunidades </h1>
        </div>
    </div>


    <div class="container py-5">
        <div class="row">

            <div class="col-lg-3">
                
                <div class=" flex-sm-fill mt-3 mb-4 col-7 col-sm-auto pr-3">
                    <!-- <div class="input-group">
                        <input type="text" class="form-control" id="Search" placeholder="Buscar ...">
                        <div class="input-group-text">
                            <i class="fa fa-fw fa-search"></i>
                        </div>
                    </div> -->
                    <h1 class="h2 text-success" style="text-align:center;"><b > Comunidades </b> </h1>
                </div>
            
                <ul class="list">
                    <?php foreach ($comunidad as $item): 
                        ?>
                        
                        <li class="list-group" onClick="editData('<?= $item['Nombre'] ?>','<?= $item['Descripcion'] ?>','<?= $item['Imagen'] ?>')">
                            <a href="https://maps.google.com/?q=<?= $item['Latitud'] ?>,<?= $item['Longitud'] ?>&output=embed"  target="mapa" style="color: green;text-decoration:none"><?= $item['Nombre'] ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <script>
                    function editData(nombre,resena,img)
                    {
                        $("#nombre-comunidad").text(nombre);
                        $("#resena-comunidad").text(resena);
                        $("#img").attr('src',img);
                          
                    }
                </script>
                
                
            </div>
            <div class="col-lg-9">
                <div class="row " >
                    <div  >
                        <h1 class="h1 text-success" style="text-align:center;"><b id= "nombre-comunidad"> Mallasa </b> </h1>
                    </div>
                </div>
                <div class="row" >
                    <div class="col-6 h2" id="resena-comunidad">
                    Mallasa es una comunidad residencial y turística, ubicada en las afueras de La Paz. Aquí se encuentra el famoso Valle de la Luna, una formación geológica única. Mallasa también alberga el Bioparque Vesty Pakos.
                    
                    </div>
                    <div class="col-6">
                        <img class="img-fluid" id="img" src="./assets\img\comunidades\mallasa.jpg" alt="">
                    </div>
                </div>
                <div class="row" style="padding-top: 20px;">
                    <iframe name="mapa" src="https://maps.google.com/?q=-16.57527,-68.089897&output=embed"
                    width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy" >
                    </iframe>
                </div>
                    
            </div>

        </div>
    </div>
    
 
