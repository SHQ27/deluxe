<?php $eshopHomeMultimedias = eshopHomeMultimediaTable::getInstance()->getList( $eshopHome->getIdEshopHome() );  ?>
<?php $keys = eshopHome::$BANNERS_SECUNDARIOS[$subIndice]; ?>

<section class="seccion bannerHome BSX2">
	<div class="container">
		<?php if ( isset( $eshopHomeMultimedias[0] ) ): ?> 
		<?php $eshopHomeMultimedia = $eshopHomeMultimedias[0]; ?> 
		<div class="imagen">

			<?php if ( $eshopHomeMultimedia->getEsVideo() ): ?>
			<video width="100%" rel="<?php echo $eshopHomeMultimedia->getIdEshopHomeMultimedia(); ?>" poster="<?php echo  imageHelper::getInstance()->getUrl('eshop_home_generico', $eshopHomeMultimedia, 'poster'); ?>">
				<source src="<?php echo str_replace('.jpg', '.mp4', imageHelper::getInstance()->getUrl('eshop_home_secundario_x2_' . $keys[0], $eshopHomeMultimedia)); ?>" type="video/mp4">
			</video>
			<div class="control play" rel="<?php echo $eshopHomeMultimedia->getIdEshopHomeMultimedia(); ?>"></div>
			<?php else: ?>
			<img src="<?php echo  imageHelper::getInstance()->getUrl('eshop_home_secundario_x2_' . $keys[0], $eshopHomeMultimedia); ?>" width="100%"/>
			<img class="hover" src="<?php echo  imageHelper::getInstance()->getUrl('eshop_home_secundario_x2_' . $keys[0], $eshopHomeMultimedia, 'hover'); ?>" width="100%"/>
			<a href="<?php echo $eshopHomeMultimedia->getLink(); ?>"></a>
			<?php endif; ?>

		</div>
		<?php endif; ?> 

		<?php if ( isset( $eshopHomeMultimedias[1] ) ): ?> 
		<?php $eshopHomeMultimedia = $eshopHomeMultimedias[1]; ?> 
		<div class="imagen">
			<?php if ( $eshopHomeMultimedia->getEsVideo() ): ?>
			<video width="100%" rel="<?php echo $eshopHomeMultimedia->getIdEshopHomeMultimedia(); ?>" poster="<?php echo  imageHelper::getInstance()->getUrl('eshop_home_generico', $eshopHomeMultimedia, 'poster'); ?>">
				<source src="<?php echo str_replace('.jpg', '.mp4', imageHelper::getInstance()->getUrl('eshop_home_secundario_x2_' . $keys[1], $eshopHomeMultimedia)); ?>" type="video/mp4">
			</video>
			<?php else: ?>
			<img src="<?php echo  imageHelper::getInstance()->getUrl('eshop_home_secundario_x2_' . $keys[1], $eshopHomeMultimedia); ?>" width="100%"/>
			<img class="hover" src="<?php echo  imageHelper::getInstance()->getUrl('eshop_home_secundario_x2_' . $keys[1], $eshopHomeMultimedia, 'hover'); ?>" width="100%"/>
			<a href="<?php echo $eshopHomeMultimedia->getLink(); ?>"></a>
			<?php endif; ?>
		</div>
		<?php endif; ?> 
	</div>
</section>