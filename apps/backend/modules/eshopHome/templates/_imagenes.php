<?php $eshopHomeMultimedias = eshopHomeMultimediaTable::getInstance()->getList( $eshopHome->getIdEshopHome(), $indice ); ?>
<div>
<?php foreach ($eshopHomeMultimedias as $eshopHomeMultimedia):?>
	<div class="imagen" rel="<?php echo $eshopHomeMultimedia->getIdEshopHomeMultimedia(); ?>">

		<br/><br/>


		<?php if ( $eshopHomeMultimedia->getEsVideo() ): ?>
		<video width="300" controls>
			<source src="<?php echo str_replace('.jpg', '.mp4', imageHelper::getInstance()->getUrl('eshop_home_generico', $eshopHomeMultimedia)); ?>" type="video/mp4">
		</video>
		<img src="<?php echo imageHelper::getInstance()->getUrl('eshop_home_generico', $eshopHomeMultimedia, 'poster' ); ?>" rel="<?php echo $eshopHomeMultimedia->getIdEshopHomeMultimedia(); ?>" width="300"/>
		<?php else: ?>
			<img src="<?php echo imageHelper::getInstance()->getUrl('eshop_home_generico', $eshopHomeMultimedia ); ?>" rel="<?php echo $eshopHomeMultimedia->getIdEshopHomeMultimedia(); ?>" width="300"/>
		<?php endif; ?>

		<?php if ( in_array($tipo, array( eshopHome::TIPO_BANNER_PRINCIPAL_FULLSCREEN, eshopHome::TIPO_BANNER_PRINCIPAL_NORMAL ) ) ): ?>
		<?php if ( $eshopHomeMultimedia->getEsVideo() ): ?>
		<video width="300" controls>
			<source src="<?php echo str_replace('.jpg', '.mp4', imageHelper::getInstance()->getUrl('eshop_home_generico', $eshopHomeMultimedia, 'mobile')); ?>" type="video/mp4">
		</video>
		<img src="<?php echo imageHelper::getInstance()->getUrl('eshop_home_generico', $eshopHomeMultimedia, 'mobile_poster' ); ?>" rel="<?php echo $eshopHomeMultimedia->getIdEshopHomeMultimedia(); ?>" width="300"/>
		<?php else: ?>
			<img src="<?php echo imageHelper::getInstance()->getUrl('eshop_home_generico', $eshopHomeMultimedia, 'mobile' ); ?>" rel="<?php echo $eshopHomeMultimedia->getIdEshopHomeMultimedia(); ?>" width="300"/>
		<?php endif; ?>
		<?php endif; ?>

		<?php if (  !$eshopHomeMultimedia->getEsVideo() && !in_array($tipo, array( eshopHome::TIPO_BANNER_PRINCIPAL_FULLSCREEN, eshopHome::TIPO_BANNER_PRINCIPAL_NORMAL ) ) ): ?>
		<img src="<?php echo imageHelper::getInstance()->getUrl('eshop_home_generico', $eshopHomeMultimedia, 'hover' ); ?>" rel="<?php echo $eshopHomeMultimedia->getIdEshopHomeMultimedia(); ?>" width="300"/>
		<?php endif;?>

		<?php if ( !$eshopHomeMultimedia->getEsVideo() ): ?>
		<?php if ( $eshopHomeMultimedia->getLink() ): ?>
		<span class="link">La imagen tiene link hacia:<br/><a href="<?php echo $eshopHomeMultimedia->getLink() ?>" target="_blank"><?php echo $eshopHomeMultimedia->getLink() ?></a></span>
		<?php else: ?>
		<span class="link">Estas imagenes no tienen link definido</span>
		<?php endif;?>
		<?php endif;?>

		<a class="delete">Eliminar <?php echo $eshopHomeMultimedia->getEsVideo() ? 'Video' : 'Imagenes' ?></a>

		<br/><br/>
	</div>
<?php endforeach;?>
</div>