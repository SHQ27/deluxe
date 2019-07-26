<?php 
	$promos = array(
			array('id' => 'a', 'codigo' => 'HOTALERT12'),
			array('id' => 'b', 'codigo' => 'HOTALERT13'),
			array('id' => 'c', 'codigo' => 'HOTALERT14'),
			array('id' => 'd', 'codigo' => 'HOTALERT15'),
		);
?>

<?php foreach( $promos as $promo ): ?>
<div id="promoModal-<?php echo $promo['id']; ?>" class="promoModal hide">
	<img src="<?php echo sfConfig::get('app_host_static'); ?>/images/promo-<?php echo $promo['id']; ?>.jpg?v=<?php echo cacheHelper::getInstance()->getStaticVersion(); ?>" border="0">
	<p>
	   Ingresá el código "<span><?php echo $promo['codigo']?></span>" para usar el beneficio en<br />el tercer paso de tu compra
	</p>
</div>
<?php endforeach; ?>

<audio id="audioCampana">
	<source type="audio/wav" src="<?php echo sfConfig::get('app_host_static'); ?>/resources/campanilla.wav"></source>
	<source type="audio/ogg" src="<?php echo sfConfig::get('app_host_static'); ?>/resources/campanilla.ogg"></source>
	<source type="audio/mpeg" src="<?php echo sfConfig::get('app_host_static'); ?>/resources/campanilla.mp3"></source>
</audio>