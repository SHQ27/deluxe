
<div id="sf_admin_container" class="importarProductos">
		
	<div id="sf_admin_content">
	
	    <h1>
	        Importación de productos
	    </h1>
	
		<div class="sf_admin_form">
		
			<h2>Subir archivos</h2>
			
			<form enctype="multipart/form-data" method="post">
			
				<fieldset id="sf_fieldset_informaci__n_descriptiva_del_producto">					
				
						<?php echo $formCarga['_csrf_token'] ?>
						
						<div class="sf_admin_form_row">
							<div>
								<?php echo $formCarga['csv']->renderLabel(); ?>
								<div class="content">
									<?php echo $formCarga['csv']; ?>
								</div>
							</div>
						</div>
						
						<div class="sf_admin_form_row">
							<div>
								<?php echo $formCarga['imagenes']->renderLabel(); ?>
								<div class="content">
									<?php echo $formCarga['imagenes']; ?>
								</div>
							</div>
						</div>
				</fieldset>
				
				<ul class="sf_admin_actions">
	  				<li class="sf_admin_action_save"><input type="submit" value="Subir"/></li>
	  			</ul>
  			
  			</form>		
			
		</div>
	
		<div class="sf_admin_form">
		
			<h2>Archivos subidos</h2>
			
			<form  action="<?php echo url_for('producto_importar_preview'); ?>" method="get">
			
				<fieldset>												
						<?php if ($csvFileExists): ?>			
						<div class="sf_admin_form_row">
							<strong>productos.csv</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha: <?php echo date('d/m/Y H:i:s', $csvFileDate) ?> &nbsp;&nbsp;&nbsp; <a class="remove" href="/backend/productos/importar/removeCSV/importacion">Eliminar</a>
						</div>
						<?php endif; ?>
						
						<?php if ($imagenesFileExists): ?>
						<div class="sf_admin_form_row">
							<strong>imagenes.zip</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha: <?php echo date('d/m/Y H:i:s', $imagenesFileDate) ?> &nbsp;&nbsp;&nbsp; <a class="remove" href="/backend/productos/importar/removeZIP/importacion">Eliminar</a>
						</div>
						<?php endif; ?>
						
                        <div class="sf_admin_form_row">
        					<div>
        						<label>Asignar productos a eShop</label>
        						<div class="content">
                					<select name="id_eshop" id="id_eshop">
                						<option value="">DeluxeBuys</option>
                						<?php foreach ($eshops as $eshop): ?>
                						<option value="<?php echo $eshop->getIdEshop(); ?>"><?php echo $eshop->getDenominacion(); ?></option>
                						<?php endforeach; ?>
                					</select>
        						</div>
        					</div>
        				</div>

                        <div class="sf_admin_form_row divMarca">
        					<div>
        						<label>Marca</label>
        						<div class="content">
                					<select name="id_marca" id="id_marca">
                						<?php foreach ($marcas as $marca): ?>
                						<option value="<?php echo $marca->getIdMarca(); ?>"><?php echo $marca->getNombre(); ?></option>
                						<?php endforeach; ?>
                					</select>
        						</div>
        					</div>
        				</div>
        	  			
                        <div class="sf_admin_form_row divOrigen">
        					<div>
        						<label>Sumar stock en</label>
        						<div class="content">
                                    <select name="origen" id="origen">
                                        <option value="<?php echo producto::ORIGEN_OFERTA?>">Campaña</option>
                                        <option value="<?php echo producto::ORIGEN_STOCK_PERMANENTE?>">Permanante</option>
                                    </select>
        						</div>
        					</div>
        				</div>
						
				</fieldset>
	  			
	  			<input type="submit" value="Preview"/>
	  			
  			</form>
			
		</div>
		
	</div>
		
</div>