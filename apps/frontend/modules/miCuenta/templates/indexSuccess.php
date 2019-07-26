<?php sfContext::getInstance()->getResponse()->setTitle( 'Mi Cuenta' ); ?>

    <?php if ($seccion = $sf_request->getParameter('seccion')): ?>
    <script>
    $(function () { 
        $('.miCuentaMenu a[rel="<?php echo $seccion?>"]').click();
    });
    </script>
    <?php endif; ?>

	<div id="mi_cuenta">
		<div class="wrapper content">

			<div class="miCuentaMenu fleft">
				<h1>MI CUENTA</h1>
				<ul>
					<li><a rel="datosPersonales" class="item selected">DATOS PERSONALES</a></li>
					<li><a rel="pedidos" class="item">PEDIDOS</a></li>
					<li><a rel="devoluciones" class="item">DEVOLUCIONES</a></li>
					<li><a rel="consultaEnvio" class="item">CONSULTA TU ENVÍO</a></li>
					<li><a rel="creditos" class="item">CRÉDITOS</a></li>
					<li><a rel="desactivarCuenta" class="item">DESACTIVAR MI CUENTA</a></li>
				</ul>
			</div>

			<div class="menuForm fleft">
				<div class="seccion show" id="datosPersonales">
				
                	<?php if ($sf_user->getFlash('datos_personales_guardado')): ?>
                	<div class="alert">El teléfono ha sido actualizado.</div>
                	<?php endif; ?>
                	
                	<?php if ($sf_user->getFlash('pass_modificada')): ?>
                	<div class="alert">La contraseña ha sido actualizada.</div>
                	<?php endif; ?>
                	
                	<?php if ( $modificarEmailForm->hasGlobalErrors() ): ?>
                	<div class="alert rojo"><?php echo $modificarEmailForm->renderGlobalErrors(); ?></div>
                	<?php endif; ?>
                	
                	<?php if ($sf_user->getFlash('email_modificado')): ?>
                	<div class="message">
                		<div class="alert">La dirección de email ha sido actualizada.</div>
                		
                		<p>
                    		Acabamos de enviarte un e-mail de re-activación para verificar que tu email sea válido.
                    		<br />
                    		No te olvides de hacer click en el link de dicho email para volver a activar tu cuenta.    		
                		</p>
            		</div>
                	<?php endif; ?>
                	
                	<?php if ($sf_user->getFlash('direccion_modificada')): ?>
                	<div class="alert">La dirección de envío ha sido actualizada.</div>
                	<?php endif; ?>
                					    
                    <p>
                    	Desde aquí podes modificar tu información personal. Podes cambiar tu email,
                    	<br />
                    	contrase&ntilde;a, modificar tu dirección de envío y actualizar tus teléfonos.
                    	<br />
                    	<span>Estos cambios no se aplicaran a pedidos realizados con anterioridad.</span>
                    </p>
                    
                    
                    <h2 class="margin-top15 margin-bottom15">
                        MODIFICAR TELÉFONO
                    </h2>
                    
                    <form method="post" action="<?php echo url_for('@mi_cuenta') ?>">
                        <?php echo $datosPersonalesForm['_csrf_token']; ?>
                    	<fieldset class="deluxeFormFieldset">
                    		<dl>
                    			<dt><label>TELÉFONO</label></dt>
                    			<?php $errorClass = ( $datosPersonalesForm['telefono']->getError() ) ? 'error' : ''; ?>
                    			<dd><?php echo $datosPersonalesForm['telefono']->render( array('class' => $errorClass )); ?></dd>
                    		</dl>
                    	</fieldset>
                    	<input type="submit" class="formInputSubmit formInputButton" value="GUARDAR" />
                    </form>
                    
                    
                    <h2 class="margin-top15 margin-bottom15">
                        MODIFICAR CONTRASE&Ntilde;A
                    </h2>
                    
                    <form method="post" action="<?php echo url_for('@mi_cuenta') ?>">
                        <?php echo $modificarPassForm['_csrf_token']; ?>
                    	<fieldset class="deluxeFormFieldset">
                    		<dl>
                    			<dt><label>contrase&ntilde;a actual</label></dt>
                    			<?php $errorClass = ( $modificarPassForm['old']->getError() || $modificarPassForm->renderGlobalErrors() ) ? 'error' : ''; ?>
                    			<dd><?php echo $modificarPassForm['old']->render( array('class' => $errorClass )); ?></dd>
                    			<dt><label>contrase&ntilde;a nueva</label></dt>
                    			<?php $errorClass = ( $modificarPassForm['new']->getError() || $modificarPassForm->renderGlobalErrors() ) ? 'error' : ''; ?>
                    			<dd><?php echo $modificarPassForm['new']->render( array('class' => $errorClass )); ?></dd>
                    		</dl>
                    	</fieldset>
                    	<input type="submit" class="formInputSubmit formInputButton" value="GUARDAR" />
                    </form>
                    
                    
                    <h2 class="margin-top15 margin-bottom15">
                        MODIFICAR DIRECCIÓN DE EMAIL
                    </h2>
                    
                    <form method="post" action="<?php echo url_for('@mi_cuenta') ?>">
                        <?php echo $modificarEmailForm['_csrf_token']; ?>
                    	<fieldset class="deluxeFormFieldset">
                    		<dl>
                    			<dt><label>nuevo e-mail</label></dt>
                    			<?php $errorClass = ( $modificarEmailForm['email']->getError() ) ? 'error' : ''; ?>
                    			<dd><?php echo $modificarEmailForm['email']->render( array('class' => $errorClass )); ?></dd>
                    		</dl>
                    	</fieldset>
                    	<input type="submit" class="formInputSubmit formInputButton" value="GUARDAR" />
                    </form>                    
                    
                    <div class="direccionEntregaUsuario">
                    
                        <h2 class="margin-top15 margin-bottom15">
                            DIRECCIÓN DE ENTREGA
                        </h2>
                    
                    	<span>¿AÚN NO TIENES UNA DIRECCIÓN CARGADA?</span>
                    	<a class="button">EDITAR</a>
                    	
                    	<div id="direccionEntrega" class="<?php echo ( $direccionEnvioForm->hasErrors() ) ? 'show' : 'hide' ?>">
                            <form method="post" action="<?php echo url_for('@mi_cuenta') ?>">
                                <?php echo $direccionEnvioForm['_csrf_token']; ?>
                            	<fieldset class="deluxeFormFieldset">
                            		<dl>
                            			<dt><label>Calle</label></dt>
                            			<?php $errorClass = ( $direccionEnvioForm['calle']->getError() ) ? 'error' : ''; ?>
                            			<dd><?php echo $direccionEnvioForm['calle']->render( array('class' => $errorClass )); ?></dd>
                            			<dt><label>Número</label></dt>
                            			<?php $errorClass = ( $direccionEnvioForm['numero']->getError() ) ? 'error' : ''; ?>
                            			<dd><?php echo $direccionEnvioForm['numero']->render( array('class' => $errorClass )); ?></dd>
                            			<dt><label>Piso</label></dt>
                            			<?php $errorClass = ( $direccionEnvioForm['piso']->getError() ) ? 'error' : ''; ?>
                            			<dd><?php echo $direccionEnvioForm['piso']->render( array('class' => $errorClass )); ?></dd>
                            			<dt><label>Departamento</label></dt>
                            			<?php $errorClass = ( $direccionEnvioForm['depto']->getError() ) ? 'error' : ''; ?>
                            			<dd><?php echo $direccionEnvioForm['depto']->render( array('class' => $errorClass )); ?></dd>
                            			<dt><label>Provincia</label></dt>
                            			<dd><div class="customSelect"><?php echo $direccionEnvioForm['id_provincia'] ?></div></dd>
                            			<dt><label>Localidad</label></dt>
                            			<dd><?php echo $direccionEnvioForm['localidad'] ?></dd>
                            			<dt><label>Código Postal</label></dt>
                            			<?php $errorClass = ( $direccionEnvioForm['codigo_postal']->getError() ) ? 'error' : ''; ?>
                            			<dd><?php echo $direccionEnvioForm['codigo_postal']->render( array('class' => $errorClass )); ?></dd>
                            		</dl>
                            	</fieldset>
                            	<input type="submit" class="formInputSubmit formInputButton" value="GUARDAR" />
                            </form>
                    	</div>
                    </div>
				</div>
				
				<div class="seccion hide" id="pedidos">
				
                    <h2 class="pedidosSummary">ESTE ES EL RESUMEN DE TUS ÚLTIMOS PEDIDOS.</h2>


                	<?php if (count($ultimosPedidos)): ?>
                	
                	<div class="listaPedidos">
                	
                    	<?php foreach ($ultimosPedidos as $i => $pedido): ?>
                        <div class="pedido">
                        	<div class="column numero">
                        		<h3>N°</h3>
                        		<span><?php echo $pedido->getIdPedido() ?></span>
                        	</div>
                        	<div class="column fecha">
                        		<h3>FECHA</h3>
                        		<span><?php echo date('d/m/Y H:i', strtotime($pedido->getFechaAlta())) ?></span>
                        	</div>
                        	<div class="column estado">
                        		<h3>ESTADO</h3>
                        		<span><?php echo $pedido->getEstado() ?></span>
                        	</div>
                        	<div class="column total">
                        		<h3>TOTAL COMPRA</h3>
                        		<span>$ <?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoTotal() ); ?></span>
                        	</div>
                        	<div class="column acciones">
                        		<ul>                           			
                                    <li><a href="<?php echo url_for('mi_cuenta_detalle_pedido', $pedido) ?>" class="verPedidos linkArrow dblock">VER</a></li>
                                    <?php $tracking = $pedido->getTracking(); ?>
	
	                                <?php if ( $tracking && count($tracking) ): ?>
                                    <li><a href="<?php echo url_for('mi_cuenta_detalle_envio', $pedido) ?>" class="ocaTracking linkArrow dblock">TRACKING</a></li>
                                    <?php endif; ?>
                                    
                                    <?php if (!$pedido->getFechaPago() && !$pedido->getFechaBaja()): ?>
                                    <li><a onclick="if (confirm('Estas seguro/a?')) { window.location.href='<?php echo url_for('mi_cuenta_baja_pedido', array( 'idPedido' => $pedido->getIdPedido() ) ); ?>' };return false;" class="linkArrow dblock">DAR DE BAJA</a></li>
                                    <?php endif; ?>

                                	<?php $factura = $pedido->getFactura(); ?>
                                	<?php if ( $factura && $factura->getProcesada() && $factura->getEntorno() == Afip::PROD && $factura->getResultado() == 'A' ): ?>
                                	<li><a href="<?php echo url_for('mi_cuenta_descargar_factura', array( 'idPedido' => $pedido->getIdPedido() ) ); ?>" class="linkArrow dblock">FACTURA</a></li>
                                	<?php endif; ?>
                        		</ul>
                        	</div>
                        </div>
                    	<?php endforeach; ?>
                    	
                    	<div id="verPedidos"></div>
                    	<div id="ocaTracking"></div>
                    	
                    </div>
                    	
                    <?php else: ?>
                    <p>Aún no has realizado ningún pedido. Ingresá en <a href="<?php echo url_for('@ofertas_listado')?>">ofertas</a> para realizar tu primera compra.</p>
					<?php endif; ?>    
			    </div>
			    
				<div class="seccion hide" id="devoluciones">
				<?php include_component('miCuenta', 'devoluciones')?>
				</div>
			    
			    <div class="seccion hide" id="consultaEnvio">
			    
					<h2 class="margin-bottom30">CONSULTA TU ENVÍO</h2>
					<p class="margin-top15">
					    Ingresa tu numero de pedido y verifica la fecha de envío y el estado del mismo.
					</p>

					<form>
						<fieldset class="deluxeFormFieldset">
							<dl>
								<dt><label>N° de pedido:</label></dt>
								<dd><input type="text" id="verificar_id_pedido" /></dd>
							</dl>
						</fieldset>
						
						<input id="verificarEnvio" type="submit" class="formInputButton formInputSubmit fleft" value="CONSULTAR" />
							
                        <div id="respuesta_consultaEnvio"></div>
					</form>
			    </div>
			    
			    
			    <div class="seccion hide" id="creditos">
					<h2>CRÉDITOS</h2>
					<p class="margin-top15 margin-bottom30">
					    Este es un resumen de todos tus créditos utilizados y disponibles
					</p>
					<div class="listaCreditos">
						<p class="credito title">
							<span class="fright normalizedText">CRÉDITO UTILIZADO <span
							class="bold serif">$ <?php echo formatHelper::getInstance()->decimalNumber( $creditoUtilizado ); ?></span></span>
						</p>
					</div>
					
					<div class="clear margin-top15 margin-bottom15"></div>

					<div class="listaCreditos">
						<h2 class="margin-bottom30">CRÉDITOS OBTENIDOS</h2>
						
                        <?php foreach($usuario->getBonificaciones() as $i => $bonificacion): ?>
						<div class="credito">
							<div class="column descripcion">
								<h3>DESCRIPCIÓN</h3>
								<span><?php echo $bonificacion->getTipoBonificacion() ?></span>
							</div>
							<div class="column usado">
								<h3>USADO</h3>
								<span><?php echo $bonificacion->getFueUtilizada() ? 'Si' : 'No' ?></span>
							</div>
							<div class="column expiracion">
								<h3>EXPIRACIÓN</h3>
								<span><?php if ($bonificacion->getVencimiento()) echo date('d/m/Y', strtotime($bonificacion->getVencimiento())); ?></span>
							</div>
							<div class="column credito">
								<h3>CRÉDITO OBTENIDO</h3>
								<span>$ <?php echo formatHelper::getInstance()->decimalNumber( $bonificacion->getValor() ); ?>.-</span>
							</div>
						</div>
						<?php endforeach; ?>
					</div>
					
				</div>
					
				
				<div class="seccion hide" id="desactivarCuenta">
					<h2 class="margin-bottom30">DESACTIVAR CUENTA</h2>
					
					<p>
					    Si desactivas tu cuenta eliminaremos tus datos de registro de nuestra web y no recibiras m&aacute;s emails con información de nuestras campa&ntilde;as.
				    </p>
					<p>
						<span>Es un proceso irreversile y por tanto no podras realizar mas compras, ni entrar en la web de Deluxebuys ni consultar información sobre tus pedidos.</span>
					</p>

					<a class="button desactivarCuenta show">Desactivar mi cuenta</a>
					<p class='leyenda hide'>¿Estás seguro/a?</p>
					<a class="button si hide" href="<?php echo url_for('@desactivar_cuenta') ?>" class="desactivarCuenta">Si</a>
					&nbsp;
					<a class="button no hide">No</a>
				</div>
			    
			</div>
    	</div>
    </div>

    <?php include_partial('global/tagsRemarketing', array('itemId1' => 'Mi Cuenta', 'pageType' => 'searchresults')); ?>