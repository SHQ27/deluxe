	<?php sfContext::getInstance()->getResponse()->setTitle('Productos - Resultados para ' . $busqueda ); ?>
	
	<div class="center">
    	<div class="contain" style="margin-top:30px;">
        	<div class="column225 fleft">
            	<h1>Productos</h1>
                <ul class="productos"> 
                	<?php foreach ($productoGeneros as $row):?>
	                	<li>
	                		<?php if ( $row['productoGenero']->getIdProductoGenero() == $idProductoGenero ):?>
                            <a href="<?php echo make_producto_busqueda_url($idMarcas->getRawValue(), 'SIN_GENERO' ) ?>">
	                			<strong><?php echo $row['productoGenero']->getDenominacion(); ?> (x)</strong>
	                		</a>
	                		<?php else: ?>
                            <a href="<?php echo make_producto_busqueda_url($idMarcas->getRawValue(), 'GENERO', $row['productoGenero']) ?>">
	                			<strong><?php echo $row['productoGenero']->getDenominacion(); ?></strong>
	                		</a>
	                		<?php endif; ?>
		                	<ul>
	                		<?php foreach ($row['productoCategorias'] as $productoCategoria): ?>
	                			<?php if ( $productoCategoria->getIdProductoCategoria() == $idProductoCategoria ):?>                		
		                		<li class="selected">
			                		<a href="<?php echo make_producto_busqueda_url($idMarcas->getRawValue(), 'GENERO', $row['productoGenero']) ?>">
			                			<?php echo $productoCategoria->getDenominacion(); ?> (x)
			                		</a>
			                	</li>
			                	<?php else: ?>
		                		<li>
			                		<a href="<?php echo make_producto_busqueda_url($idMarcas->getRawValue(), 'CATEGORIA', $productoCategoria) ?>">
			                			<?php echo $productoCategoria->getDenominacion(); ?>
			                		</a>
			                	</li>
		                		<?php endif; ?>
			               	<?php endforeach; ?>
			               	</ul>
		             	</li>
                	<?php endforeach; ?>
                </ul>
            	<div class="line5" style="margin:15px 0px; width:200px;"></div>
                <h1>Marca</h1>                
                <ul class="productos">
                	<?php $c = count($marcas); ?>                	
                	<?php foreach ($marcas as $marca):?>
                	<?php if ($c != 1):?>
                		<?php if ( ( count($idMarcas->getRawValue()) != $c ) && in_array( $marca->getIdMarca(), $idMarcas->getRawValue() ) ):?>
                		<li class="selected"><a href="<?php echo make_producto_busqueda_url( $idMarcas->getRawValue() , 'REMOVE_MARCA', $marca->getIdMarca()) ?>"><?php echo $marca->getNombre() ?> (x)</a></li>
                		<?php else: ?>
                		<li><a href="<?php echo make_producto_busqueda_url( $idMarcas->getRawValue() , 'ADD_MARCA', $marca->getIdMarca()) ?>"><?php echo $marca->getNombre() ?></a></li>
                		<?php endif; ?>
                	<?php else: ?>
                	<li class="selected">x <a href="<?php echo make_producto_busqueda_url( $idMarcas->getRawValue() , 'REMOVE_MARCA', $marca->getIdMarca()) ?>"><?php echo $marca->getNombre() ?></a></li>
                	<?php endif; ?>
                	<?php endforeach; ?>
                </ul>
            </div>
            <div class="column710 fright">
            	<div class="contain">
                	<div class="filtroModule">
                    	<label>Resultados por Pagina:</label>
                        <select id="selectRPP"> 
                        	<?php foreach ($rpp as $val): ?>
                        	<option <?php echo ($val == $rppValue)? 'selected="selected"' : ''; ?> value="<?php echo make_producto_busqueda_url($idMarcas->getRawValue(), 'RPP', $val) ?>"><?php echo $val; ?></option>
                        	<?php endforeach; ?>
                        </select>
                    </div>
                	<div class="filtroModule">
                    	<label>Ordenar por:</label>
                        <select id="selectOrder"> 
                            <option <?php echo ($orden == 'PRECIO_ASC')?'selected="selected"' : ''; ?> value="<?php echo make_producto_busqueda_url($idMarcas->getRawValue(), 'ORDER_BY', 'PRECIO_ASC') ?>">Menor Precio</option>
                            <option <?php echo ($orden == 'PRECIO_DESC')?'selected="selected"' : ''; ?> value="<?php echo make_producto_busqueda_url($idMarcas->getRawValue(), 'ORDER_BY', 'PRECIO_DESC') ?>">Mayor Precio</option>
                            <option <?php echo ($orden == 'MAS_VISITADO')?'selected="selected"' : ''; ?> value="<?php echo make_producto_busqueda_url($idMarcas->getRawValue(), 'ORDER_BY', 'MAS_VISITADO') ?>">Más Visitados</option>
                            <option <?php echo ($orden == 'MAS_VENDIDOS')?'selected="selected"' : ''; ?> value="<?php echo make_producto_busqueda_url($idMarcas->getRawValue(), 'ORDER_BY', 'MAS_VENDIDOS') ?>">Más Vendidos</option>
                        </select>
                    </div>
                </div>
                <div id="tres" class="contain" style="margin-top:20px;">
                
                	<?php $productos = ($pager)? $pager->execute() : array(); ?>
                
					<p class="mensaje">
						<?php if ( !count($productos) ):?>
						No se encontraron resultados para "<?php echo $busqueda; ?>"
						<?php endif; ?>
					</p>
                  	
                  	<br/>
                  	
                    <ul class="listado">
                    	<?php $i = 1; ?>
                		<?php foreach ($productos as $producto):?>
                    	<li class="item" <?php echo ($i%3 == 0)? 'style="margin-right: 0px;"' : ''; echo (($i-1)%3 == 0)? 'style="clear: both;"' : ''; ?>>

                            <?php if ( $producto->estaAgotado() ): ?>
                            	<?php echo include_component('productos', 'waitList', array('producto' => $producto)); ?>
                            <?php else: ?>
                                                        	
	                        	<div class="foto">
									<div class="marco">
	                                	<a href="<?php echo $producto->getDetalleUrl(); ?>" class="imagen">
					                        <?php if ( $producto->getEsOutlet() ): ?>
					                        <div class="outlet"></div>
					                        <?php endif; ?>
	                                		<img src="<?php echo imageHelper::getInstance()->getUrl('producto_lista_grande', $producto)?>" alt="<?php echo $producto->getDenominacion() ?>"/>
	                                	</a>
	                                </div>
	                            </div>                            	
                            <?php endif; ?>

                            <div class="detalle">
                                <div class="<?php echo ($producto->esOferta())? 'infoFull' : 'infoFull'; ?>">
									<?php if ( $producto->esOferta() ): ?>
                                    <div class="containTime">
										<div class="ico"><img src="<?php echo sfConfig::get('app_host_static'); ?>/images/clockICO.jpg" alt="Oferta de tiempo limitado" title="Oferta de tiempo limitado"/></div>
										<?php $campana = $producto->getCampana(); ?>
										<?php if ( $campana->getMostrarReloj() ): ?>
										<div class="time">
											<?php $dias = diasFaltantes($campana->getFechaFin()); ?>
											<div class="day"><span class="contador_dias"><?php echo $dias ?></span> <span class="contador_texto_dias"><?php echo $dias != 1 ? ' días' : ' dia' ?></span> <span class="contador_horas"><?php echo tiempoFaltante($campana->getFechaFin()); ?></span> hs</div>
										</div>
										<?php endif; ?>
									</div>
									<?php else: ?>
                                    <div class="containPerm">
										<div class="ico"><img src="<?php echo sfConfig::get('app_host_static'); ?>/images/camion.png" alt="Envío Inmediato" title="Envío Inmediato"/></div>
										<div class="leyenda">
											Envío Inmediato
										</div>
									</div>									
                                    <?php endif; ?>
                                	<div class="marca"><?php echo $producto->getMarca()->getNombre() ?></div>
									<a <?php echo (!$producto->estaAgotado())?'href="' . $producto->getDetalleUrl() . '"':''?> class="producto"><?php echo $producto->getDenominacion() ?></a>
                                    <div class="contain">
                                        <div class="precio">
                                        <?php if ($producto->getMostrarPrecioLista()):?>
                                            $<?=formatHelper::getInstance()->formatPrice( $producto->getPrecioLista() ) ?>
                                        <?php endif; ?>
                                        </div>
                                        <div class="<?php echo ($producto->esOferta())? 'ofertaPink' : 'oferta'; ?>">$<?php echo formatHelper::getInstance()->formatPrice( $producto->getPrecioDeluxe() ) ?></div>
                                    </div>                                   
                                </div>
                            </div>
                        </li>
	                    <?php $i++; ?>
	                    <?php endforeach; ?>
                    </ul>
                    
                </div>
            </div>
        </div>
        
		<?php if ($pager and $pager->haveToPaginate()): ?>
		<div id="contentPaginator" class="contain" style="margin-top:15px;">
        	<div class="line6"></div>
            <div class="line4"></div>
            <table height="30" border="0" cellpadding="0" cellspacing="0" align="center">
                <tr class="paginador">
                	<td class="ant" valign="middle" align="left">
						<?php if ($pager->getFirstPage() != $pager->getPage()): ?>
						<a href="<?php echo make_producto_busqueda_url($idMarcas->getRawValue(), 'PAGINATION', $pager->getPreviousPage()) ?>"><span></span> Anterior</a>
						<?php endif; ?>
                    </td>
                	<td valign="middle" align="center">
					<?php foreach ($pagerRange->rangeAroundPage() as $page): ?>	
						<?php if ($pager->getPage() == $page): ?>	
							<a href="<?php echo make_producto_busqueda_url($idMarcas->getRawValue(), 'PAGINATION', $page )?>" class="select"><?php echo $page ?></a>/
						<?php else: ?>	
							<a href="<?php echo make_producto_busqueda_url($idMarcas->getRawValue(), 'PAGINATION', $page)?>"><?php echo $page ?></a>/
						<?php endif ?>	
			
					<?php endforeach; ?>  
					</td>
                    <td class="sig" valign="middle" align="right">
						<?php if ($pager->getLastPage() != $pager->getPage()): ?>
						<a href="<?php echo make_producto_busqueda_url($idMarcas->getRawValue(), 'PAGINATION', $pager->getNextPage())?>">Siguiente <span></span></a>
						<?php endif; ?>
                    </td>
            	</tr>
            </table>
        </div>
        <?php endif; ?>

    </div>
