<?php sfContext::getInstance()->getResponse()->setTitle('Acera de ' . $eshop->getDenominacion() ); ?>

<section id="acerca" class="seccion blanco">
	<div class="banner">
	   <div class="grid">
	   <img src="<?php echo sfConfig::get('app_host_static'); ?>/images/eshop/<?php echo $eshop->getIdEshop(); ?>/acerca_de.jpg">
	   </div>
	</div>
	<div class="container">
		<div class="linea"><div class="triangulos"></div></div>
		<div class="titulo MS-23"><?php echo $eshop->getAcercaTitulo(); ?></div>
		
		<div class="texto OS-11 color4 alignC lh19">
		    <?php echo nl2br( $eshop->getAcercaTextoPrincipal(ESC_RAW) ); ?>
		    <span></span>
		</div>
		
		<div class="OS-15 color4 italic alignC lh21">
		    <?php echo nl2br( $eshop->getAcercaTextoSecundario(ESC_RAW) ); ?>
		</div>
	</div>
</section>