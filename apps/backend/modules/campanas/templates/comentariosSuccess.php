<div id="sf_admin_container" class="logistica">
  <h1>Logistica de Campañas</h1>

    <form method="post">
    
        <?php echo $form['_csrf_token']; ?>
    
        <div class="row">
            <label>Comentario de la Marca</label>
            <p>
                <?php if ( $campanaMarca->getComentarioMarca() ) : ?>
                    <?php echo $campanaMarca->getComentarioMarca(); ?>
                <?php else:?>
                    La marca aún no ha dejado comentarios.
                <?php endif;?>
            </p>
        </div>
        
        <div class="row">
            <label>Comentario Interno</label>
            <?php echo $form['comentario']; ?>
            <?php echo $form['comentario']->renderError(); ?>
        </div>
        
        <input type="submit" value="Guardar">
        &nbsp;&nbsp;
        <a href="<?php echo url_for('campanas_logistica'); ?>">Volver al listado</a>
    
    </form>
  
</div>
