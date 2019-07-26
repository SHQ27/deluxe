<?php sfContext::getInstance()->getResponse()->setTitle( $eshop->getFormularioTitulo() ); ?>

<section id="formulario" class="seccion blanco">
	<div class="container">
		<div class="linea"><div class="triangulos"></div></div>
		<div class="titulo MS-23"><?php echo $eshop->getFormularioTitulo(); ?></div>
		
		<div class="texto OS-11 color4 alignC lh19">
		    <?php echo nl2br( $eshop->getFormularioTexto(ESC_RAW) ); ?>
		    <span></span>
		</div>

        <div class="MS-13 rojo error">
            <?php echo ($sf_user->getFlash('mensaje')) ?>
        </div>

        <?php if ( $campos && count($campos) ): ?>
    	<form method="post">
    	
            <?php echo $form['_csrf_token']; ?>
            
            <?php $par = true; ?>

	    	<div>
            <?php foreach ($campos as $i => $row): ?>

            	<?php $class = ''; ?>
            	<?php if ( $row['es_largo']): ?>
        		<?php $par = false; ?>
        		<?php $class = 'grande'; ?>        		
        		</div><div>
            	<?php endif; ?>
            	

				<div class="MS-13 color4 campo <?php echo $class; ?> inline">
				    <?php echo $form['campo_' . $i]->renderLabel(); ?>
					<div><?php echo $form['campo_' . $i]; ?></div>
				</div>
			<?php if ( !$par && $i > 0): ?></div><div><?php endif; ?>
			<?php $par = !$par; ?>
			<?php endforeach; ?>
			</div>
			
			<div class="botones alignC">
				<input class="btOscuro MS-15 bold color7" type="submit" value="ENVIAR"/>
			</div>
            
	   </form>
	   <?php endif; ?>
	</div>
</section>