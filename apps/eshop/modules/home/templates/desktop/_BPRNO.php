<?php $eshopHomeMultimedias = $eshopHome->getEshopHomeMultimedia();  ?>

<section class="seccion bannerHome BPRNO">
	<div class="container">
		<ul class="slides">
		    <?php foreach ($eshopHomeMultimedias as $eshopHomeMultimedia): ?>
			<li>
				<?php if ( $eshopHomeMultimedia->getEsVideo() ): ?>
				<video width="980" rel="<?php echo $eshopHomeMultimedia->getIdEshopHomeMultimedia(); ?>" poster="<?php echo  imageHelper::getInstance()->getUrl('eshop_home_principal_normal', $eshopHomeMultimedia, 'poster'); ?>">
					<source src="<?php echo str_replace('.jpg', '.mp4', imageHelper::getInstance()->getUrl('eshop_home_principal_normal', $eshopHomeMultimedia)); ?>" type="video/mp4">
				</video>
				<div class="control play" rel="<?php echo $eshopHomeMultimedia->getIdEshopHomeMultimedia(); ?>"></div>
				<?php else: ?>
				<img src="<?php echo  imageHelper::getInstance()->getUrl('eshop_home_principal_normal', $eshopHomeMultimedia); ?>" width="980"/>
				<a href="<?php echo $eshopHomeMultimedia->getLink(); ?>"></a>
				<?php endif; ?>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>