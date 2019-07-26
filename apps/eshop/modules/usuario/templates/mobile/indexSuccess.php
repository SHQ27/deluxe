<?php
	$displayRegistro = false;
	$displayLogin = false;
	$displayOlvide = false;
	switch($view) {
		case "registro":
			$title = "Registro";
			$displayRegistro = true;
			break;
		case "login":
			$title = "Login";
			$displayLogin = true;
			break;
		case "olvide":
			$title = "Olvidé mi contraseña";
			$displayOlvide = true;
			break;
	}
?>

<script>
olvidastePass = <?php echo ($olvideClave) ? 'true' : 'false'; ?>;
</script>

<?php sfContext::getInstance()->getResponse()->setTitle( $title ); ?>

<?php if($displayRegistro || $displayLogin): ?>
<section id="ingresar" class="seccion blanco">
	<div class="container">
		<div class="pantalla">
			<?php if($displayLogin): ?>
			<div id="soy_miembro" class="inline">
				<form action="<?php echo url_for('@login') ?>" method="post">
				
		            <?php echo $loginForm['_csrf_token']; ?>
                    <?php echo $loginForm['referrer'] ?>
                                        
					<div class="titulo"><?php echo $eshop->getTextoSoyMiembro(); ?></div>
					<div class="campo">E-MAIL</div>
					<?php $classError = ( $loginForm['email']->hasError() ) ? 'error' : ''; ?>
					<?php $placeHolder = ( $loginForm['email']->hasError() ) ? $loginForm['email']->getError() : 'Ingresa tu correo' ?>
					<?php echo $loginForm['email']->render(array('placeholder' => $placeHolder, 'class' => $classError )); ?>
					<div class="campo">CONTRASEÑA</div>
					<?php $classError = ( $loginForm['password']->hasError() ) ? 'error' : ''; ?>
					<?php $placeHolder = ( $loginForm['password']->hasError() ) ? $loginForm['password']->getError() : '' ?>
					<?php echo $loginForm['password']->render(array('placeholder' => $placeHolder, 'class' => $classError )); ?>
					<div class="row">
						<div class="col21">
							<div class="contRecordar">
								<?php echo $loginForm['remember_me']; ?>
								<label for="login_remember_me">Recordarme</label>
							</div>
						</div>
						<div class="col22">
							<div class="olvideCont">
								<a href="<?php echo url_for('usuario_olvide') ?>">¿Olvidaste tu contraseña?</a>
							</div>
						</div>
					</div>
					
                    <?php if ($sf_user->getFlash('registroFacebookError')): ?>
			        <div class="errorTexto">
                        <?php echo $sf_user->getFlash('registroFacebookError'); ?>
			        </div>
                    <?php endif; ?>
                    
                    <?php if ( $loginForm->hasGlobalErrors() ): ?>
			        <div class="errorTexto">
                        <?php echo $loginForm->renderGlobalErrors(); ?>
			        </div>
                    <?php endif; ?>
					
					<div class="botones">
						<input type="submit" class="btIngresar" value="INGRESAR" />
					</div>

					<div class="optRegistro">
						¿Aún no tenés cuenta?<br /><br />

						<div class="botones">
							<a class="btRegistro" href="<?php echo url_for('usuario_registro') ?>">REGISTRARME</a>
						</div>
					</div>
				</form>
			</div>
			<?php endif; ?>
			<?php if($displayRegistro): ?>
			<div id="soy_nuevo" class="inline">
				<form action="<?php echo url_for('usuario_nuevo') ?>" method="post">
				
                    <?php echo $usuarioForm['_csrf_token']; ?>
                    <?php echo $usuarioForm['referrer'] ?>
                    				                    				
					<div class="titulo"><?php echo $eshop->getTextoSoyNuevo(); ?></div>
					<div class="rincon"></div>
					<div class="campo">NOMBRE (*)</div>
					<?php $classError = ( $usuarioForm['nombre']->hasError() ) ? 'error' : ''; ?>
					<?php $placeHolder = ( $usuarioForm['nombre']->hasError() ) ? $usuarioForm['nombre']->getError() : '' ?>
					<?php echo $usuarioForm['nombre']->render(array('placeholder' => $placeHolder, 'class' => $classError )); ?>
					<div class="campo">APELLIDO (*)</div>
					<?php $classError = ( $usuarioForm['apellido']->hasError() ) ? 'error' : ''; ?>
					<?php $placeHolder = ( $usuarioForm['apellido']->hasError() ) ? $usuarioForm['apellido']->getError() : '' ?>
					<?php echo $usuarioForm['apellido']->render(array('placeholder' => $placeHolder, 'class' => $classError )); ?>
					<div class="campo">
						<span class="sexoTitle">SEXO (*)</span>
						<?php echo $usuarioForm['sexo']; ?>
					</div>
					<div class="campo">TELÉFONO (*)</div>
					<?php $classError = ( $usuarioForm['telefono']->hasError() ) ? 'error' : ''; ?>
					<?php $placeHolder = ( $usuarioForm['telefono']->hasError() ) ? $usuarioForm['telefono']->getError() : '' ?>
					<?php echo $usuarioForm['telefono']->render(array('placeholder' => $placeHolder, 'class' => $classError )); ?>
					<div class="campo">E-MAIL (*)</div>
					<?php $classError = ( $usuarioForm['email']->hasError() ) ? 'error' : ''; ?>
					<?php $placeHolder = ( $usuarioForm['email']->hasError() ) ? $usuarioForm['email']->getError() : 'Ingresa tu correo' ?>
					<?php echo $usuarioForm['email']->render(array('placeholder' => $placeHolder, 'class' => $classError )); ?>
					<div class="campo">CONTRASEÑA (*)</div>
					<?php $classError = ( $usuarioForm['password']->hasError() ) ? 'error' : ''; ?>
					<?php $placeHolder = ( $usuarioForm['password']->hasError() ) ? $usuarioForm['password']->getError() : '' ?>
					<?php echo $usuarioForm['password']->render(array('placeholder' => $placeHolder, 'class' => $classError )); ?>
					<div class="campo">FECHA DE NACIMIENTO</div>
					<div class="fechaNacimiento">
					<?php echo $usuarioForm['fecha_nacimiento']->render(); ?>
					</div>
					
					<div class="terminos">
						<?php echo $usuarioForm['terminos']; ?>
						<label for="usuario_terminos">
						  <span>He leído y acepto los</span> <a class="bold" href="<?php echo url_for('tyc'); ?>">términos y condiciones</a>
						</label>
					</div>
					
                    <?php if ( $usuarioForm->hasGlobalErrors() ): ?>
			        <div class="errorTexto">
                        <?php echo $usuarioForm->renderGlobalErrors(); ?>
			        </div>
                    <?php endif; ?>
					
					<div class="botones">
						<input type="submit" class="btRegistrarme" value="Registrarme"/>
					</div>
					<div class="rincon_inf"></div>
				</form>
			</div>
			<?php endif; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php if($displayOlvide): ?>
	<div id="olvidastePass">
	    <div class="container">
	    	<div class="titulo MS-24 alignC lh19">¿OLVIDASTE TU CONTRASEÑA?</div>
	    	<div class="linea"><div class="triangulos"></div></div>
	    	
	    	<div class="detalle">
	    		<div id="op_p1">
	    			<div class="OS-12 alignC color4 lh19">
	    			 Ingresá el correo que utilizaste para registrarte, y
	    			 <br>
	    			 te enviaremos un email con tu contraseña.
	    			</div>
	    			
	    			<form action="<?php echo url_for('olvide_contrasena_execute') ?>" method="post" class="ajax">
	    			    <?php echo $olvideContrasenaForm['_csrf_token'] ?>
	    			    
						<?php $classError = ( $olvideContrasenaForm['email']->hasError() ) ? 'error' : ''; ?>
						<?php $placeHolder = ( $olvideContrasenaForm['email']->hasError() ) ? $olvideContrasenaForm['email']->getError() : 'Ingresa tu correo...' ?>
						<?php echo $olvideContrasenaForm['email']->render(array('placeholder' => $placeHolder, 'class' => $classError )); ?>
	    			
	        			<div class="alignC">
	        			     <input type="submit" class="btOscuro MS-15 bold color7" value="ENVIAR">
	        			</div>
	    			</form>
	    		</div>
	    	</div>
	    </div>
	</div>
<?php endif; ?>