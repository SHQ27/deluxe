<?php $eshopHomeMultimedias = eshopHomeMultimediaTable::getInstance()->getList( $eshopHome->getIdEshopHome() );  ?>

<section class="seccion bannerHome BSEX3">
	<div class="container">
	    <?php foreach ($eshopHomeMultimedias as $eshopHomeMultimedia): ?>
		<div class="imagen">
			<?php if ( $eshopHomeMultimedia->getEsVideo() ): ?>
			<video width="100%" rel="<?php echo $eshopHomeMultimedia->getIdEshopHomeMultimedia(); ?>" poster="<?php echo  imageHelper::getInstance()->getUrl('eshop_home_cinta', $eshopHomeMultimedia, 'poster'); ?>">
				<source src="<?php echo str_replace('.jpg', '.mp4', imageHelper::getInstance()->getUrl('eshop_home_secundario_x3', $eshopHomeMultimedia)); ?>" type="video/mp4">
			</video>
			<div class="control play" rel="<?php echo $eshopHomeMultimedia->getIdEshopHomeMultimedia(); ?>"></div>
			<?php else: ?>
			<img src="<?php echo  imageHelper::getInstance()->getUrl('eshop_home_secundario_x3', $eshopHomeMultimedia); ?>" width="100%"/>
			<img class="hover" src="<?php echo  imageHelper::getInstance()->getUrl('eshop_home_secundario_x3', $eshopHomeMultimedia, 'hover'); ?>" width="100%"/>
			<a href="<?php echo $eshopHomeMultimedia->getLink(); ?>"></a>
			<?php endif; ?>
		</div>
		<?php endforeach; ?>
	</div>
</section>