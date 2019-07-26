<?php $eshopHomeMultimedias = eshopHomeMultimediaTable::getInstance()->getList( $eshopHome->getIdEshopHome() );  ?>

<section class="seccion bannerHome GRLAX GRLA<?php echo $subIndice; ?>">
	<div class="container">

		<?php $keys = eshopHome::$GRILLA[ $subIndice ];  ?>
	    <?php foreach ($eshopHomeMultimedias as $i => $eshopHomeMultimedia): ?>
    	<?php $key = $keys[$i]; ?>

		<div class="imagen imagen<?php echo $i + 1 ?>">
			<?php if ( $eshopHomeMultimedia->getEsVideo() ): ?>
			<video rel="<?php echo $eshopHomeMultimedia->getIdEshopHomeMultimedia(); ?>" width="<?php echo imageHelper::getInstance()->getWidth('eshop_home_grilla_' . $key); ?>" height="<?php echo imageHelper::getInstance()->getHeight('eshop_home_grilla_' . $key); ?>" poster="<?php echo  imageHelper::getInstance()->getUrl('eshop_home_grilla_' . $key, $eshopHomeMultimedia, 'poster'); ?>">
				<source src="<?php echo str_replace('.jpg', '.mp4', imageHelper::getInstance()->getUrl('eshop_home_grilla_' . $key , $eshopHomeMultimedia)); ?>" type="video/mp4">
			</video>
			<div class="control play" rel="<?php echo $eshopHomeMultimedia->getIdEshopHomeMultimedia(); ?>"></div>
			<?php else: ?>
			<img src="<?php echo  imageHelper::getInstance()->getUrl('eshop_home_grilla_' . $key, $eshopHomeMultimedia); ?>" width="<?php echo imageHelper::getInstance()->getWidth('eshop_home_grilla_' . $key); ?>" height="<?php echo imageHelper::getInstance()->getHeight('eshop_home_grilla_' . $key); ?>"/>
			<img class="hover" src="<?php echo  imageHelper::getInstance()->getUrl('eshop_home_grilla_' . $key, $eshopHomeMultimedia, 'hover'); ?>" width="<?php echo imageHelper::getInstance()->getWidth('eshop_home_grilla_' . $key); ?>" height="<?php echo imageHelper::getInstance()->getHeight('eshop_home_grilla_' . $key); ?>"/>
			<a href="<?php echo $eshopHomeMultimedia->getLink(); ?>"></a>
			<?php endif; ?>
		</div>
		<?php endforeach; ?>

	</div>
</section>