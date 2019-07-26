<?php $eshopHomeMultimedias = eshopHomeMultimediaTable::getInstance()->getList( $eshopHome->getIdEshopHome() );  ?>

<section class="seccion bannerHome GRLAX GRLA<?php echo $subIndice; ?>">
	<div class="container">

		<?php $keys = eshopHome::$GRILLA[ $subIndice ];  ?>
	    <?php foreach ($eshopHomeMultimedias as $i => $eshopHomeMultimedia): ?>
    	<?php $key = $keys[$i]; ?>

		<div class="imagen imagen<?php echo $i + 1 ?>">
			<?php if ( $eshopHomeMultimedia->getEsVideo() ): ?>
			<video width="100%" rel="<?php echo $eshopHomeMultimedia->getIdEshopHomeMultimedia(); ?>" poster="<?php echo  imageHelper::getInstance()->getUrl('eshop_home_cinta', $eshopHomeMultimedia, 'poster'); ?>">
				<source src="<?php echo str_replace('.jpg', '.mp4', imageHelper::getInstance()->getUrl('eshop_home_grilla_' . $key , $eshopHomeMultimedia)); ?>" type="video/mp4">
			</video>
			<div class="control play" rel="<?php echo $eshopHomeMultimedia->getIdEshopHomeMultimedia(); ?>"></div>
			<?php else: ?>
			<img src="<?php echo  imageHelper::getInstance()->getUrl('eshop_home_grilla_' . $key, $eshopHomeMultimedia); ?>" width="100%"/>
			<img class="hover" src="<?php echo  imageHelper::getInstance()->getUrl('eshop_home_grilla_' . $key, $eshopHomeMultimedia, 'hover'); ?>" width="100%"/>
			<a href="<?php echo $eshopHomeMultimedia->getLink(); ?>"></a>
			<?php endif; ?>
		</div>
		<?php endforeach; ?>
		
	</div>
</section>