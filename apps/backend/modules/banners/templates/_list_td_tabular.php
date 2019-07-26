<td class="sf_admin_text sf_admin_list_td_id_banner">
  <?php echo link_to($banner->getIdBanner(), 'banner_edit', $banner) ?>
</td>

<td class="sf_admin_text sf_admin_list_td_imagen">
	<?php if ( is_file( imageHelper::getInstance()->getPath('banner_imagen', $banner) ) ):?>
	<a class="enlargeImage" href="<?php echo imageHelper::getInstance()->getUrl('banner_imagen', $banner)?>">
		<img src="<?php echo imageHelper::getInstance()->getUrl('banner_imagen', $banner)?>" width="106"/>
	</a>
	<?php endif; ?>
</td>

<td class="sf_admin_text sf_admin_list_td_url">
  <?php echo $banner->getUrl() ?>
</td>

<td class="sf_admin_boolean sf_admin_list_td_activo">
  <?php echo get_partial('banners/list_field_boolean', array('value' => $banner->getActivo())) ?>
</td>