<div id="sf_admin_container" class="restaurarStockCampana">
	<h1>Restaurar stock desde una campaña pasada</h1>
	
	<?php if (count($data)): ?>
	
    	<table>
    	    <tr>
            	<th>Nombre</th>
            	<th>Fecha Inicio</th>
            	<th>Fecha Fin</th>
            	<th>Marca</th>
            	<th>Categoría</th>
            	<th>Acción</th>
    	    </tr>
    	<?php foreach( $data as $campana ): ?>
    	    <tr>
            	<td>
            	   <input class="idCampana" type="hidden" value="<?php echo $campana['id_campana']; ?>" />
            	   <?php echo $campana['denominacion']; ?>
        	   </td>
            	<td><?php echo date('d/m/Y', strtotime($campana['fecha_inicio'])); ?></td>
            	<td><?php echo date('d/m/Y', strtotime($campana['fecha_fin'])); ?></td>
            	<td>
            	<?php if ( count( $campana['marcas'] ) > 1 ): ?>
            	    <select class="idMarca">
            	        <option value="0">Todas las Marcas</option>
            	        <?php foreach ( $campana['marcas']  as $marca ): ?>
            	        <option value="<?php echo $marca['id_marca'];?>"><?php echo $marca['nombre']; ?></option>
            	        <?php endforeach; ?>
            	    </select>
        	    <?php else: ?>
        	       <?php $marca = $campana['marcas']->current(); ?>
           	       <input class="idMarca" type="hidden" value="<?php echo $marca['id_marca']; ?>" />        	       
        	       <?php echo $marca['nombre']; ?>
        	    <?php endif;?>
        	    </td>
            	<td>
            	<?php if ( count( $campana['categorias'] ) > 1 ): ?>
            	    <select class="idProductoCategoria">
            	        <option value="0">Todas las Categorías</option>
            	        <?php foreach ( $campana['categorias']  as $categoria ): ?>
            	        <option value="<?php echo $categoria['id_producto_categoria'];?>"><?php echo $categoria['denominacion']; ?></option>
            	        <?php endforeach; ?>
            	    </select>
        	    <?php else: ?>
        	    <?php 
        	    ?>
        	       <?php $categoria = $campana['categorias']->current(); ?>
           	       <input class="idProductoCategoria" type="hidden" value="<?php echo $categoria['id_producto_categoria']; ?>" />
        	       <?php echo $categoria['denominacion']; ?>
        	    <?php endif;?>
        	    </td>
        	    <td>
        	    <a href="<?php echo url_for('producto_restaurarStockCampanaMarca');?>">Restaurar stock</a>
    	        </td>
    	    </tr>
    	<?php endforeach; ?>
    	</table>
	
	<?php else: ?>
	    <p>No hay campañas disponibles de las cuales restaurar stock.</p>
	<?php endif; ?>
	
</div>