<div id="sf_admin_container" class="setCategoriaML">
	<h1>Definicion de categorias, talles y colores en Mercado Libre</h1>
	
	<h2>Elegir Categoria</h2>
	
	<form method="post">
    	
        <?php echo $form['_csrf_token'] ?>
        
    	<?php echo $form['categoria'] ?>
    	<?php echo $form['categoria']->renderError() ?>
    	
    	<div id="categoriasTree"></div>
    	
    	<h2>Productos seleccionados</h2>
    	
    	<h4>Elija las opciones en Mercado Libre para cada item</h4>
    		
        <p class="autocomplete">
            <input type="checkbox" id="autocomplete_color_secundario" checked="checked">
            <label for="autocomplete_color_secundario">Utilizar función de autocompletado de color secundario</label>
        </p>
        
        <p class="autocomplete">
            <input type="checkbox" id="autocomplete_otros_productos" checked="checked">
            <label for="autocomplete_otros_productos">Utilizar función de autocompletado de talles y colores similares</label>
        </p>
    		
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
    		</tr>
    		</thead>
    		<tbody>
    		<?php foreach ($productos as $producto):?>
    		<?php foreach ($producto->getProductoItem() as $productoItem):?>
    		<tr data-talle="<?php echo $productoItem->getProductoTalle(); ?>" data-color="<?php echo $productoItem->getProductoColor(); ?>">
    			<td><?php echo $producto->getIdProducto(); ?></td>
    			<td>
    			    <img src="<?php echo imageHelper::getInstance()->getUrl('producto_lista_chica', $producto) ?>" width="100px">
    			    <?php echo $form['data']->render( array('name'=> 'productosSetCategoriaML[data][' . $productoItem->getIdProductoItem() .']') ) ?>
    		    </td>
    			<td><?php echo htmlentities($productoItem->getCodigo()); ?></td>
    			<td><a href="/backend/productos/<?php echo $producto->getIdProducto() ?>/edit"><?php echo $producto->getDenominacion(); ?></a></td>
    			<td><?php echo $producto->getMarca()->getNombre(); ?></td>
    			<td><?php echo $productoItem->getProductoTalle(); ?></td>
    			<td><?php echo $productoItem->getProductoColor(); ?></td>
    		</tr>
    		<?php endforeach; ?>
    		<?php endforeach; ?>
    		</tbody>
    	</table>
    	
    	<input type="submit" value="Guardar"/>
		
	</form>
	
</div>