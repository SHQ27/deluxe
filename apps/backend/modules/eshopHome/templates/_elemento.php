<?php $eshopHome = $form->getObject(); ?>

<div class="eshopHomeElemento">

	<h3 class="h3 BPRFS">Imagenes para el carrousel del banner principal</h3>
	<div class="sf_admin_form_row rowElemento BPRFS">
		<label>Imagen / Video <small><br/>(Ancho: <?php echo imageHelper::getInstance()->getWidth('eshop_home_principal_full')?> px)</small></label>
		<?php echo $form["multimedia"]->render( array('name' => 'multimedia[BPRFS]') ); ?>
		<span class="alerta">Al agregar un nuevo banner el mismo se suma a los anteriores como uno mas en el carrousel de home</span>
		<br /><br /><br />
		<label>Poster Video <small><br/>(Ancho: <?php echo imageHelper::getInstance()->getWidth('eshop_home_principal_full')?> px)</small></label>
		<?php echo $form["multimedia"]->render( array('name' => 'multimedia[BPRFS_POSTER]') ); ?>
		<span class="alerta">Esta imagen solo debe subirse, si el primer archivo es un video</span>
		<br /><br /><br />
		<label>Imagen / Video - Mobile <small><br/>(Ancho: <?php echo imageHelper::getInstance()->getWidth('eshop_home_principal_full')?> px)</small></label>
		<?php echo $form["multimedia"]->render( array('name' => 'multimedia[BPRFS_MOBILE]') ); ?>
		<span class="alerta">Al agregar un nuevo banner el mismo se suma a los anteriores como uno mas en el carrousel de home</span>
		<br /><br /><br />
		<label>Poster Video - Mobile <small><br/>(Ancho: <?php echo imageHelper::getInstance()->getWidth('eshop_home_principal_full')?> px)</small></label>
		<?php echo $form["multimedia"]->render( array('name' => 'multimedia[BPRFS_MOBILE_POSTER]') ); ?>
		<span class="alerta">Esta imagen solo debe subirse, si el primer archivo es un video</span>
		<br /><br /><br />
		<label>URL</label>
		<div class="content"><?php echo $form["link"]->render( array('name' => 'link[BPRFS]') ); ?></div>
		<?php include_partial('eshopHome/imagenes', array('eshopHome' => $eshopHome, 'indice' => null, 'tipo' => 'BPRFS')); ?>

	</div>

	<h3 class="h3 BPRNO">Imagenes para el carrousel del banner principal</h3>
	<div class="sf_admin_form_row rowElemento BPRNO">
		<label>Imagen / Video <small><br/>(Ancho: <?php echo imageHelper::getInstance()->getWidth('eshop_home_principal_normal')?> px)</small></label>
		<?php echo $form["multimedia"]->render( array('name' => 'multimedia[BPRNO]') ); ?>
		<span class="alerta">Al agregar un nuevo banner el mismo se suma a los anteriores como uno mas en el carrousel de home</span>
		<br /><br /><br />
		<label>Poster Video <small><br/>(Ancho: <?php echo imageHelper::getInstance()->getWidth('eshop_home_principal_normal')?> px)</small></label>
		<?php echo $form["multimedia"]->render( array('name' => 'multimedia[BPRNO_POSTER]') ); ?>
		<span class="alerta">Esta imagen solo debe subirse, si el primer archivo es un video</span>
		<br /><br /><br />
		<label>Imagen / Video - Mobile <small><br/>(Ancho: <?php echo imageHelper::getInstance()->getWidth('eshop_home_principal_normal')?> px)</small></label>
		<?php echo $form["multimedia"]->render( array('name' => 'multimedia[BPRNO_MOBILE]') ); ?>
		<span class="alerta">Al agregar un nuevo banner el mismo se suma a los anteriores como uno mas en el carrousel de home</span>
		<br /><br /><br />
		<label>Poster Video - Mobile <small><br/>(Ancho: <?php echo imageHelper::getInstance()->getWidth('eshop_home_principal_normal')?> px)</small></label>
		<?php echo $form["multimedia"]->render( array('name' => 'multimedia[BPRNO_MOBILE_POSTER]') ); ?>
		<span class="alerta">Esta imagen solo debe subirse, si el primer archivo es un video</span>
		<br /><br /><br />
		<label>URL</label>
		<div class="content"><?php echo $form["link"]->render( array('name' => 'link[BPRNO]') ); ?></div>
		<?php include_partial('eshopHome/imagenes', array('eshopHome' => $eshopHome, 'indice' => null, 'tipo' => 'BPRNO')); ?>

	</div>


	<?php foreach( eshopHome::$BANNERS_SECUNDARIOS as $subIndice => $keys ): ?>
	<h3 class="h3 BSX2<?php echo $subIndice; ?>">Imagen de la Izquierda</h3>
	<div class="sf_admin_form_row rowElemento BSX2<?php echo $subIndice; ?>">
		<label>Imagen / Video <small><br/>(Dimensiones: <?php echo imageHelper::getInstance()->getWidth('eshop_home_secundario_x2_' . $keys[0])?> x <?php echo imageHelper::getInstance()->getHeight('eshop_home_secundario_x2_' . $keys[0])?>)</small></label>
		<?php echo $form["multimedia"]->render( array('name' => 'multimedia[BSX2' . $subIndice . '_1]') ); ?>
		<span class="alerta">Al agregar un nuevo banner el mismo remplaza al anterior, asi como tambien su URL</span>
		<br /><br /><br />
		<label>Imagen - Hover <small><br/>(Dimensiones: <?php echo imageHelper::getInstance()->getWidth('eshop_home_secundario_x2_' . $keys[0])?> x <?php echo imageHelper::getInstance()->getHeight('eshop_home_secundario_x2_' . $keys[0])?>)</small></label>
		<?php echo $form["multimedia"]->render( array('name' => 'multimedia[BSX2' . $subIndice . '_1_HOVER]') ); ?>
		<span class="alerta">Esta imagen solo debe subirse, si el primer archivo no es un video</span>
		<br /><br /><br />
		<label>Poster Video <small><br/>(Dimensiones: <?php echo imageHelper::getInstance()->getWidth('eshop_home_secundario_x2_' . $keys[0])?> x <?php echo imageHelper::getInstance()->getHeight('eshop_home_secundario_x2_' . $keys[0])?>)</small></label>
		<?php echo $form["multimedia"]->render( array('name' => 'multimedia[BSX2' . $subIndice . '_1_POSTER]') ); ?>
		<span class="alerta">Esta imagen solo debe subirse, si el primer archivo es un video</span>
		<br /><br /><br />
		<label>URL</label>
		<?php echo $form["link"]->render( array('name' => 'link[BSX2' . $subIndice . '_1]') ); ?>
		<?php include_partial('eshopHome/imagenes', array('eshopHome' => $eshopHome, 'indice' => 1, 'tipo' => 'BSX2' . $subIndice . '')); ?>
	</div>

	<h3 class="h3 BSX2<?php echo $subIndice; ?>">Imagen de la Derecha</h3>
	<div class="sf_admin_form_row rowElemento BSX2<?php echo $subIndice; ?>">
		<label>Imagen / Video <small><br/>(Dimensiones: <?php echo imageHelper::getInstance()->getWidth('eshop_home_secundario_x2_' . $keys[1])?> x <?php echo imageHelper::getInstance()->getHeight('eshop_home_secundario_x2_' . $keys[1])?>)</small></label>
		<?php echo $form["multimedia"]->render( array('name' => 'multimedia[BSX2' . $subIndice . '_2]') ); ?>
		<span class="alerta">Al agregar un nuevo banner el mismo remplaza al anterior, asi como tambien su URL</span>
		<br /><br /><br />
		<label>Imagen - Hover <small><br/>(Dimensiones: <?php echo imageHelper::getInstance()->getWidth('eshop_home_secundario_x2_' . $keys[1])?> x <?php echo imageHelper::getInstance()->getHeight('eshop_home_secundario_x2_' . $keys[1])?>)</small></label>
		<?php echo $form["multimedia"]->render( array('name' => 'multimedia[BSX2' . $subIndice . '_2_HOVER]') ); ?>
		<span class="alerta">Esta imagen solo debe subirse, si el primer archivo no es un video</span>
		<br /><br /><br />
		<label>Poster Video <small><br/>(Dimensiones: <?php echo imageHelper::getInstance()->getWidth('eshop_home_secundario_x2_' . $keys[1])?> x <?php echo imageHelper::getInstance()->getHeight('eshop_home_secundario_x2_' . $keys[1])?>)</small></label>
		<?php echo $form["multimedia"]->render( array('name' => 'multimedia[BSX2' . $subIndice . '_2_POSTER]') ); ?>
		<span class="alerta">Esta imagen solo debe subirse, si el primer archivo es un video</span>
		<br /><br /><br />
		<label>URL</label>
		<?php echo $form["link"]->render( array('name' => 'link[BSX2' . $subIndice . '_2]') ); ?>
		<?php include_partial('eshopHome/imagenes', array('eshopHome' => $eshopHome, 'indice' => 2, 'tipo' => 'BSX2' . $subIndice . '')); ?>
	</div>
	<?php endforeach; ?>

	<h3 class="h3 BSEX3">Imagen de la Izquierda</h3>
	<div class="sf_admin_form_row rowElemento BSEX3">
		<label>Imagen / Video <small><br/>(Dimensiones: <?php echo imageHelper::getInstance()->getWidth('eshop_home_secundario_x3')?> x <?php echo imageHelper::getInstance()->getHeight('eshop_home_secundario_x3')?>)</small></label>
		<?php echo $form["multimedia"]->render( array('name' => 'multimedia[BSEX3_1]') ); ?>
		<span class="alerta">Al agregar un nuevo banner el mismo remplaza al anterior, asi como tambien su URL</span>
		<br /><br /><br />
		<label>Imagen - Hover <small><br/>(Dimensiones: <?php echo imageHelper::getInstance()->getWidth('eshop_home_secundario_x3')?> x <?php echo imageHelper::getInstance()->getHeight('eshop_home_secundario_x3')?>)</small></label>
		<?php echo $form["multimedia"]->render( array('name' => 'multimedia[BSEX3_1_HOVER]') ); ?>
		<span class="alerta">Esta imagen solo debe subirse, si el primer archivo no es un video</span>
		<br /><br /><br />
		<label>Poster Video <small><br/>(Dimensiones: <?php echo imageHelper::getInstance()->getWidth('eshop_home_secundario_x3')?> x <?php echo imageHelper::getInstance()->getHeight('eshop_home_secundario_x3')?>)</small></label>
		<?php echo $form["multimedia"]->render( array('name' => 'multimedia[BSEX3_1_POSTER]') ); ?>
		<span class="alerta">Esta imagen solo debe subirse, si el primer archivo es un video</span>
		<br /><br /><br />
		<label>URL</label>
		<?php echo $form["link"]->render( array('name' => 'link[BSEX3_1]') ); ?>
		<?php include_partial('eshopHome/imagenes', array('eshopHome' => $eshopHome, 'indice' => 1, 'tipo' => 'BSEX3')); ?>
	</div>

	<h3 class="h3 BSEX3">Imagen del Centro</h3>
	<div class="sf_admin_form_row rowElemento BSEX3">
		<label>Imagen / Video <small><br/>(Dimensiones: <?php echo imageHelper::getInstance()->getWidth('eshop_home_secundario_x3')?> x <?php echo imageHelper::getInstance()->getHeight('eshop_home_secundario_x3')?>)</small></label>
		<?php echo $form["multimedia"]->render( array('name' => 'multimedia[BSEX3_2]') ); ?>
		<span class="alerta">Al agregar un nuevo banner el mismo remplaza al anterior, asi como tambien su URL</span>
		<br /><br /><br />
		<label>Imagen - Hover <small><br/>(Dimensiones: <?php echo imageHelper::getInstance()->getWidth('eshop_home_secundario_x3')?> x <?php echo imageHelper::getInstance()->getHeight('eshop_home_secundario_x3')?>)</small></label>
		<?php echo $form["multimedia"]->render( array('name' => 'multimedia[BSEX3_2_HOVER]') ); ?>
		<span class="alerta">Esta imagen solo debe subirse, si el primer archivo no es un video</span>
		<br /><br /><br />
		<label>Poster Video <small><br/>(Dimensiones: <?php echo imageHelper::getInstance()->getWidth('eshop_home_secundario_x3')?> x <?php echo imageHelper::getInstance()->getHeight('eshop_home_secundario_x3')?>)</small></label>
		<?php echo $form["multimedia"]->render( array('name' => 'multimedia[BSEX3_2_POSTER]') ); ?>
		<span class="alerta">Esta imagen solo debe subirse, si el primer archivo es un video</span>
		<br /><br /><br />
		<label>URL</label>
		<?php echo $form["link"]->render( array('name' => 'link[BSEX3_2]') ); ?>
		<?php include_partial('eshopHome/imagenes', array('eshopHome' => $eshopHome, 'indice' => 2, 'tipo' => 'BSEX3')); ?>
	</div>

	<h3 class="h3 BSEX3">Imagen de la Derecha</h3>
	<div class="sf_admin_form_row rowElemento BSEX3">
		<label>Imagen / Video <small><br/>(Dimensiones: <?php echo imageHelper::getInstance()->getWidth('eshop_home_secundario_x3')?> x <?php echo imageHelper::getInstance()->getHeight('eshop_home_secundario_x3')?>)</small></label>
		<?php echo $form["multimedia"]->render( array('name' => 'multimedia[BSEX3_3]') ); ?>
		<span class="alerta">Al agregar un nuevo banner el mismo remplaza al anterior, asi como tambien su URL</span>
		<br /><br /><br />
		<label>Imagen - Hover <small><br/>(Dimensiones: <?php echo imageHelper::getInstance()->getWidth('eshop_home_secundario_x3')?> x <?php echo imageHelper::getInstance()->getHeight('eshop_home_secundario_x3')?>)</small></label>
		<?php echo $form["multimedia"]->render( array('name' => 'multimedia[BSEX3_3_HOVER]') ); ?>
		<span class="alerta">Esta imagen solo debe subirse, si el primer archivo no es un video</span>
		<br /><br /><br />
		<label>Poster Video <small><br/>(Dimensiones: <?php echo imageHelper::getInstance()->getWidth('eshop_home_secundario_x3')?> x <?php echo imageHelper::getInstance()->getHeight('eshop_home_secundario_x3')?>)</small></label>
		<?php echo $form["multimedia"]->render( array('name' => 'multimedia[BSEX3_3_POSTER]') ); ?>
		<span class="alerta">Esta imagen solo debe subirse, si el primer archivo es un video</span>
		<br /><br /><br />
		<label>URL</label>
		<?php echo $form["link"]->render( array('name' => 'link[BSEX3_3]') ); ?>
		<?php include_partial('eshopHome/imagenes', array('eshopHome' => $eshopHome, 'indice' => 3, 'tipo' => 'BSEX3')); ?>
	</div>

	<h3 class="h3 BCINT">Imagen de la Cinta</h3>
	<div class="sf_admin_form_row rowElemento BCINT">
		<label>Imagen / Video <small><br/>(Ancho: <?php echo imageHelper::getInstance()->getWidth('eshop_home_cinta')?> px)</small></label>
		<?php echo $form["multimedia"]->render( array('name' => 'multimedia[BCINT]') ); ?>
		<span class="alerta">Al agregar un nuevo banner el mismo remplaza al anterior, asi como tambien su URL</span>
		<br /><br /><br />
		<label>Imagen - Hover <small><br/>(Ancho: <?php echo imageHelper::getInstance()->getWidth('eshop_home_cinta')?> px)</small></label>
		<?php echo $form["multimedia"]->render( array('name' => 'multimedia[BCINT_HOVER]') ); ?>
		<span class="alerta">Esta imagen solo debe subirse, si el primer archivo no es un video</span>
		<br /><br /><br />
		<label>Poster Video <small><br/>(Dimensiones: <?php echo imageHelper::getInstance()->getWidth('eshop_home_cinta')?> x <?php echo imageHelper::getInstance()->getHeight('eshop_home_cinta')?>)</small></label>
		<?php echo $form["multimedia"]->render( array('name' => 'multimedia[BCINT_POSTER]') ); ?>
		<span class="alerta">Esta imagen solo debe subirse, si el primer archivo es un video</span>
		<br /><br /><br />
		<label>URL</label>
		<?php echo $form["link"]->render( array('name' => 'link[BCINT]') ); ?>
		<?php include_partial('eshopHome/imagenes', array('eshopHome' => $eshopHome, 'indice' => null, 'tipo' => 'BCINT')); ?>
	</div>

	<?php foreach( eshopHome::$GRILLA as $subIndice => $keys ): ?>
		<h3 class="h3 GRLA<?php echo $subIndice; ?>">Ejemplo / Guía de la Grilla</h3>
		<div class="rowElemento ejemploGrilla GRLA<?php echo $subIndice; ?>">
			<img src="/backend/images/grilla-<?php echo $subIndice; ?>.png">
		</div>

		<?php for( $i = 1 ; $i <= 6 ; $i++ ): ?>
		<?php $key = $keys[$i - 1]; ?>
		<h3 class="h3 GRLA<?php echo $subIndice; ?>">Imagen de la Grilla Nº <?php echo $i; ?></h3>

		<div class="sf_admin_form_row rowElemento GRLA<?php echo $subIndice; ?>">
			<label>Imagen / Video <small><br/>(Dimensiones: <?php echo imageHelper::getInstance()->getWidth('eshop_home_grilla_' . $key)?> x <?php echo imageHelper::getInstance()->getHeight('eshop_home_grilla_' . $key)?>)</small></label>
			<?php echo $form["multimedia"]->render( array('name' => 'multimedia[GRLA' . $subIndice . '_' . $key . '_'. $i .']') ); ?>
			<span class="alerta">Al agregar un nuevo banner el mismo remplaza al anterior, asi como tambien su URL</span>
			<br /><br /><br />
			<label>Imagen - Hover <small><br/>(Dimensiones: <?php echo imageHelper::getInstance()->getWidth('eshop_home_grilla_' . $key)?> x <?php echo imageHelper::getInstance()->getHeight('eshop_home_grilla_' . $key)?>)</small></label>
			<?php echo $form["multimedia"]->render( array('name' => 'multimedia[GRLA' . $subIndice . '_' . $key . '_'. $i .'_HOVER]') ); ?>
			<span class="alerta">Esta imagen solo debe subirse, si el primer archivo no es un video</span>
			<br /><br /><br />
			<label>Poster Video <small><br/>(Dimensiones: <?php echo imageHelper::getInstance()->getWidth('eshop_home_grilla_' . $key)?> x <?php echo imageHelper::getInstance()->getHeight('eshop_home_grilla_' . $key)?>)</small></label>
			<?php echo $form["multimedia"]->render( array('name' => 'multimedia[GRLA' . $subIndice . '_' . $key . '_'. $i .'_POSTER]') ); ?>
			<span class="alerta">Esta imagen solo debe subirse, si el primer archivo es un video</span>
			<br /><br /><br />
			<label>URL</label>
			<?php echo $form["link"]->render( array('name' => 'link[GRLA' . $subIndice . '_' . $key . '_'. $i . ']') ); ?>
			<?php include_partial('eshopHome/imagenes', array('eshopHome' => $eshopHome, 'indice' => $i, 'tipo' => 'GRLA' . $subIndice)); ?>
		</div>
		<?php endfor; ?>

	<?php endforeach; ?>


	<div class="sf_admin_form_row rowElemento TEXTO PRODE">
		<label>Texto</label>
		<div class="content">
		<?php echo $form["texto"]; ?>
		</div>
	</div>

</div>
