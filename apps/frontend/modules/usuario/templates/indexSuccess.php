<?php sfContext::getInstance()->getResponse()->setTitle( 'Login / Registro' ); ?>


<script> 
olvidastePass = <?php echo ($olvideClave) ? 'true' : 'false'; ?>;
</script>

<div id="registroLogin">

    <div class="login">
        <h2>Si sos miembro</h2>
        
        <form action="<?php echo url_for('@login') ?>" method="post">
        
            <?php echo $loginForm['_csrf_token']; ?>
            <?php echo $loginForm['referrer'] ?>
            
            <?php if ($sf_user->getFlash('registroFacebookError')): ?>
            <div class="alert error">
                <?php echo $sf_user->getFlash('registroFacebookError'); ?>
            </div>
            <?php endif; ?>
                    
            <div class="row">
            	<label>Tu e-mail</label>
            	<?php echo $loginForm['email']; ?>
            	<div class="error"><?php echo $loginForm['email']->getError() ?></div>
            </div>
            
            <div class="row">
            	<label>Contraseña</label>
            	<?php echo $loginForm['password']; ?>
            	<div class="error"><?php echo $loginForm['password']->getError() ?></div>
            </div>
            
            <div class="row rememberMe">
            	<?php echo $loginForm['remember_me']; ?>
            	<label>Recordar usuario en este equipo</label>
            </div>            
            
            <?php if ( $loginForm->hasGlobalErrors() ): ?>
            <div class="alert error">
                <?php echo $loginForm->renderGlobalErrors(); ?>
            </div>
            <?php endif; ?>
            
            <input type="submit" class="button" value="Ingresar" />
        
            <a class="olvidastePass">¿Olvidaste tu contraseña?</a>
        
            <div class="facebook sprite" onclick="facebookLogin.login()">
                <div class="facebookButton">
                </div>
            </div>
        
        </form>
        
    </div>
    
    <div class="registro">
        <h2>Si sos nuevo</h2>
        
        <form action="<?php echo url_for('usuario/nuevo') ?>" method="post">
        
            <?php echo $usuarioForm['_csrf_token']; ?>
            <?php echo $usuarioForm['referrer'] ?>
        
            <div class="row">
            	<label>Nombre <span class="mandatory">*</span></label>
            	<?php echo $usuarioForm['nombre']; ?>
            	<div class="error"><?php echo $usuarioForm['nombre']->getError() ?></div>
            </div>
            
            
            <div class="row">
            	<label>Apellido <span class="mandatory">*</span></label>
            	<?php echo $usuarioForm['apellido']; ?>
            	<div class="error"><?php echo $usuarioForm['apellido']->getError() ?></div>
            </div>
            
            <div class="row">
            	<label>Sexo <span class="mandatory">*</span></label>
            	<?php echo $usuarioForm['sexo']; ?>
                <div class="error"><?php echo $usuarioForm['sexo']->getError() ?></div>    
            </div>
            
            <div class="row">
            	<label>Teléfono <span class="mandatory">*</span></label>
            	<?php echo $usuarioForm['telefono']; ?>
                <div class="error"><?php echo $usuarioForm['telefono']->getError() ?></div>    
            </div>
            
            <div class="row">
            	<label>E-mail <span class="mandatory">*</span></label>
            	<?php echo $usuarioForm['email']; ?>
                <div class="error"><?php echo $usuarioForm['email']->getError() ?></div>    
            </div>
            
            <div class="row">
            	<label>Contraseña <span class="mandatory">*</span></label>
            	<?php echo $usuarioForm['password']; ?>
                <div class="error"><?php echo $usuarioForm['password']->getError() ?></div>    
            </div>
                        
            <div class="row fechaNacimiento">
            	<label>Fecha de Nac.</label>
            	<?php echo $usuarioForm['fecha_nacimiento']->render(); ?>
                <div class="error"><?php echo $usuarioForm['fecha_nacimiento']->getError() ?></div>    
            </div>
            
            <div class="row terminos">
            	<?php echo $usuarioForm['terminos']; ?>
            	<label>He leído y acepto los <a href="<?php echo url_for('tyc');?>">términos y condiciones</a></label>
            </div>
            
            <?php if ( $usuarioForm->hasGlobalErrors() ): ?>
            <div class="alert error">
                <?php echo $usuarioForm->renderGlobalErrors(); ?>
            </div>
            <?php endif; ?>
            
            <input type="submit" class="button" value="Registrarme"/>
                        
        </form>
            
    </div>
    

</div>



<div id="olvidastePass">
	<div class="title">
		<div class="sprite blackStar"></div>
		<h1>&#191;OLVIDASTE TU CONTRASE&Ntilde;A?</h1>
		<div class="sprite blackStar"></div>
	</div>
	<p>Ingresá tu email que usaste para registrarte y te enviaremos un email con tu contraseña</p>
	<form action="<?php echo url_for('olvide_contrasena_execute') ?>" method="post" class="ajax">
	    <?php echo $olvideContrasenaForm['_csrf_token'] ?>
		<label>TU-EMAIL</label>
		<?php echo $olvideContrasenaForm['email'] ?>
		<div class="error"><?php echo $olvideContrasenaForm['email']->getError() ?></div>
		<input type="submit" value="ENVIAR">
		<a class="cerrar">CERRAR</a>
	</form>
</div>

<?php include_partial('global/tagsRemarketing', array('itemId1' => 'Registro / Login', 'pageType' => 'searchresults')); ?>