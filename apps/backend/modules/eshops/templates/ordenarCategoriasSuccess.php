<div id="sf_admin_container" class="ordenarCategoriasEshops">
  <h1>Orden de Categorias para el eShop "<?php echo $eshop->getDenominacion(); ?>"</h1>

  <?php if ($sf_user->hasFlash('notice')): ?>
    <div class="notice"><?php echo $sf_user->getFlash('notice', ESC_RAW) ?></div>
  <?php endif; ?>

  <p>
    <br />
    Reordená las categorias haciendo Drag & Drop. Cuando finalices, hace click en el boton Guardar
    al final del listado.
  </p>

  <div class="resultados">
    <div class="prendas columna sortable">
     <h2>Prendas</h2>
     <?php $i = 0; ?>
      <?php foreach ($categoriasPrendas as $categoria): ?>
      <div class="resultado inline">
        <div class="categoria" data-id="<?php echo $categoria->getIdProductoCategoria(); ?>" title="<?php echo $categoria->getDenominacion(); ?>">
        <?php echo truncate_text($categoria->getDenominacion(), 55 ); ?>
        <a class="editarImagen" title="Editar Banner de Categoría" href="/backend/eshops/<?php echo $eshop->getIdEshop(); ?>/modificarImagenCategoria/<?php echo $categoria->getIdProductoCategoria(); ?>"></a>
        </div>
      </div>
      <?php $i ++; ?>
      <?php endforeach; ?>
    </div>

    <div class="accesorios columna sortable">
     <h2>Accesorios</h2>
     <?php $i = 0; ?>
      <?php foreach ($categoriasAccesorios as $categoria): ?>
      <div class="resultado inline">
        <div class="categoria" data-id="<?php echo $categoria->getIdProductoCategoria(); ?>" title="<?php echo $categoria->getDenominacion(); ?>">
        <?php echo truncate_text($categoria->getDenominacion(), 55 ); ?>
        </div>
      </div>
      <?php $i ++; ?>
      <?php endforeach; ?>
    </div>
  </div>

  <form method="post">
    <?php echo $form['_csrf_token']; ?>
    <?php echo $form['data']; ?>
    <input type="submit" class="button" value="Guardar" />
    <br />
  </form>

</div>
