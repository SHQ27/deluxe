<div id="sf_admin_container" class="modificarImagenCategoriaEshop">
    
    <h1>Edicion del banner de la categoría "<?php echo $productoCategoria->getDenominacion(); ?>" para el eShop "<?php echo $eshop->getDenominacion(); ?>"</h1>

    <form enctype="multipart/form-data" method="post">
    
      <?php echo $form['_csrf_token']; ?>

      <div>

        <?php echo $form["imagen"]->renderError(); ?>
        <label>Banner <small>(<?php echo imageHelper::getInstance()->getWidth('eshop_banner_listado')?> x <?php echo imageHelper::getInstance()->getHeight('eshop_banner_listado')?>)</small></label>
        <?php echo $form["imagen"]; ?>
      </div>


      <div class="buttons">
        <input type="submit" value="Guardar" class="button" />
        <a href="/backend/eshops/<?php echo $eshop->getIdEshop(); ?>/ordenarCategorias">Volver al ordenamiento de categorías</a>
      </div>

    </form>
    
</div>