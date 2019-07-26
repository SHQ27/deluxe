<?php sfContext::getInstance()->getResponse()->setTitle('Preguntas Frecuentes'); ?>

<div id="consultas">
	<h1>PREGUNTAS FRECUENTES</h1>
	
    <?php foreach ($faqCategorias as $faqCategoria): ?>
        <h3 rel="<?php echo $faqCategoria->getIdFaqCategoria(); ?>" class="titleFaqCategoria">
            <span class="sprite icon"></span>
            <span class="texto"><?php echo $faqCategoria->getDenominacion(); ?></span>
            <span class="verMas">VER MÁS<span>
        </h3>
        
        <div id="faqCategoria_<?php echo $faqCategoria->getIdFaqCategoria(); ?>" class="faqCategoria <?php echo ( $categoria && $categoria == $faqCategoria->getIdFaqCategoria() ) ? 'show' : ''; ?>">
        <?php $faqs = $faqCategoria->getFaq(); ?>    
        <?php foreach ($faqs as $faq): ?>
        <h4 id="pregunta_<?php echo $faq->getIdFaq(); ?>" rel="<?php echo $faq->getIdFaq(); ?>" class="pregunta">
            <span class="sprite icon close"></span>
            <?php echo $faq->getPregunta(); ?>
        </h4>
        <div id="respuesta_<?php echo $faq->getIdFaq(); ?>" class="respuesta <?php echo ( $pregunta && $pregunta == $faq->getIdFaq() ) ? 'show' : ''; ?>">
    		<?php echo $faq->getTexto(ESC_RAW); ?>
    	    <img src="<?php echo imageHelper::getInstance()->getUrl('faq_imagen', $faq); ?>"/>
        </div>
        <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
    
    <?php if ( !isset($error) || !$error ): ?>
	<div class="form">
	
    	<p class="dudas">Si todavía tenes dudas o consultas, hace click</p>
    	<a class="buttonContacto">Contactar con atención al cliente</a>
    	
    	<form id="contactoForm" method="post" class="hide" enctype="multipart/form-data">
    	<?php else: ?>
    	<form id="contactoForm" method="post" class="show" enctype="multipart/form-data">
    	<?php endif; ?>
    
    		<?php echo $form['_csrf_token']; ?>		
    		    
            <p class="textoForm">Nuestro horario de atención es de Lunes a Viernes de 9 a 17hs. Tu consulta será respondida dentro de las 48 hs hábiles.</p>
            <p class="textoForm">Es importante que el mail que ingreses sea el mismo con el que hayas realizado el pedido asi podemos rastrear tu información.</p>
                    
            <div class="alertaContacto">
                <?php echo ($sf_user->getFlash('mensaje')) ?>
            </div>
                
        	<div class="row">
            	<label>Nombre y Apellido <span class="mandatory">*</span></label>
            	<div><?php echo $form['nombre']; ?></div>
            </div>
            
            <div class="row marginLeft">
            	<label>Email <span class="mandatory">*</span></label>
            	<div><?php echo $form['email']; ?></div>
            </div>
            
            <div class="row">
            	<label>Marca relacionada</label>
            	<div class="customSelect"><?php echo $form['marca']->render( array('title' => '&nbsp;') ); ?></div>
            </div>
            
            <div class="row marginLeft">
            	<label class="doubleLine"># de pedido relacionado</label>
            	<div><?php echo $form['id_pedido']; ?></div>
            </div>
            
            <div class="row double">
            	<label>Motivo <span class="mandatory">*</span></label>
            	<div class="customSelect"><?php echo $form['motivo']->render( array('title' => '&nbsp;') ); ?></div>
            </div>
            
            <div class="row double">
            	<label>Sub Motivo <span class="mandatory">*</span></label>
            	<div class="customSelect"><?php echo $form['sub_motivo']->render( array('title' => '&nbsp;') ); ?></div>
            </div>
            
            <div class="row double mensaje">
            	<label>Consulta <span class="mandatory">*</span></label>
            	<div><?php echo $form['mensaje']; ?></div>
            </div>
                    
            <input class="button" type="submit" value="Enviar"/>
            
    	</form>
    	
	</div>
	
</div>

<?php include_partial('global/tagsRemarketing', array('itemId1' => 'Consultas', 'pageType' => 'searchresults')); ?>