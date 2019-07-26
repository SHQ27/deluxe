	<?php if ( is_file( imageHelper::getInstance()->getPath('banner_principal_chico', $banner_principal) ) ):?>
	<a class="enlargeImage" href="<?php echo imageHelper::getInstance()->getUrl('banner_principal_chico', $banner_principal)?>">
		<img src="<?php echo imageHelper::getInstance()->getUrl('banner_principal_chico', $banner_principal)?>" height="80"/>
	</a>
	<?php endif; ?>