<div id="sf_admin_container" class="ordenarHome">
  <h1>Orden de Banners en Home</h1>

  <?php if ($sf_user->hasFlash('notice')): ?>
    <div class="notice"><?php echo $sf_user->getFlash('notice', ESC_RAW) ?></div>
  <?php endif; ?>

  <p>
    <br />
    Reordená los banners haciendo Drag & Drop. Cuando finalices, hace click en el boton Guardar
    al final del listado.
  </p>

  <div class="resultados">
  <?php $i = 0; ?>
  <?php foreach ( $items as $item ): ?>
    <div class="resultado <?php echo ($i % 3 == 1) ? 'columnLeft' : ''; ?> <?php echo ($i % 3 == 0) ? 'columnRight' : ''; ?>" data-id="<?php echo $item['tipo'] . '-' . $item['id']; ?>" >
    <?php if ( $item['tipo'] == 'campana' ): ?>                  
    <?php include_partial('campana', array('campana' => $item['item'] ) ); ?>
    <?php elseif ( $item['tipo'] == 'bannerPrincipal' ): ?>
    <?php include_partial('bannerPrincipal', array('bannerPrincipal' => $item['item'] ) ); ?>
    <?php else: ?>
    <?php include_partial('outlet', array('outlet' => $item['item'] ) ); ?>
    <?php endif; ?>
    </div>
    <?php $i++; ?>
  <?php endforeach; ?>
  </div>

  <form method="post">
    <?php echo $form['_csrf_token']; ?>
    <?php echo $form['data']; ?>
    <input type="submit" class="button" value="Guardar" />
    <br />
  </form>

</div>
