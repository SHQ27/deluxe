<?php sfContext::getInstance()->getResponse()->setTitle( 'Mi Cuenta' ); ?>

<?php if ($seccion = $sf_request->getParameter('seccion')): ?>
<script>
  $(function () { $('.miCuentaMenu a[rel="<?php echo $seccion; ?>"]').click(); });
</script>
<?php endif; ?>

<section id="mi_cuenta" class="blanco">

	<div class="container">
		<div class="linea"><div class="triangulos"></div></div>
		<div class="pantalla">
			<div class="titulo MS-23">Mi cuenta</div>
			<div class="panel inline">
				<div class="items miCuentaMenu">				
					<a rel="datosPersonales" class="item MS-13 color6 hcolor8 selected">
						DATOS PERSONALES
					</a>
					<a rel="pedidos" class="item MS-13 color6 hcolor8">
						PEDIDOS
					</a>
					<a rel="devoluciones" class="item MS-13 color6 hcolor8">
						DEVOLUCIONES
					</a>
					<a rel="consultaEnvio" class="item MS-13 color6 hcolor8">
						CONSULTA TU ENVÍO
					</a>
					<a rel="desactivarCuenta" class="item MS-13 color6 hcolor8">
						DESACTIVAR MI CUENTA
					</a>
				</div>
			</div>
			
			<div class="contenido inline">
			
                <section id="datosPersonales" class="seccion">
                
                	<?php if ( $sf_user->getFlash('datos_personales_guardado') ): ?>
                    <div class="MS-13 verde alert">El teléfono ha sido actualizado</div>
                	<?php endif; ?>
                	
                	<?php if ( $sf_user->getFlash('pass_modificada') ): ?>
                	<div class="MS-13 verde alert">La contraseña ha sido actualizada.</div>
                	<?php endif; ?>
                	
                	<?php if ( $sf_user->getFlash('email_modificado') ): ?>
                	<div class="alert">
                		<div class="MS-13 verde">La dirección de email ha sido actualizada.</div>
                		<br />
                		<p class="texto OS-11 lh16 color4">
                    		Acabamos de enviarte un e-mail de re-activación para verificar que tu email sea válido.
                    		<br />
                    		No te olvides de hacer click en el link de dicho email para volver a activar tu cuenta.
                    		<br /><br /><br />    		
                		</p>
            		</div>
                	<?php endif; ?>
                	                	
                	<?php if ( $sf_user->getFlash('direccion_modificada') ): ?>
                	<div class="MS-13 verde alert">La dirección de envío ha sido actualizada.</div>
                	<?php endif; ?>
                	
                
                	<div class="texto OS-11 color4 lh16">Desde aquí podes modificar tu información personal. Cambiar tu email, contraseña, modificar tu dirección de envío y actualizar tu número teléfonico. <span class="bold">Estos cambios no se aplicaran a pedidos realizados con anterioridad.</span></div>
                
                    <form method="post" action="<?php echo url_for('@mi_cuenta') ?>">
                        <?php echo $datosPersonalesForm['_csrf_token']; ?>
                    
                    	<div class="campo MS-13 color4">
                    	    MODIFICAR TELÉFONO
                    	    <?php $errorClass = ( $datosPersonalesForm['telefono']->getError() ) ? 'error' : ''; ?>
                            <?php echo $datosPersonalesForm['telefono']->render( array('placeholder' => "Ingrese su número telefónico...", 'class' => 'OS-12 color4 ' . $errorClass )); ?>
                    	</div>
                    	<input type="submit" class="btOscuro MS-15 bold color7" value="GUARDAR" />
                	</form>
                
                	<form method="post" action="<?php echo url_for('@mi_cuenta') ?>">
                	   <?php echo $modificarPassForm['_csrf_token']; ?>                	
                    	<div class="campo MS-13 color4">
                    	    MODIFICAR CONTRASEÑA                    	    
                			<?php $errorClass = ( $modificarPassForm['old']->getError() ) ? 'error' : ''; ?>
                			<?php $placeHolder = ( $modificarPassForm['old']->getError() ) ? $modificarPassForm['old']->getError() : 'Contraseña Actual' ?>
                			<?php echo $modificarPassForm['old']->render( array('placeholder' => $placeHolder, 'class' => 'OS-12 color4 ' . $errorClass )); ?>
                			<?php $errorClass = ( $modificarPassForm['new']->getError() ) ? 'error' : ''; ?>
                			<?php $placeHolder = ( $modificarPassForm['new']->getError() ) ? $modificarPassForm['new']->getError() : 'Contraseña Nueva' ?>
                			<?php echo $modificarPassForm['new']->render( array('placeholder' => $placeHolder, 'class' => 'OS-12 color4 ' . $errorClass )); ?>
                    	</div>
                    	                	
                    	<?php if ( $modificarPassForm->hasGlobalErrors() ): ?>
                    	<div class="MS-13 rojo alert"><?php echo $modificarPassForm->renderGlobalErrors(); ?></div>
                    	<?php endif; ?>
                    	
                    	<input type="submit" class="btOscuro MS-15 bold color7" value="GUARDAR" />
                	</form>
                
                    <form method="post" action="<?php echo url_for('@mi_cuenta') ?>">
                        <?php echo $modificarEmailForm['_csrf_token']; ?>
                    	

                    	<div class="campo MS-13 color4">MODIFICAR DIRECCIÓN DE EMAIL
                			<?php $errorClass = ( $modificarEmailForm['email']->getError() ) ? 'error' : ''; ?>
                			<?php $placeHolder = ( $modificarEmailForm['email']->getError() ) ? $modificarEmailForm['email']->getError() : 'Ingrese su nuevo email...' ?>
                			<?php echo $modificarEmailForm['email']->render( array('placeholder' => $placeHolder, 'class' => 'OS-12 color4 ' . $errorClass )); ?>                    		
                    	</div>
                    	
                    	<?php if ( $modificarEmailForm->hasGlobalErrors() ): ?>
                    	<div class="MS-13 rojo alert"><?php echo $modificarEmailForm->renderGlobalErrors(); ?></div>
                    	<?php endif; ?>
                    	
                    	<input type="submit" class="btOscuro MS-15 bold color7" value="GUARDAR" />
                	</form>
                
                
                    <div class="direccionEntregaUsuario">
                                
                    	<form method="post" action="<?php echo url_for('@mi_cuenta') ?>">
                    	   <?php echo $direccionEnvioForm['_csrf_token']; ?>
                    	
                    		<div class="campo MS-13 color4">
                    		    DIRECCIÓN DE ENTREGA
                    			<div class="sinCargar OS-11 italic color4">
                    			    ¿Aún no tienes una dirección de entrega cargada?
                    			    
                    			    <?php if ( !$direccionEnvioForm->hasErrors() ): ?>
                                    <a id="btEditarDir" class="OS-11 bold color8 button">EDITAR</a>
                                    <?php endif;?>
                    			</div>
                    		</div>
                    		
                            <div id="direccionEntrega" class="<?php echo ( $direccionEnvioForm->hasErrors() ) ? 'show' : 'hide' ?>">
                    			<div>
                    				<div class="campo2 medio MS-13 color4 inline">
                    				    CALLE
                            			<?php $errorClass = ( $direccionEnvioForm['calle']->getError() ) ? 'error' : ''; ?>
                            			<?php $placeHolder = ( $direccionEnvioForm['calle']->getError() ) ? $direccionEnvioForm['calle']->getError() : '' ?>
                            			<?php echo $direccionEnvioForm['calle']->render( array('placeholder' => $placeHolder, 'class' => 'OS-12 color4 ' . $errorClass )); ?>
                    				</div>
                    				<div class="campo2 chico MS-13 color4 inline">
                    				    NÚMERO
                            			<?php $errorClass = ( $direccionEnvioForm['numero']->getError() ) ? 'error' : ''; ?>
                            			<?php $placeHolder = ( $direccionEnvioForm['numero']->getError() ) ? $direccionEnvioForm['numero']->getError() : '' ?>
                            			<?php echo $direccionEnvioForm['numero']->render( array('placeholder' => $placeHolder, 'class' => 'OS-12 color4 ' . $errorClass )); ?>
                    				</div>
                    			</div>
                    			<div>
                    				<div class="campo2 medio MS-13 color4 inline">
                    				    PISO
                            			<?php $errorClass = ( $direccionEnvioForm['piso']->getError() ) ? 'error' : ''; ?>
                            			<?php $placeHolder = ( $direccionEnvioForm['piso']->getError() ) ? $direccionEnvioForm['piso']->getError() : '' ?>
                            			<?php echo $direccionEnvioForm['piso']->render( array('placeholder' => $placeHolder, 'class' => 'OS-12 color4 ' . $errorClass )); ?>
                    				</div>
                    				<div class="campo2 chico MS-13 color4 inline">
                    				    DEPARTAMENTO
                            			<?php $errorClass = ( $direccionEnvioForm['depto']->getError() ) ? 'error' : ''; ?>
                            			<?php $placeHolder = ( $direccionEnvioForm['depto']->getError() ) ? $direccionEnvioForm['depto']->getError() : '' ?>
                            			<?php echo $direccionEnvioForm['depto']->render( array('placeholder' => $placeHolder, 'class' => 'OS-12 color4 ' . $errorClass )); ?>
                    				</div>
                    			</div>
                    			<div class="campo2 OS-11 color2 provincia">
                    			     <div class="MS-13 color4">PROVINCIA</div>
                    			     <div class="customSelect"><?php echo $direccionEnvioForm['id_provincia'] ?></div>
                    			</div>
                    			<div class="campo2 MS-13 color4">
                    			    LOCALIDAD
                        			<?php $errorClass = ( $direccionEnvioForm['localidad']->getError() ) ? 'error' : ''; ?>
                        			<?php $placeHolder = ( $direccionEnvioForm['localidad']->getError() ) ? $direccionEnvioForm['localidad']->getError() : '' ?>
                        			<?php echo $direccionEnvioForm['localidad']->render( array('placeholder' => $placeHolder, 'class' => 'OS-12 color4 ' . $errorClass )); ?>
                    			</div>
                    			<div class="campo2 MS-13 color4">
                    			    CÓDIGO POSTAL
                        			<?php $errorClass = ( $direccionEnvioForm['codigo_postal']->getError() ) ? 'error' : ''; ?>
                        			<?php $placeHolder = ( $direccionEnvioForm['codigo_postal']->getError() ) ? $direccionEnvioForm['codigo_postal']->getError() : '' ?>
                        			<?php echo $direccionEnvioForm['codigo_postal']->render( array('placeholder' => $placeHolder, 'class' => 'OS-12 color4 ' . $errorClass )); ?>
                    			</div>
                    			<input type="submit" class="btOscuro MS-15 bold color7" value="GUARDAR" />
                    		</div>
                    		
                    	</form>
                	</div>
                	
                </section>
                
                
                
                
                <section id="pedidos" class="seccion hide">
                
                    <div class="subtitulo MS-13">ESTE ES EL RESUMEN DE TUS ÚLTIMOS PEDIDOS</div>
                	
                	<?php if (count($ultimosPedidos)): ?>    
                	<div class="pedidos">
                	
                	    <?php foreach ($ultimosPedidos as $i => $pedido): ?>
                		<div class="pedido">
                			<div class="c1 c inline color4 lh19">
                				<span class="MS-13 inblock">Nº</span>
                				<?php echo $pedido->getIdPedido() ?>                				
                			</div>
                			<div class="c2 c inline color4 lh19">
                				<span class="MS-13 inblock">FECHA</span>
                				<?php echo date('d/m/Y H:i', strtotime($pedido->getFechaAlta())) ?>
                			</div>
                			<div class="c3 c inline color4 lh19">
                				<span class="MS-13 inblock">ESTADO</span>
                				<?php echo $pedido->getEstado() ?>
                			</div>
                			<div class="c4 c inline color4 lh19">
                				<span class="MS-13 inblock">TOTAL COMPRA</span>
                				$ <?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoTotal() ); ?>
                			</div>
                			<div class="c5 c inline color8 lh19">
                			
                                <div><a href="<?php echo url_for('mi_cuenta_detalle_pedido', $pedido) ?>" class="MS-13 color8 verPedidos">VER</a></div>
                                
                                <?php $tracking = $pedido->getTracking(); ?>
                                <?php if ( $tracking && count($tracking) ): ?>
                                <div><a href="<?php echo url_for('mi_cuenta_detalle_envio', $pedido) ?>" class="MS-13 color8 ocaTracking">TRACKING</a></div>
                                <?php endif; ?>
                                
                                <?php if (!$pedido->getFechaPago() && !$pedido->getFechaBaja()): ?>
                                <div><a onclick="if (confirm('Estas seguro/a?')) { window.location.href='<?php echo url_for('mi_cuenta_baja_pedido', array( 'idPedido' => $pedido->getIdPedido() ) ); ?>' };return false;" class="MS-13 color8">DAR DE BAJA</a></div>
                                <?php endif; ?>
                			</div>
                		</div>
                		<?php endforeach; ?>
                	</div>
                	<?php else: ?>
                	<div class="texto OS-11 color4 lh16">
                	    Aún no has realizado ningún pedido.
                	</div>
                	<?php endif; ?>
                	<div id="verPedidos"></div>
                	<div id="ocaTracking"></div>
                </section>
                
                
                
                
				<section id="devoluciones" class="seccion hide">
				<?php include_component('miCuenta', 'devoluciones')?>
				</section>
				
				
				
				
    			<section id="consultaEnvio" class="seccion hide">
    		    
                    	<div class="MS-13 subtitulo">CONSULTA TU ENVÍO</div>
                    
                    	<div class="OS-11 color4 texto">Ingresá tu número de pedido y verifica la fecha de envío y estado del mismo.</div>
                    	
                    	<form>
                    		<div class="campo MS-13 color4">
                    		    NÚMERO DE PEDIDO
                    			<input id="verificar_id_pedido" type="text" placeholder="Ingrese su número de pedido..." class="OS-12 color4">
                    		</div>
                    		<input id="verificarEnvio" type="submit" class="btOscuro MS-15 bold color7" value="CONSULTAR" />
                    	</form>
                    	<div id="respuesta_consultaEnvio"></div>
    			</section>
    			
    			
                <section id="desactivarCuenta" class="seccion hide">
                
                	<div class="MS-13 subtitulo">DESACTIVAR CUENTA</div>
                
                	<div class="OS-11 color4 texto lh16">
                		Si desactivas tu cuenta eliminaremos tus datos de registro de nuestra web y no recibiras más emails
                		<br /> 
                		con información de nuestras campañas.
                		<br />
                	</div>
                	<div class="OS-11 color4 bold texto lh16">
                	    Es un proceso irreversile y por tanto no podrás realizar mas compras, ni consultar información
                	    <br /> 
                		sobre tus pedidos.
                	</div>
                	
                	<div class="botones">
                		<div class="btOscuro MS-15 bold color7 desactivarCuenta">DESACTIVAR MI CUENTA</div>
                		<div class="MS-13 color4 leyenda hide">¿ESTÁS SEGURO/A?</div>
                		<a class="btOscuro MS-15 bold color7 button si hide" href="<?php echo url_for('desactivar_cuenta') ?>">SI</a>
                		<div class="btOscuro MS-15 bold color7 button no hide">NO</div>
                	</div>
                	
                </section>
    			
			</div>
		</div>
	</div>
</section>