<?php sfContext::getInstance()->getResponse()->setTitle( $eshop->getTiendasTitulo() ); ?>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>

<section id="tiendas" class="seccion blanco">
	<div id="map_canvas" class="mapa"></div>
	<div class="barra MS-13">
		<div class="container">
			<ul class="menu">
				<li class="current"><a href="*">TODOS</a></li>
				<?php foreach ( $categorias as $id => $denominacion ): ?>
				<li><a href=".categoria-<?php echo $id; ?>"><?php echo $denominacion; ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
	<div class="container">
		<div class="linea"><div class="triangulos"></div></div>
		<div class="pantalla">
			<div class="titulo MS-23"><?php echo $eshop->getTiendasSubtitulo(); ?></div>
			<div class="items">			
			    <?php foreach ( $eshopTiendas as $eshopTienda ): ?>
				<div class="item inline categoria-<?php echo $eshopTienda['clases']; ?>">
					<div class="MS-13 nombre"><?php echo $eshopTienda['nombre']; ?></div>
					<div class="OS-11 direccion lh19"><?php echo $eshopTienda['dir']; ?></div>
					<div class="OS-11 direccion lh19"><?php echo $eshopTienda['tel']; ?></div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

<script>
var jsonTiendas = <?php echo html_entity_decode( $jsonTiendas ); ?>;
</script>