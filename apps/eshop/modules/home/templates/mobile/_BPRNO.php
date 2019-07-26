<?php $eshopHomeMultimedias = $eshopHome->getEshopHomeMultimedia();  ?>

<section class="seccion bannerHome BPRNO">
	<div class="container">
		<ul class="slides">
		    <?php foreach ($eshopHomeMultimedias as $eshopHomeMultimedia): ?>
			<li>
				<div class="imagenBPRNO">
					<?php if ( $eshopHomeMultimedia->getEsVideo() ): ?>
					<video width="100%" rel="<?php echo $eshopHomeMultimedia->getIdEshopHomeMultimedia(); ?>" poster="<?php echo  imageHelper::getInstance()->getUrl('eshop_home_cinta', $eshopHomeMultimedia, 'mobile_poster'); ?>">
						<source src="<?php echo str_replace('.jpg', '.mp4', imageHelper::getInstance()->getUrl('eshop_home_principal_normal', $eshopHomeMultimedia, 'mobile')); ?>" type="video/mp4">
					</video>
					<div class="control play" rel="<?php echo $eshopHomeMultimedia->getIdEshopHomeMultimedia(); ?>"></div>
					<?php else: ?>
					<img src="<?php echo  imageHelper::getInstance()->getUrl('eshop_home_principal_normal', $eshopHomeMultimedia, 'mobile'); ?>" width="100%"/>
					<a href="<?php echo $eshopHomeMultimedia->getLink(); ?>"></a>
					<?php endif; ?>
				</div>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>