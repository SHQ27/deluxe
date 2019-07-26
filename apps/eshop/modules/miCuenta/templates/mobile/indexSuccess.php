<?php sfContext::getInstance()->getResponse()->setTitle( 'Mi Cuenta' ); ?>

<?php if ($seccion = $sf_request->getParameter('seccion')): ?>
<script>
  $(function () { $('.miCuentaMenu a[rel="<?php echo $seccion; ?>"]').click(); });
</script>
<?php endif; ?>

<section id="mi_cuenta" class="blanco">
	<div class="titulo">MI CUENTA</div>
	<div class="panel">
		<div class="items miCuentaMenu">
            <ul>
                <li>
                    <a rel="datosPersonales" class="item selected blockLink" href="#contenidoMiCuenta">
                        <span>DATOS PERSONALES</span>
                        <span class="arrow"></span>
                    </a>
                </li>
                <li>
                    <a rel="pedidos" class="item blockLink" href="#contenidoMiCuenta">
                        <span>PEDIDOS</span>
                        <span class="arrow"></span>
                    </a>
                </li>
                <li>
                    <a rel="devoluciones" class="item blockLink" href="#contenidoMiCuenta">
                        <span>DEVOLUCIONES</span>
                        <span class="arrow"></span>
                    </a>
                </li>
                <li>
                    <a rel="consultaEnvio" class="item blockLink" href="#contenidoMiCuenta">
                        <span>CONSULTA TU ENVÍO</span>
                        <span class="arrow"></span>
                    </a>
                </li>
                <li>
                    <a rel="desactivarCuenta" class="item blockLink" href="#contenidoMiCuenta">
                        <span>DESACTIVAR MI CUENTA</span>
                        <span class="arrow"></span>
                    </a>
                </li>
            </ul>
		</div>
	</div>
	
	<div id="contenidoMiCuenta" class="contenido inline">
	
        <section id="datosPersonales" class="seccion">
        
        	<?php if ( $sf_user->getFlash('datos_personales_guardado') ): ?>
            <div class="alert">El teléfono ha sido actualizado</div>
        	<?php endif; ?>
        	
        	<?php if ( $sf_user->getFlash('pass_modificada') ): ?>
        	<div class="alert">La contraseña ha sido actualizada.</div>
        	<?php endif; ?>
        	
        	<?php if ( $sf_user->getFlash('email_modificado') ): ?>
        	<div class="alert">
        		<div>La dirección de email ha sido actualizada.</div>
        		<br />
        		<p class="texto">
            		Acabamos de enviarte un e-mail de re-activación para verificar que tu email sea válido.
            		<br />
            		No te olvides de hacer click en el link de dicho email para volver a activar tu cuenta.
        		</p>
    		</div>
        	<?php endif; ?>
        	                	
        	<?php if ( $sf_user->getFlash('direccion_modificada') ): ?>
        	<div class="alert">La dirección de envío ha sido actualizada.</div>
        	<?php endif; ?>
        
        	<div class="texto">Desde aquí podes modificar tu información personal. Cambiar tu email, contraseña, modificar tu dirección de envío y actualizar tu número teléfonico. <span class="strong">Estos cambios no se aplicaran a pedidos realizados con anterioridad.</span></div>
        
            <form method="post" action="<?php echo url_for('@mi_cuenta') ?>">
                <?php echo $datosPersonalesForm['_csrf_token']; ?>
            
            	<div class="campo">
            	    MODIFICAR TELÉFONO
            	    <?php $errorClass = ( $datosPersonalesForm['telefono']->getError() ) ? 'error' : ''; ?>
                    <?php echo $datosPersonalesForm['telefono']->render( array('placeholder' => "Ingrese su número telefónico...", 'class' => $errorClass )); ?>
            	</div>

                <div class="buttonsContainer">
            	   <input type="submit" value="GUARDAR" />
                </div>
        	</form>
        
        	<form method="post" action="<?php echo url_for('@mi_cuenta') ?>">
        	   <?php echo $modificarPassForm['_csrf_token']; ?>                	
            	<div class="campo">
            	    MODIFICAR CONTRASEÑA
        			<?php $errorClass = ( $modificarPassForm['old']->getError() ) ? 'error' : ''; ?>
        			<?php $placeHolder = ( $modificarPassForm['old']->getError() ) ? $modificarPassForm['old']->getError() : 'Contraseña Actual' ?>
        			<?php echo $modificarPassForm['old']->render( array('placeholder' => $placeHolder, 'class' => $errorClass )); ?>
            	</div>
                <div class="campo">
                    <?php $errorClass = ( $modificarPassForm['new']->getError() ) ? 'error' : ''; ?>
                    <?php $placeHolder = ( $modificarPassForm['new']->getError() ) ? $modificarPassForm['new']->getError() : 'Contraseña Nueva' ?>
                    <?php echo $modificarPassForm['new']->render( array('placeholder' => $placeHolder, 'class' => $errorClass )); ?>
                </div>
            	                	
            	<?php if ( $modificarPassForm->hasGlobalErrors() ): ?>
            	<div class="MS-13 rojo alert"><?php echo $modificarPassForm->renderGlobalErrors(); ?></div>
            	<?php endif; ?>
            	
                <div class="buttonsContainer">
                	<input type="submit" value="GUARDAR" />
                </div>
        	</form>
        
            <form method="post" action="<?php echo url_for('@mi_cuenta') ?>">
                <?php echo $modificarEmailForm['_csrf_token']; ?>
            	
            	<div class="campo">MODIFICAR DIRECCIÓN DE EMAIL
        			<?php $errorClass = ( $modificarEmailForm['email']->getError() ) ? 'error' : ''; ?>
        			<?php $placeHolder = ( $modificarEmailForm['email']->getError() ) ? $modificarEmailForm['email']->getError() : 'Ingrese su nuevo email...' ?>
        			<?php echo $modificarEmailForm['email']->render( array('placeholder' => $placeHolder, 'class' => $errorClass )); ?>                    		
            	</div>
            	
            	<?php if ( $modificarEmailForm->hasGlobalErrors() ): ?>
            	<div class="MS-13 rojo alert"><?php echo $modificarEmailForm->renderGlobalErrors(); ?></div>
            	<?php endif; ?>
            	
                <div class="buttonsContainer">
                	<input type="submit" value="GUARDAR" />
                </div>
        	</form>
        
        
            <div class="direccionEntregaUsuario">
                        
            	<form method="post" action="<?php echo url_for('@mi_cuenta') ?>">
            	   <?php echo $direccionEnvioForm['_csrf_token']; ?>
            	
            		<div class="campo">
            		    DIRECCIÓN DE ENTREGA
            			<div class="sinCargar">
            			    ¿Aún no tienes una dirección de entrega cargada?
            			    
            			    <?php if ( !$direccionEnvioForm->hasErrors() ): ?>
                            <a id="btEditarDir" class="button">EDITAR</a>
                            <?php endif;?>
            			</div>
            		</div>
            		
                    <div id="direccionEntrega" class="<?php echo ( $direccionEnvioForm->hasErrors() ) ? 'show' : 'hide' ?>">
            			<div class="row">
                            <div class="col60 calle">
                				<div class="campo">
                				    CALLE
                        			<?php $errorClass = ( $direccionEnvioForm['calle']->getError() ) ? 'error' : ''; ?>
                        			<?php $placeHolder = ( $direccionEnvioForm['calle']->getError() ) ? $direccionEnvioForm['calle']->getError() : '' ?>
                        			<?php echo $direccionEnvioForm['calle']->render( array('placeholder' => $placeHolder, 'class' => $errorClass )); ?>
                				</div>
                            </div>
                            <div class="col35">
                				<div class="campo">
                				    NÚMERO
                        			<?php $errorClass = ( $direccionEnvioForm['numero']->getError() ) ? 'error' : ''; ?>
                        			<?php $placeHolder = ( $direccionEnvioForm['numero']->getError() ) ? $direccionEnvioForm['numero']->getError() : '' ?>
                        			<?php echo $direccionEnvioForm['numero']->render( array('placeholder' => $placeHolder, 'class' => $errorClass )); ?>
                				</div>
                            </div>
            			</div>
            			<div class="row">
                            <div class="col60 piso">
                				<div class="campo">
                				    PISO
                        			<?php $errorClass = ( $direccionEnvioForm['piso']->getError() ) ? 'error' : ''; ?>
                        			<?php $placeHolder = ( $direccionEnvioForm['piso']->getError() ) ? $direccionEnvioForm['piso']->getError() : '' ?>
                        			<?php echo $direccionEnvioForm['piso']->render( array('placeholder' => $placeHolder, 'class' => $errorClass )); ?>
                				</div>
                            </div>
                            <div class="col35">
                				<div class="campo">
                				    DEPARTAMENTO
                        			<?php $errorClass = ( $direccionEnvioForm['depto']->getError() ) ? 'error' : ''; ?>
                        			<?php $placeHolder = ( $direccionEnvioForm['depto']->getError() ) ? $direccionEnvioForm['depto']->getError() : '' ?>
                        			<?php echo $direccionEnvioForm['depto']->render( array('placeholder' => $placeHolder, 'class' => $errorClass )); ?>
                				</div>
                            </div>
            			</div>
            			<div class="campo provincia">
            			     PROVINCIA
            			     <div class="customSelect"><?php echo $direccionEnvioForm['id_provincia'] ?></div>
            			</div>
            			<div class="campo">
            			    LOCALIDAD
                			<?php $errorClass = ( $direccionEnvioForm['localidad']->getError() ) ? 'error' : ''; ?>
                			<?php $placeHolder = ( $direccionEnvioForm['localidad']->getError() ) ? $direccionEnvioForm['localidad']->getError() : '' ?>
                			<?php echo $direccionEnvioForm['localidad']->render( array('placeholder' => $placeHolder, 'class' => $errorClass )); ?>
            			</div>
            			<div class="campo">
            			    CÓDIGO POSTAL
                			<?php $errorClass = ( $direccionEnvioForm['codigo_postal']->getError() ) ? 'error' : ''; ?>
                			<?php $placeHolder = ( $direccionEnvioForm['codigo_postal']->getError() ) ? $direccionEnvioForm['codigo_postal']->getError() : '' ?>
                			<?php echo $direccionEnvioForm['codigo_postal']->render( array('placeholder' => $placeHolder, 'class' => $errorClass )); ?>
            			</div>
            			
                        <div class="buttonsContainer">
                            <input type="submit" value="GUARDAR" />
                        </div>
            		</div>
            		
            	</form>
        	</div>
        	
        </section>

        <section id="pedidos" class="seccion hide">
        
            <div class="subtitulo">ESTE ES EL RESUMEN DE TUS ÚLTIMOS PEDIDOS</div>
        	
        	<?php if (count($ultimosPedidos)): ?>    
        	<div class="pedidos">
        	
        	    <?php foreach ($ultimosPedidos as $i => $pedido): ?>
                <div class="row pedido">
                    <div class="col65">
            			<div class="dato">
            				<span class="label">Nº</span>
            				<?php echo $pedido->getIdPedido() ?>                				
            			</div>
            			<div class="dato">
            				<span class="label">FECHA</span>
            				<?php echo date('d/m/Y H:i', strtotime($pedido->getFechaAlta())) ?>
            			</div>
            			<div class="dato">
            				<span class="label">ESTADO</span>
            				<?php echo $pedido->getEstado() ?>
            			</div>
            			<div class="dato">
            				<span class="label">TOTAL COMPRA</span>
            				$ <?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoTotal() ); ?>
            			</div>
                    </div>
                    <div class="col35">
            			<div class="acciones">
            			
                            <div><a href="<?php echo url_for('mi_cuenta_detalle_pedido', $pedido) ?>" class="verPedidos">VER</a></div>
                            
                            <?php $tracking = $pedido->getTracking(); ?>
                            <?php if ( $tracking && count($tracking) ): ?>
                            <div><a href="<?php echo url_for('mi_cuenta_detalle_envio', $pedido) ?>" class="ocaTracking">TRACKING</a></div>
                            <?php endif; ?>
                            
                            <?php if (!$pedido->getFechaPago() && !$pedido->getFechaBaja()): ?>
                            <div><a onclick="if (confirm('Estas seguro/a?')) { window.location.href='<?php echo url_for('mi_cuenta_baja_pedido', array( 'idPedido' => $pedido->getIdPedido() ) ); ?>' };return false;">DAR DE BAJA</a></div>
                            <?php endif; ?>
            			</div>
                    </div>
                </div>
        		<?php endforeach; ?>
        	</div>
        	<?php else: ?>
        	<div class="texto">
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
	    
        	<div class="texto">Ingresá tu número de pedido y verifica la fecha de envío y estado del mismo.</div>
        	
        	<form>
        		<div class="campo">
        		    NÚMERO DE PEDIDO
        			<input id="verificar_id_pedido" type="text" placeholder="Ingrese su número de pedido...">
        		</div>
                <div class="buttonsContainer">
            		<input id="verificarEnvio" type="submit" value="CONSULTAR" />
                </div>
        	</form>

        	<div id="respuesta_consultaEnvio"></div>

		</section>
		
		
        <section id="desactivarCuenta" class="seccion hide">
        
        	<div class="texto">
        		Si desactivas tu cuenta eliminaremos tus datos de registro de nuestra web y no recibiras más emails
        		con información de nuestras campañas.
        		<br />
        	</div>
        	<div class="bold texto">
        	    Es un proceso irreversile y por tanto no podrás realizar mas compras, ni consultar información
        		sobre tus pedidos.
        	</div>
        	
            <div class="buttonsContainer">
        		<div class="desactivarCuenta">DESACTIVAR MI CUENTA</div>
        		<div class="leyenda hide">¿ESTÁS SEGURO/A?</div>
        		<a class="button si hide" href="<?php echo url_for('desactivar_cuenta') ?>">SI</a>
        		<div class="button no hide">NO</div>
        	</div>
        	
        </section>
		
	</div>
</section>