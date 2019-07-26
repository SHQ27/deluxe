<?php sfContext::getInstance()->getResponse()->setTitle( sfContext::getInstance()->getResponse()->getTitle() . ' - ' . $campana->getMarcas() ); ?>
    

<div class="listadoProductos ofertaDetalle">

	<div class="boxContainer banner">
		<img src="<?php echo  imageHelper::getInstance()->getUrl('campana_header', $campana); ?>" width="960" height="280" />
		<div class="description Merriweather">
			<span class="denominacion"><?php echo $campana->getDenominacion(); ?></span>
			<?php if ( $campana->getMostrarReloj() ): ?>
			<span>/</span> 
			<?php $dias = diasFaltantes( $campana->getFechaFin() ); ?>
        	<span class="contador_dias timeStamp" rel="<?php echo $dias; ?>"><?php echo $dias; ?> <?php echo( $dias != 1 ) ? ' Días' : ' Día' ?></span>
        	<span class="contador_horas timeStamp"><?php echo tiempoFaltante( $campana->getFechaFin() ); ?></span>
        	<span> HS</span>
        	<?php endif; ?>
		</div>
	</div>

	<div class="clear"></div>
	
	
    <!--------- INICIO DE FILTRO -------->
    <?php 
    	include_component(
    		'common', 
    		'filter', 
    		array(
    			'filters'  => array('idCampana' => $campana->getIdCampana(), 'rango' => $rango),
    			'query'    => $query
    		)
    	);
    ?>
    <!--------- FIN DEL FILTRO -------->

    <?php if ( !count($productos)): ?>
	<div class="no-results">No hay productos disponibles para los filtros aplicados.</div>
	<?php else: ?>
    
    <div class="listado">
	    <?php $i = 0; ?>
	    <?php foreach ($productos as $producto): ?>
		<div class="item boxContainer listado <?php echo ($i % 3 == 2) ? 'columnRight' : ''; ?> <?php echo ($i % 3 == 0) ? 'columnLeft' : ''; ?>">
		
            <?php if ( $producto->getCurrentStock() < 3 && !$producto->estaAgotado()) : ?>
            <span class="lastUnits">¡ÚLTIMAS UNIDADES!</span>
            <?php endif; ?>
		
			<div class="insideBox">
						
												
			    <?php if ( $producto->getProductoSticker() && $producto->getProductoSticker()->exists() ): ?>
                <div>
                    <img class="sticker" src="<?php echo imageHelper::getInstance()->getUrl('producto_sticker_chico', $producto->getProductoSticker() ); ?>" />
                </div>
                <?php endif; ?>
                
				<img src="<?php echo  imageHelper::getInstance()->getUrl('producto_lista_grande', $producto); ?>" width="293" height="443" />
                <?php if ( $producto->estaAgotado() ): ?>
                	<?php echo include_component('productos', 'waitList', array('producto' => $producto)); ?>
                <?php else: ?>
                <a class="link" href="<?php echo $producto->getDetalleUrl(); ?>"></a>
                <?php endif; ?>
				<div class="description">
					<div class="product">
						<h2><?php echo truncate_text( $producto->getMarca()->getNombre(), 25 ) ?></h2>
						<p><?php echo truncate_text( $producto->getDenominacion(), 25 ) ?></p>
					</div>
					<div class="prices">
					    <?php if ( $producto->getMostrarPrecioLista() ): ?>
						<span class="priceList">$<?php echo formatHelper::getInstance()->formatPrice( $producto->getPrecioLista() ); ?></span>
						<?php else: ?>
						<span class="priceList no-data">&nbsp;</span>
						<?php endif; ?>
						<span class="offerPrice">$<?php echo formatHelper::getInstance()->formatPrice( $producto->getPrecioDeluxe() ) ?></span>
					</div>
				</div>
                
			</div>
		</div>
		<?php $i ++; ?>
		<?php endforeach; ?>


	</div>
	
                
	<div id="contentPaginator">
		<?php if ($pager->getLastPage() != $pager->getPage()): ?>
		    <a href="<?php echo $paginationBaseUrl . $pager->getNextPage(); ?>" class="next"><span></span> Siguiente</a>
		<?php endif; ?>
    </div>
    
    <?php endif; ?>
	
	<a class="sprite subir"></a>

	<?php include_partial('global/tagsRemarketing', array('itemId1' => $campana->getDenominacion(), 'pageType' => 'searchresults')); ?>
	
</div>