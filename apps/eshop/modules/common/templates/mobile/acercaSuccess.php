<?php sfContext::getInstance()->getResponse()->setTitle('Acera de ' . $eshop->getDenominacion() ); ?>

<section id="acerca" class="seccion blanco">
	<div class="banner">
		<div class="grid">
			<img src="<?php echo sfConfig::get('app_host_static'); ?>/images/eshop/<?php echo $eshop->getIdEshop(); ?>/acerca_de.jpg" width="100%">
		</div>
	</div>
	<div class="container">
		<div class="titulo"><?php echo $eshop->getAcercaTitulo(); ?></div>
		
		<div class="textoprinc">
		    <?php echo nl2br( $eshop->getAcercaTextoPrincipal(ESC_RAW) ); ?>
		    <span></span>
		</div>
		
		<div class="textosecund">
		    <?php echo nl2br( $eshop->getAcercaTextoSecundario(ESC_RAW) ); ?>
		</div>
	</div>
</section>