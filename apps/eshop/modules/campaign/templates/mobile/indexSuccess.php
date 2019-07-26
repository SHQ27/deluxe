<section class="seccion bannerCampaign">
	<ul class="slides">
	    <?php foreach ($eshopImagenCampaignsSlide as $eshopImagenCampaign): ?>
		<li>
			<img src="<?php echo  imageHelper::getInstance()->getUrl('eshop_imagen_campaign', $eshopImagenCampaign); ?>" width="100%"/>
		</li>
		<?php endforeach; ?>
	</ul>
</section>

<section class="seccion bannerCampaign">
    <?php foreach ($eshopImagenCampaignsNoSlide as $eshopImagenCampaign): ?>
	<ul class="noslides">
		<li>
			<img src="<?php echo  imageHelper::getInstance()->getUrl('eshop_imagen_campaign', $eshopImagenCampaign); ?>" width="100%"/>
		</li>
	</ul>
	<?php endforeach; ?>
</section>