<?php if ( isset($form) ) $bannerPrincipal = $form->getObject(); ?>

<?php $imagenes = imagenBannerPrincipalTable::getInstance()->getList( $bannerPrincipal->getIdBannerPrincipal(), imagenBannerPrincipal::TIPO_BANNER_PRINCIPAL ); ?>

<div class="administrar_imagenes">
<?php foreach ($imagenes as $imagen):?>
    <?php $src = '/banner/principal/grande/' .  $imagen->getSrc(); ?>
    	<div class="imagen">
		<img src="<?php echo sfConfig::get('app_upload_url') . $src; ?>" rel="<?php echo $imagen->getIdImagenBannerPrincipal(); ?>" width="750"/>
		<a class="delete">Eliminar</a>		
	</div>
<?php endforeach;?>
</div>