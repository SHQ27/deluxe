<?php $producto = $form->getObject(); ?>

<div class="sf_admin_form_row sf_admin_boolean sf_admin_form_field_es_outlet">
    <div>
        <?php echo $form['es_outlet']->renderLabel(); ?>
        <div class="content">
            <?php echo $form['es_outlet'] ?>
            <p class="esOutlet"><?php echo ( !$producto->getEsOutlet() && $producto->esOferta() ) ? '<strong>Alerta:</strong> pasar este producto a Outlet implica eliminarlo de la campaña donde esta vigente.<br />En caso de confirmar la operación revise el stock del mismo manualmente.' : '' ?></p>           
        </div>
    </div>
</div>