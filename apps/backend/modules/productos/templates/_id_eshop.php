<?php $producto = $form->getObject(); ?>
<?php $publicacionML = $producto->getPublicacionMl(); ?>
<div class="sf_admin_form_row sf_admin_foreignkey sf_admin_form_field_id_eshop">
    <div>
        <label for="producto_id_eshop">eShop</label>
        <div class="content">
            <?php echo $form['id_eshop'] ?>
            <?php if ( $publicacionML->estaVigente() ): ?>
            <span class="alerta">Este producto se encuentra publicado en Mercado Libre. Si vas a cambiar el eShop antes tenes que eliminar manualmente la publicacion.</span>
    	    <?php endif; ?>
        </div>
    </div>
</div>