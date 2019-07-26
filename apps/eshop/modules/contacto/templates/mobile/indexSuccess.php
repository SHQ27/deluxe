<?php sfContext::getInstance()->getResponse()->setTitle('Preguntas Frecuentes'); ?>

<section id="consultas" class="seccion blanco">
	<div class="banner">
		<div class="grid">
			<img src="<?php echo sfConfig::get('app_host_static'); ?>/images/eshop/<?php echo $eshop->getIdEshop(); ?>/consultas.jpg" width="100%">
		</div>
	</div>
	<div class="container">
		<div class="titulo">PREGUNTAS FRECUENTES</div>
	
		<div class="preguntas">
			<?php $i = 1; ?>
			<?php foreach ($faqCategorias as $faqCategoria): ?>
			<div class="faqCategoria">
				<div class="header titleFaqCategoria" rel="<?php echo $faqCategoria->getIdFaqCategoria(); ?>">
				    <span class="num orden"><?php echo $i ?></span><?php echo $faqCategoria->getDenominacion(); ?>
				    <span class="arrow verMas"></span>
			    </div>
				<div id="faqCategoria_<?php echo $faqCategoria->getIdFaqCategoria(); ?>" class="resp faqCategoriaContainer" <?php echo ( $categoria && $categoria == $faqCategoria->getIdFaqCategoria() ) ? 'style="display: block;"' : ''; ?>>
                    <?php $faqs = $faqCategoria->getFaq(); ?>    
                    <?php foreach ($faqs as $faq): ?>
                    <div id="pregunta_<?php echo $faq->getIdFaq(); ?>" rel="<?php echo $faq->getIdFaq(); ?>" class="pregunta">
                        <span class="bold"><?php echo $faq->getPregunta(); ?></span><br />
                    </div>
                    <div id="respuesta_<?php echo $faq->getIdFaq(); ?>" class="respuesta" <?php echo ( $pregunta && $pregunta == $faq->getIdFaq() ) ? 'style="display: block;"' : ''; ?>>
                    	<?php $texto = $faq->getTexto(ESC_RAW); ?>
                    	<?php $texto = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $texto); ?>
    					<?php echo $texto; ?>
    					<img src="<?php echo imageHelper::getInstance()->getUrl('faq_imagen', $faq); ?>"/>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
			<?php $i++; ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section id="contacto" class="seccion blanco">
	<div class="container">
		<div class="titulo">CONTACTO</div>

		<div class="texto">
			Si tenes alguna duda sobre tu compra, completa el siguiente formulario.
			<br />
			Tu consulta será respondida dentro de las 48 hs hábiles.
			<br />
			Es importante que el mail que ingreses sea el mismo con el que hayas realizado el pedido asi podemos rastrear tu información
		</div>
		
    	<form id="contactoForm" method="post" enctype="multipart/form-data">
    	
            <?php echo $form['_csrf_token']; ?>
            <?php echo $form['marca']; ?>
    			
            <div class="error">
                <?php echo ($sf_user->getFlash('mensaje')) ?>
            </div>
    				    	
			<div class="campo">
			    NOMBRE Y APELLIDO (*)
				<?php echo $form['nombre']; ?>
			</div>
			<div class="campo">
			    E-MAIL (*)
				<?php echo $form['email']; ?>
			</div>
			<div class="campo">
			    # DE PEDIDO RELACIONADO
				<?php echo $form['id_pedido']; ?>
			</div>
			<div class="campo">
				MOTIVO (*)
				<div id="motivo" class="select">
				   <div class="customSelect">
				       <?php echo $form['motivo']->render( array('title' => '&nbsp;') ); ?>
				   </div>
				</div>
			</div>
			<div class="campo">
				SUBMOTIVO (*)
				<div id="submotivo" class="select">
					<div class="customSelect">
						<?php echo $form['sub_motivo']->render( array('title' => '&nbsp;') ); ?>
					</div>
				</div>
			</div>
			<div class="campo grande">CONSULTA (*)
				<?php echo $form['mensaje']; ?>
			</div>
			
			<div class="botones">
				<input class="btEnviarConsulta" type="submit" value="ENVIAR"/>
			</div>
	   </form>
   </div>
</section>