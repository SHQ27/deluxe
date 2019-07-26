<?php sfContext::getInstance()->getResponse()->setTitle( $eshop->getTiendasTitulo() ); ?>

<div class="tiendas">
	<div id="map_canvas" class="mapa"></div>
	<div class="listado">
		<div class="titulo"><?php echo $eshop->getTiendasTitulo(); ?></div>
		<div class="items">			
		    <?php foreach ( $eshopTiendas as $eshopTienda ): ?>
			<div class="item">
				<div class="nombre"><?php echo $eshopTienda['nombre']; ?></div>
				<div class="direccion"><?php echo $eshopTienda['dir']; ?></div>
				<div class="telefono"><?php echo $eshopTienda['tel']; ?></div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<script>
var jsonTiendas = <?php echo html_entity_decode( $jsonTiendas ); ?>;
</script>