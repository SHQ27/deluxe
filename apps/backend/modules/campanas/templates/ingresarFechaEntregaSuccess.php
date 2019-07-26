<div class="ingresarFechaEntrega">

    <h1 class="center">
        Estimación de entrega de mercaderia para
        <br />
        la marca "<?php echo trim( $marca->getNombre() ) ?>" en la campaña "<?php echo trim( $campana->getDenominacion() ) ?>"
        <br />
        <small>Recordá que tiene ser entregado dentro de las 48 hs el pedido.</small>            
    </h1>
       
    <?php if ($ok): ?>
    <p>
        <strong>Se ha registrado la fecha de entrega para el <?php echo date('d/m/Y', strtotime($fechaEntrega));?>.</strong>
        <br />
        DeluxeBuys agradece que se cumpla la misma en tiempo y forma.
    </p>
    <?php else: ?>
    <p class="descargar">
        Podes descargar las ventas haciendo <a href="<?php echo url_for('campanas_descargarOrdenCompra', array('hash' => $hash) ); ?>">click aqui</a>.
        Una vez hecho esto te pedimos que completes el formulario indicando:
    </p>
    
    <form method="post">
    
        <?php echo $form['_csrf_token']; ?>
    
        <div class="row">
            <?php echo $form['fecha_entrega']->renderLabel(); ?>
            <?php echo $form['fecha_entrega']; ?>
            <?php echo $form['fecha_entrega']->renderError(); ?>
        </div>
        
        <div class="row">
            <label>Es importante que en caso de algún producto no esté en stock sea indicado aquí mismo como cualquier otro comentario</label>
            <?php echo $form['comentario']; ?>
            <?php echo $form['comentario']->renderError(); ?>
        </div>
        
        <div class="button">
            <input type="submit" value="Enviar">
        </div>
    
    </form>
    <?php endif; ?>

</div>