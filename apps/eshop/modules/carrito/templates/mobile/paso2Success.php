	<?php sfContext::getInstance()->getResponse()->setTitle($eshop->getMiCarroTitulo() . ' - Paso 2'); ?>

	<script>
		var carritoEnvio = <?php echo html_entity_decode($arrayCarritoEnvio); ?>;
		var direccionEnvioDefault = <?php echo html_entity_decode($arrayDireccionEnvioDefault); ?>;
		var pesoTotalCarrito = <?php echo $pesoTotalCarrito; ?>;		
	</script>

	<input id="idCampana" type="hidden" name="idCampana" value="<?php echo $idCampana; ?>"/>
    
    <section id="checkout_carrito" class="seccion blanco paso2">
        <div class="titulo"><?php echo strtoupper( $eshop->getMiCarroTitulo() ); ?></div>

        <div class="headerCarrito">ELEGÍ LA FORMA DE ENVÍO</div>

    	<div class="forms">
            <div class="form envio DOM">
                <div class="opcion selectorTipoEnvio">
                    <div class="radio selected" id="radioDOM">
                        <input id="tipoEnvio_DOM" type="radio" name="tipoEnvio" checked="checked" value="DOM"/>
                    </div>
                    <label class="radioLabel" for='tipoEnvio_DOM' id="radioDOM">
                        <span class="tituloOpcion">OPCIÓN 1</span>
                        <br />
                        <span class="subtituloOpcion">RECIBI TU PEDIDO EN TU DOMICILIO</span>
                    </label>
                </div>
    			
                <div class="formDOM">
        			<form>
        				<div class="campo">NOMBRE
        					<input name="DOM[nombre]" maxlength="30" type="text" />
        				</div>
        				<div class="campo">APELLIDO
        					<input name="DOM[apellido]" maxlength="30" type="text" />
        				</div>
        				<div class="campo">CALLE
        					<input name="DOM[calle]" maxlength="30" type="text" />
        				</div>
        				<div class="campo">NÚMERO
        					<input name="DOM[numero]" maxlength="5" type="text" />
        				</div>
        				<div class="campo">PISO
        					<input name="DOM[piso]" maxlength="6" type="text" />
        				</div>
        				<div class="campo">DEPARTAMENTO
        					<input name="DOM[depto]" maxlength="4" type="text" />
        				</div>
        				<div class="campo">
        				    PROVINCIA
                            <div class="customSelect">
                                <select name="DOM[idProvincia]" title="Seleccionar">
                                	<option value="">Seleccionar</option>
                                	<?php foreach ($provincias as $provincia): ?>
                                	<option value="<?php echo $provincia->getIdProvincia() ?>"><?php echo $provincia->getNombre() ?></option>
                                	<?php endforeach; ?>
                                </select>
                            </div>
        				</div>
        				<div class="campo">LOCALIDAD
        					<input name="DOM[localidad]" maxlength="50" type="text" />
        				</div>
        				<div class="campo">CÓDIGO POSTAL
        					<input name="DOM[codigoPostal]" maxlength="8" type="text" />
        				</div>
        			</form>

                    <div class="box boxPrecios">
                        <div class="cargando">Buscando las mejores tarifas...</div>
                        <table>
                            <thead>
                                <tr>
                                    <th class="border">SERVICIO</th>
                                    <th class="border center">COSTO</th>
                                    <th class="center">TIEMPO<br />ESTIMADO</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </div>
    		</div>
    		
    		<div class="form envio SUC">
                <div class="opcion selectorTipoEnvio">
                    <div class="radio" id="radioSUC">
                        <input id="tipoEnvio_SUC" type="radio" name="tipoEnvio" value="SUC"/>
                    </div>
                    <label class="radioLabel" for='tipoEnvio_SUC' id="radioSUC">
                        <span class="tituloOpcion">OPCIÓN 2</span>
                        <br />
                        <span class="subtituloOpcion">RETIRAR EN UNA SUCURSAL</span>
                    </label>
                </div>
    		
                <div class="formSUC">
        			<form>
        				<div class="campo">NOMBRE
        					<input type="text" name="SUC[nombre]" maxlength="30"/>
        				</div>
        				<div class="campo">APELLIDO
        					<input type="text" name="SUC[apellido]" maxlength="30"/>
        				</div>
        				<div class="campo">
        				    PROVINCIA
                            <div class="customSelect">
                                <select name="SUC[idProvincia]" title="Seleccionar">
                                	<option value="">Seleccionar</option>
                                	<?php foreach ($provincias as $provincia): ?>
                                	<option value="<?php echo $provincia->getIdProvincia() ?>"><?php echo $provincia->getNombre() ?></option>
                                	<?php endforeach; ?>
                                </select>
                            </div>
        				</div>
        				<div class="campo">
        				    LOCALIDAD
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
                                    <th class="border">ELEGÍ LA SUCURSAL</th>
                                    <th class="border center">COSTO</th>
                                    <th class="center">TIEMPO<br />ESTIMADO</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div id="infoSucursal" class="info hide">
                            <h2>Información de la sucursal seleccionada</h2>
                            <div class="data direccion"></div>
                        </div>
                    </div>

                </div>
    		</div>
    		
    	</div>

        <div id="generalError" class="hide"></div>
        
        <div class="botoneraPaso2">
            <div class="row">
                <div class="col21"><a href="<?php echo url_for('carrito'); ?>" class="btVolver">< VOLVER</a></div>
                <div class="col22"><a id="goToPaso3" class="btContinuar">SIGUIENTE</a></div>
            </div>
        </div>
    </section>