	<?php sfContext::getInstance()->getResponse()->setTitle($eshop->getMiCarroTitulo() . ' - Paso 2'); ?>

	<script>
		var carritoEnvio = <?php echo html_entity_decode($arrayCarritoEnvio); ?>;
		var direccionEnvioDefault = <?php echo html_entity_decode($arrayDireccionEnvioDefault); ?>;
		var pesoTotalCarrito = <?php echo $pesoTotalCarrito; ?>;		
	</script>

	<input id="idCampana" type="hidden" name="idCampana" value="<?php echo $idCampana; ?>"/>
    
    <section id="checkout_carrito" class="seccion blanco paso2">
    	<div class="container">
    		<div class="linea"><div class="triangulos"></div></div>
    		<div class="pantalla">
    			
    			<?php include_partial('carritoHeader', array('paso' => 2, 'eshop' => $eshop)); ?>
    			
    			<div class="forms">
    			
    				<div class="form inline envio DOM selected">

                        <div class="mask"></div>
    					
                        <div class="opcion selectorTipoEnvio">
                            <div class="radio selected">
                                <input id="tipoEnvio_DOM" type="radio" name="tipoEnvio" checked="checked" value="DOM"/>
                            </div>
                            <label class="radioLabel" for='tipoEnvio_DOM'>
                                <span class="MS-23 color4 lh21">OPCIÓN 1</span>
                                <br />
                                <span class="MS-13 color4 lh21">RECIBI TU PEDIDO EN TU DOMICILIO</span>
                            </label>
                        </div>
    					   
    					<form>
    						<div class="campo MS-13 color4">NOMBRE
    							<input name="DOM[nombre]" maxlength="30" class="OS-12 color4" type="text" />
    						</div>
    						<div class="campo MS-13 color4">APELLIDO
    							<input name="DOM[apellido]" maxlength="30" class="OS-12 color4" type="text" />
    						</div>
    						<div class="campo medio MS-13 color4 inline">CALLE
    							<input name="DOM[calle]" maxlength="30" class="OS-12 color4" type="text" />
    						</div>
    						<div class="campo chico MS-13 color4 inline">NÚMERO
    							<input name="DOM[numero]" maxlength="5" class="OS-12 color4" type="text" />
    						</div>
    						<div class="campo medio MS-13 color4 inline">PISO
    							<input name="DOM[piso]" maxlength="6" class="OS-12 color4" type="text" />
    						</div>
    						<div class="campo chico MS-13 color4 inline">DEPARTAMENTO
    							<input name="DOM[depto]" maxlength="4" class="OS-12 color4" type="text" />
    						</div>
    						<div class="campo OS-11 color2">
    						  <div class="MS-13 color4">PROVINCIA</div>
                                <div class="customSelect">
    	                            <select name="DOM[idProvincia]" title="Seleccionar">
    	                            	<option value="">Seleccionar</option>
    	                            	<?php foreach ($provincias as $provincia): ?>
    	                            	<option value="<?php echo $provincia->getIdProvincia() ?>"><?php echo $provincia->getNombre() ?></option>
    	                            	<?php endforeach; ?>
    	                            </select>
	                            </div>
    						</div>
    						<div class="campo MS-13 color4">LOCALIDAD
    							<input name="DOM[localidad]" maxlength="50" class="OS-12 color4" type="text" />
    						</div>
    						<div class="campo MS-13 color4">CÓDIGO POSTAL
    							<input name="DOM[codigoPostal]" maxlength="8" class="OS-12 color4" type="text" />
    						</div>
    					</form>

                        <div class="box boxPrecios">
                            <div class="cargando MS-13 color4">Buscando las mejores tarifas...</div>
                            <table>
                                <thead>
                                    <tr>
                                        <th class="border MS-13 color4">SERVICIO</th>
                                        <th class="border center MS-13 color4">COSTO</th>
                                        <th class="center MS-13 color4">TIEMPO ESTIMADO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

    				</div>
    				
    				<div class="form inline envio SUC">

                        <div class="mask"></div>

                        <div class="opcion selectorTipoEnvio">
                            <div class="radio">
                                <input id="tipoEnvio_SUC" type="radio" name="tipoEnvio" value="SUC"/>
                            </div>
                            <label class="radioLabel" for='tipoEnvio_SUC'>
                                <span class="MS-23 color4 lh21">OPCIÓN 2</span>
                                <br />
                                <span class="MS-13 color4 lh21">RETIRAR EN UNA SUCURSAL</span>
                            </label>
                        </div>
    				
    					<form>
    						<div class="campo MS-13 color4">NOMBRE
    							<input type="text" name="SUC[nombre]" maxlength="30"/>
    						</div>
    						<div class="campo MS-13 color4">APELLIDO
    							<input type="text" name="SUC[apellido]" maxlength="30"/>
    						</div>
    						<div class="campo OS-11 color2">
    						    <div class="MS-13 color4">PROVINCIA</div>
                                <div class="customSelect">
    	                            <select name="SUC[idProvincia]" title="Seleccionar">
    	                            	<option value="">Seleccionar</option>
    	                            	<?php foreach ($provincias as $provincia): ?>
    	                            	<option value="<?php echo $provincia->getIdProvincia() ?>"><?php echo $provincia->getNombre() ?></option>
    	                            	<?php endforeach; ?>
    	                            </select>
	                            </div>
    						</div>
    						<div class="campo OS-11 color2">
    						    <div class="MS-13 color4">LOCALIDAD</div>
                                <div class="customSelect">
    	                            <select name="SUC[idLocalidad]" title="Seleccionar">
    	                            	<option value="">Seleccionar</option>
    	                            </select>
	                           </div>
    						</div>
    					</form>

                        <div class="box boxPrecios">
                            <div class="cargando">Buscando las mejores tarifas...</div>
                            <table>
                                <thead>
                                    <tr>
                                        <th class="border MS-13 color4">ELEGÍ LA SUCURSAL</th>
                                        <th class="border center MS-13 color4">COSTO</th>
                                        <th class="center MS-13 color4">TIEMPO ESTIMADO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div id="infoSucursal" class="info hide">
                                <h2 class="MS-13 color4">Información de la sucursal seleccionada</h2>
                                <div class="data OS-11 color4"></div>
                            </div>
                        </div>
    				</div>
    				
    			</div>
    			
    			<div class="renglones">
    			    <div id="generalError" class="MS-13 rojo hide"></div>
    				<div class="renglon alto ancho dotted MS-13 color4 lh18">
    					<a href="<?php echo url_for('carrito') ?>" class="inline btLink izquierda MS-15 bold color1"><span></span>VOLVER</a>
    					<div class="inline floatR">
    						<a id="goToPaso3" class="inline btLink derecha MS-15 bold color8">SIGUIENTE<span></span></a>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </section>
    <div class="scrollToTop"></div>