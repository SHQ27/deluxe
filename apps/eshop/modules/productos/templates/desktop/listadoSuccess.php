<?php sfContext::getInstance()->getResponse()->setTitle( ( $productoCategoria ) ? $productoCategoria->getDenominacion() : 'Productos' ); ?>

<section id="productos" class="seccion blanco">
	<div class="container">

		<?php if ( $bannerListado ): ?>
		<div class="banner-listado">
			<img src="<?php echo $bannerListado; ?>" />
		</div>
		<?php endif; ?>

		<div class="linea"><div class="triangulos"></div></div>
		
		<div class="pantalla">

            <!--------- INICIO DE FILTRO -------->
            <?php 
            	include_component(
            		'common', 
            		'filter', 
            		array(
            			'filters'  => array('idProductoCategoria' => ( $productoCategoria ) ? $productoCategoria->getIdProductoCategoria() : null, 'idProductoGenero' => $idProductoGenero, 'rango' => $rango, 'idEshop' => $idEshop),
            			'query'    => $query
            		)
            	);
            ?>
            <!--------- FIN DEL FILTRO -------->
		
			<div class="muestra inline">
				<div class="barra OS-11 lh16 color2">
					<div class="izquierda">Inicio > <span class="bold"><?php echo ( $productoCategoria ) ? $productoCategoria->getDenominacion() : 'Productos'; ?></span></div>
					<div class="derecha">
						<div class="cantidad-modelos">
							<span class="bold cantidad-modelos"><?php echo $pager->getNumResults(); ?> <?php echo ngettext( 'MODELO', 'MODELOS', $pager->getNumResults())?></span> PARA VOS!
						</div>
						<div id="orden" class="inline">
							<select>
								<option value="">Recomendados</option>
								<option value="MAS_VENDIDOS">Más vendidos</option>
								<option value="MAS_VISITADOS">Más visitados</option>
								<option value="PRECIO_ASC">Menor precio</option>
								<option value="PRECIO_DESC">Mayor precio</option>
							</select>							
						</div>
					</div>
				</div>
				<div class="resultados">
				    <?php $i = 0; ?>
				    <?php foreach ($productos as $producto): ?>
                    <div class="resultado inline <?php echo ($i % 3 == 2) ? 'mod3' : ''; ?>">
                        <div class="producto">
						  <img class="principal" src="<?php echo imageHelper::getInstance()->getUrl('producto_lista_grande', $producto); ?>" />
						  <img class="hover" src="<?php echo imageHelper::getInstance()->getUrl('producto_lista_grande', $producto->getProductoImagenHover() ); ?>" />
						</div>
						<div class="nombre OS-12 lh16 color2" title="<?php echo $producto->getDenominacion(); ?>"><?php echo truncate_text($producto->getDenominacion(), 28) ; ?></div>
						<div class="precio OS-14 color4 <?php echo $producto->getMostrarPrecioLista() ? 'con-precio-lista' : 'sin-precio-lista' ?> ">
						  <?php if ( $producto->getMostrarPrecioLista() ): ?>
						  <span class="precioViejo">$<?php echo formatHelper::getInstance()->formatPrice( $producto->getPrecioLista() ) ?></span>
						  <?php endif; ?>
						  $<?php echo formatHelper::getInstance()->formatPrice( $producto->getPrecioDeluxe() ) ?>
    					</div>
						<div class="aviso">
							<p class="precio-contado">PRECIO CONTADO</p>
							<p class="tarjetas">(Tarjeta de Débito y Crédito en un pago)</p>
							<a class="planes" href="https://www.mercadopago.com/promociones/" target="_blank">CONSULTAR OTROS PLANES DE FINANCIACIÓN</a>
						</div>
						<a href="<?php echo $producto->getDetalleUrl(); ?>"></a>
					</div>
					<?php $i ++; ?>
					<?php endforeach; ?>
				</div>
				
            	<div id="contentPaginator">
            		<?php if ($pager->getLastPage() != $pager->getPage()): ?>
            		    <a href="<?php echo $paginationBaseUrl . $pager->getNextPage(); ?>" class="next"><span></span> Siguiente</a>
            		<?php endif; ?>
                </div>      
				
			</div>
		</div>
		
	</div>
</section>
<div class="scrollToTop"></div>