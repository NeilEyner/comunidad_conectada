
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



    <section class="bg-success py-5">
        <div class="container">
            <div class="row align-items-center py-5">
                <div class="col-md-8 text-black">
                    <h1>Acerca de nosotros</h1>
                    <h2 >Visión</h2>
                    <?php foreach ($contenido as $item): 
                        if($item['Tipo_contenido'] == 'VISION'){
                        ?>
                        <p>
                            <?= $item['Contenido'] ?>
                        </p>
                    <?php }endforeach; ?>
                    <h2 fontColor='black'>Misión</h2>
                    <?php foreach ($contenido as $item): 
                        if($item['Tipo_contenido'] == 'MISION'){
                        ?>
                        <p>
                            <?= $item['Contenido'] ?>
                        </p>
                    <?php }endforeach; ?>
                    <h2>Objetivos</h2>
                        <p>
                            <div>
                                <ul>
                    <?php foreach ($contenido as $item): 
                        if($item['Tipo_contenido'] == 'OBJETIVO'){
                        ?>
                                    <li><b><?= $item['Titulo'] ?></b></li>
                                    <?= $item['Contenido'] ?>
                                
                    <?php }endforeach; ?>
                                </ul>
                            </div>
                        </p>
                    <h2>Valores</h2>
                        <p>
                            <div>
                                <ul>
                        <?php foreach ($contenido as $item): 
                            if($item['Tipo_contenido'] == 'VALORES'){
                            ?>
                                    <li><b><?= $item['Titulo'] ?></b></li>
                                    <?= $item['Contenido'] ?>
                                
                    <?php }endforeach; ?>
                                </ul>
                            </div>
                        </p>
                </div>
                <div class="col-md-4">
                    <img src="./assets/img/about-hero.svg" alt="About Hero">
                </div>
            </div>
        </div>
    </section>
    <!-- Close Banner -->
