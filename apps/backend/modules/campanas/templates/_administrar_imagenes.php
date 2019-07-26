<?php if ( isset($form) ) $campana = $form->getObject(); ?>

<?php $imagenes = imagenBannerPrincipalTable::getInstance()->getList( $campana->getIdCampana(), imagenBannerPrincipal::TIPO_CAMPANA ); ?>

<div class="administrar_imagenes">
<?php foreach ($imagenes as $imagen):?>
    <?php $src = '/campana/banner/principal/' .  $imagen->getSrc(); ?>
    	<div class="imagen">
		<img src="<?php echo sfConfig::get('app_upload_url') . $src; ?>" rel="<?php echo $imagen->getIdImagenBannerPrincipal(); ?>" width="750"/>
		<a class="delete">Eliminar</a>		
	</div>
<?php endforeach;?>
</div>