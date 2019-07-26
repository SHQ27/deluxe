<div id="sf_admin_container" class="ordenarProductosEshops">
  <h1>Orden de Productos para el eShop "<?php echo $eshop->getDenominacion(); ?>"</h1>

  <?php if ($sf_user->hasFlash('notice')): ?>
    <div class="notice"><?php echo $sf_user->getFlash('notice', ESC_RAW) ?></div>
  <?php endif; ?>

  <p>
    <br />
    Reordená los productos haciendo Drag & Drop. Cuando finalices, hace click en el boton Guardar
    al final del listado.
    <br /><br />
    Recordá que podes preordenar los productos segun el orden de su categoria haciendo <a class="preordenarPorCategorias">click aquí</a>
  </p>

  <div class="resultados">
    <?php $i = 0; ?>
    <?php foreach ($productos as $producto): ?>

      <?php $productoCategoria = $producto->getProductoCategoria(); ?>
      <?php $productoCategoriaEshop = $productoCategoria->getProductoCategoriaEshop( $eshop->getIdEshop() ); ?>
      <?php $ordenCategoria = ( $productoCategoriaEshop ) ? $productoCategoriaEshop->getOrden() : 999; ?>
      

      <div class="resultado inline" data-orden-categoria="<?php echo $ordenCategoria; ?>" data-denominacion-producto="<?php echo $producto->getDenominacion(); ?>">
        <div class="producto" data-id="<?php echo $producto->getIdProducto(); ?>">
          <img src="<?php echo  imageHelper::getInstance()->getUrl('producto_lista_chica', $producto); ?>" />
        </div>
        <div class="nombre OS-12 lh16 color2" title="<?php echo $producto->getDenominacion(); ?>"><?php echo truncate_text($producto->getDenominacion(), 18) ; ?></div>
        <div class="precio OS-14 color4">
        <?php if ( $producto->getMostrarPrecioLista() ): ?>
        <?php endif; ?>
        $<?php echo formatHelper::getInstance()->formatPrice( $producto->getPrecioDeluxe() ) ?>
        </div>
    </div>
    <?php $i ++; ?>
    <?php endforeach; ?>
  </div>

  <form method="post">
    <?php echo $form['_csrf_token']; ?>
    <?php echo $form['data']; ?>
    <input type="submit" class="button" value="Guardar" />
    <br />
  </form>

</div>
