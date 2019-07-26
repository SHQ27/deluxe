	<?php sfContext::getInstance()->getResponse()->setTitle('Mi Carrito - Paso 2'); ?>

	<script>
		var carritoEnvio = <?php echo html_entity_decode($arrayCarritoEnvio); ?>;
		var direccionEnvioDefault = <?php echo html_entity_decode($arrayDireccionEnvioDefault); ?>;
		var pesoTotalCarrito = <?php echo $pesoTotalCarrito; ?>;		
	</script>

	
	<div id="checkout_carrito" class="paso2">
	
	    <div class="blank">
	
            <?php include_partial('carritoHeader', array('paso' => 2)); ?>

        	<div class="clear"></div>
        	<div class="checkoutDescription">
        		<div class="sprite ico carroEnvioPink"></div>
        		<p>
        			<span class="bold">ENVIO.</span> RECIBÍ TU PEDIDO EN TU CASA O RETIRALO EN CUALQUIER SUCURSAL
        			
                    <?php if ($tieneOfertas):?>
        			<span class="black">
        				RECORDA QUE EL PEDIDO SE ENVIARÁ LUEGO DE LOS 10 DÍAS TERMINADA LA CAMPAÑA
        			</span>	
                    <?php endif; ?>
        		</p>
        	</div>
        	
        	<input id="idCampana" type="hidden" name="idCampana" value="<?php echo $idCampana; ?>"/>
        	
            <div class="opciones">
                <h2>ELEGÍ LA MEJOR OPCIÓN PARA TU ENVÍO</h2>

                <div class="opcion">
                    <div class="pink sprite radio <?php echo ( !$tipoEnvio || $tipoEnvio == carritoEnvio::DOMICILIO ) ? 'selected' : '' ?> fleft">
                        <input id="tipoEnvio_DOM" type="radio" name="tipoEnvio" value="DOM"/>
                    </div>
                    <label class="radioLabel" for='tipoEnvio_DOM'>
                        OPCION 1 
                        <br />
                        RECIBÍ TU PEDIDO EN TU DOMICILIO.
                    </label>
                </div>

                
                <div class="opcion">
                    <div class="pink sprite radio <?php echo ( $tipoEnvio == carritoEnvio::SUCURSAL ) ? 'selected' : '' ?> fleft">
                        <input id="tipoEnvio_SUC" type="radio" name="tipoEnvio" value="SUC"/>
                    </div>
                    <label class="radioLabel" for="tipoEnvio_SUC">
                        OPCION 2
                        <br />
                        RETIRAR EN CUALQUIER SUCURSAL
                    </label>
                </div>
            </div>

            <div class="envio DOM">
                <div class="box boxForm">
                    <form>
                        <fieldset>
                            <dl>
                                <dt><label for="">Nombre</label></dt>
                                <dd><input type="text" name="DOM[nombre]" maxlength="30"/></dd>
                                <dt><label for="">Apellido</label></dt>
                                <dd><input type="text" name="DOM[apellido]" maxlength="30"/></dd>
                                <dt><label for="">Calle</label></dt>
                                <dd><input type="text" name="DOM[calle]" maxlength="30"/></dd>
                                <dt><label for="">Número</label></dt>
                                <dd><input type="text" name="DOM[numero]" maxlength="5"/></dd>
                                <dt><label for="">Piso</label></dt>
                                <dd><input type="text" name="DOM[piso]" maxlength="6"/></dd>
                                <dt><label for="">Departamento</label></dt>
                                <dd><input type="text" name="DOM[depto]" maxlength="4"/></dd>
                                <dt><label for="">Provincia</label></dt>
                                <dd>
                                    <div class="customSelect">
                                        <select name="DOM[idProvincia]">
                                            <option value="">Seleccionar</option>
                                            <?php foreach ($provincias as $provincia): ?>
                                            <option value="<?php echo $provincia->getIdProvincia() ?>"><?php echo $provincia->getNombre() ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </dd>
                                <dt><label for="">Localidad</label></dt>
                                <dd><input type="text" name="DOM[localidad]" maxlength="50"/></dd>
                                <dt><label for="">Código postal</label></dt>
                                <dd><input type="text" name="DOM[codigoPostal]" maxlength="8"/></dd>
                            </dl>
                        </fieldset>
                    </form>
                </div>

                <div class="box boxPrecios">
                    <div class="cargando">Buscando las mejores tarifas...</div>
                    <table>
                        <thead>
                            <tr>
                                <th class="border">SERVICIO</th>
                                <th class="border center">COSTO</th>
                                <th class="center">TIEMPO ESTIMADO</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
        
            </div>

            <div class="envio SUC">

                <div class="box boxForm">
                    <form>
                        <fieldset>
                            <dl>
                                <dt><label for="">Nombre</label></dt>
                                <dd><input type="text" name="SUC[nombre]" maxlength="30"/></dd>
                                <dt><label for="">Apellido</label></dt>
                                <dd><input type="text" name="SUC[apellido]" maxlength="30"/></dd>
                                <dt><label for="">Provincia</label></dt>
                                <dd>
                                    <div class="customSelect">
        	                            <select name="SUC[idProvincia]">
        	                            	<option value="">Seleccionar</option>
        	                            	<?php foreach ($provincias as $provincia): ?>
        	                            	<option value="<?php echo $provincia->getIdProvincia() ?>"><?php echo $provincia->getNombre() ?></option>
        	                            	<?php endforeach; ?>
        	                            </select>
    	                            </div>
                                </dd>
                                <dt><label for="">Localidad</label></dt>
                                <dd>
                                    <div class="customSelect">
        	                            <select name="SUC[idLocalidad]">
        	                            	<option value="">Seleccionar</option>
        	                            </select>
    	                            </div>
                                </dd>
                            </dl>
                        </fieldset>
                    </form>
                    
                </div>

                <div class="box boxPrecios">
                    <div class="cargando">Buscando las mejores tarifas...</div>
                    <table>
                        <thead>
                            <tr>
                                <th class="border">ELEGÍ LA SUCURSAL</th>
                                <th class="border center">COSTO</th>
                                <th class="center">TIEMPO ESTIMADO</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <div id="infoSucursal" class="info hide">
                        <h2>Información de la sucursal seleccionada</h2>
                        <div class="data"></div>
                    </div>
                </div>

            </div>
    	
    	    <div class="hide" id="generalError"></div>
    	    
	    </div>
        
    	<div class="checkoutFooterItem">
    		<div class="fleft">
    			<a href="<?php echo url_for('carrito') ?>">
            	    <span>&lt;</span>
            	    ANTERIOR
        	    </a>
    		</div>
    		<div class="fright">
    			<a class="pink" id="goToPaso3" onclick="ga('send', 'event', 'boton', 'intencion de compra', 'envio');">
    			    SIGUIENTE
    			    <span>&gt;</span>
    			</a>
    		</div>
    	</div>
	</div>
	
	<?php include_partial('global/tagsRemarketing', array('itemId1' => 'Carrito - Paso 2', 'pageType' => 'conversionintent')); ?>