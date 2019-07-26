<?php sfContext::getInstance()->getResponse()->setTitle( $eshop->getFormularioTitulo() ); ?>

<section id="formulario" class="seccion blanco">

	<div class="container">
		<div class="titulo"><?php echo $eshop->getFormularioTitulo(); ?></div>

		<div class="texto">
			<?php echo nl2br( $eshop->getFormularioTexto(ESC_RAW) ); ?>
		</div>
		
		<?php if ( $campos && count($campos) ): ?>
    	<form method="post">
    	
            <?php echo $form['_csrf_token']; ?>
    			
            <div class="error">
                <?php echo ($sf_user->getFlash('mensaje')) ?>
            </div>
    				    	
            <?php foreach ($campos as $i => $row): ?>
        		<?php $class = ( $row['es_largo'] ) ? 'grande' : ''; ?>
				<div class="campo <?php echo $class; ?>">
				    <?php echo $form['campo_' . $i]->renderLabel(); ?>
					<?php echo $form['campo_' . $i]; ?>
				</div>
			<?php endforeach; ?>

			<div class="botones">
				<input class="btEnviarConsulta" type="submit" value="ENVIAR"/>
			</div>
	   </form>
	   <?php endif; ?>
   </div>
</section>