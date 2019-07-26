<div id="sf_admin_container" class="publicarML">
	<h1>Publicar los siguientes productos en Mercado Libre</h1>
	
	<form method="post">
    	
        <?php echo $form['_csrf_token'] ?>
	
    	<table>
    	    <thead>
    		<tr>
    			<th>Id Producto</th>
    			<th>Imagen</th>
    			<th>Codigo</th>
    			<th>Nombre</th>
    			<th>Marca</th>
    			<th>Talle</th>
    			<th>Color</th>
    			<th>Stock</th>
    			<th>Alertas</th>
    		</tr>
    		</thead>
    		<tbody>
    		<?php foreach ($productos as $producto):?>
    		<?php $productoItems = $producto->getProductoItem(); ?>
    		<?php $categoriaML = $producto->getCategoriaMl(); ?>
    		<?php foreach ($productoItems as $productoItem):?>
    		
    		<?php if ( $productoItem->getCurrentStock() <= 0 ): ?>
    		<?php continue; ?>
    		<?php endif;?>
    		
    		<tr>
    			<td>
    			    <input type="hidden" value="<?php echo $producto->getIdProducto(); ?>" name="productosPublicarML[ids][]">
    			    <?php echo $producto->getIdProducto(); ?>
			    </td>
    			<td>
    			    <img src="<?php echo imageHelper::getInstance()->getUrl('producto_lista_chica', $producto) ?>" width="100px">
    		    </td>
    			<td><?php echo htmlentities($productoItem->getCodigo()); ?></td>
    			<td><a href="/backend/productos/<?php echo $producto->getIdProducto() ?>/edit"><?php echo $producto->getDenominacion(); ?></a></td>
    			<td><?php echo $producto->getMarca()->getNombre(); ?></td>
    			<td><?php echo $productoItem->getProductoTalle(); ?></td>
    			<td><?php echo $productoItem->getProductoColor(); ?></td>
    			<td><?php echo $productoItem->getCurrentStock(); ?></td>
    			<td>
    			
    	    		<?php if ( $producto->getIdEshop() !== null && !in_array($producto->getIdEshop(), $sf_data->getRaw('eshopsEnabled') ) ): ?>
        		    <span class="ko">
        			    Este producto no se puede publicar.
        			    <br/>
        			    Pues pertenece a un eshop que no esta habilitado para publicar<br />en Mercado Libre.
        			    <br/><br/>
        			    <strong>Si continua el proceso se va a desestimar la publicación del mismo.</strong>
    			    </span>
    	    		<?php elseif ( !$producto->getIdCategoriaMl() ): ?>
        		    <span class="ko">
        			    Este producto no se puede publicar.
        			    <br/>
        			    Pues no tiene categoria de Mercado Libre asignada.
        			    <br/><br/>
        			    <strong>Si continua el proceso se va a desestimar la publicación del mismo.</strong>
    			    </span>
    	    		<?php elseif ( $categoriaML->getAttributeTypes() != categoriaMl::ATTR_TYPE_VARIATIONS && count($productoItems) != 1 ): ?>
        		    <span class="ko">
        			    Este producto no se puede publicar en la categoría "<?php echo $categoriaML->getDenominacion(); ?>".
        			    <br/>
        			    Pues dicha categoría no permite variaciones de producto.
        			    <br/><br/>
        			    <strong>Si continua el proceso se va a desestimar la publicación del mismo.</strong>
    			    </span>
    			    <?php elseif ( $producto->getPublicacionMl()->estaVigente() ): ?>
        		    <span class="ko">
        			    Este producto no se puede publicar.
        			    <br/>
        			    Pues ya está publicado en Mercado Libre
        			    <br/><br/>
        			    <strong>Si continua el proceso se va a desestimar la publicación del mismo.</strong>
    			    </span>
        			<?php else: ?>
    		        <span class="ok">OK</span>
    	    		<?php endif; ?>
    			</td>
    		</tr>
    		<?php endforeach; ?>
    		<?php endforeach; ?>
    		</tbody>
    	</table>
    	
    	<input type="submit" value="Confirmar"/>	    	
		
	</form>

</div>