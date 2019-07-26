<div id="sf_admin_container" class="outlet">
    
    <h1>Outlet</h1>
    
    <form enctype="multipart/form-data" method="post">
    	
    	<?php echo $form['_csrf_token'] ?>
    	
    	<h2>Datos del Outlet</h2>
    	
    	<div class="row">
    	    <?php echo $form['denominacion']->renderError(); ?>
        	<?php echo $form['denominacion']->renderLabel(); ?>
        	<?php echo $form['denominacion'] ?>
		</div>
		
    	<div class="row">
    	    <?php echo $form['fecha_inicio']->renderError(); ?>
        	<?php echo $form['fecha_inicio']->renderLabel(); ?>
        	<?php echo $form['fecha_inicio'] ?>
		</div>
		
    	<div class="row">
    	    <?php echo $form['fecha_fin']->renderError(); ?>
        	<?php echo $form['fecha_fin']->renderLabel(); ?>
        	<?php echo $form['fecha_fin'] ?>
		</div>
				
    	<div class="row">
    	    <?php echo $form['mostrar_banner']->renderError(); ?>
        	<?php echo $form['mostrar_banner']->renderLabel(); ?>
        	<?php echo $form['mostrar_banner'] ?>
		</div>
		
    	<div class="row">
    	    <?php echo $form['mostrar_descripcion']->renderError(); ?>
        	<?php echo $form['mostrar_descripcion']->renderLabel(); ?>
        	<?php echo $form['mostrar_descripcion'] ?>
		</div>
		
    	<div class="row">
    	    <?php echo $form['permitir_pago_offline']->renderError(); ?>
        	<?php echo $form['permitir_pago_offline']->renderLabel(); ?>
        	<?php echo $form['permitir_pago_offline'] ?>
		</div>
				
    	<div class="row">
    	    <?php echo $form['activo']->renderError(); ?>
        	<?php echo $form['activo']->renderLabel(); ?>
        	<?php echo $form['activo'] ?>
		</div>
		
    	<div class="row">
    	    <?php echo $form['off']->renderError(); ?>
        	<?php echo $form['off']->renderLabel(); ?>
        	<?php echo $form['off'] ?>
		</div>
		

		<h2>Imágenes del Outlet</h2>
		
    	<div class="row">
    	    <?php echo $form['banner_principal']->renderError(); ?>
        	<label>Banner Principal <small>(<?php echo imageHelper::getInstance()->getWidth('outlet_banner_principal')?> x <?php echo imageHelper::getInstance()->getHeight('outlet_banner_principal')?>)</small></label>
        	<?php echo $form['banner_principal'] ?>
		</div>

        <?php $imagenes = imagenBannerPrincipalTable::getInstance()->getList( 1, imagenBannerPrincipal::TIPO_OUTLET ); ?>

        <div class="administrar_imagenes">
        <?php foreach ($imagenes as $imagen):?>
            <?php $src = '/outlet/banner/principal/' .  $imagen->getSrc(); ?>
            	<div class="imagen">
        		<img src="<?php echo sfConfig::get('app_upload_url') . $src; ?>" rel="<?php echo $imagen->getIdImagenBannerPrincipal(); ?>" width="750"/>
        		<a class="delete">Eliminar</a>		
        	</div>
        <?php endforeach;?>
        </div>	
		
        <div class="row">
            <?php echo $form['banner']->renderError(); ?>
            <label>Banner <small>(<?php echo imageHelper::getInstance()->getWidth('outlet_banner')?> x <?php echo imageHelper::getInstance()->getHeight('outlet_banner')?>)</small></label>
            <?php echo $form['banner'] ?>
        </div>

        <div class="row">
            <?php echo $form['banner_hover']->renderError(); ?>
            <label>Banner Hover <small>(<?php echo imageHelper::getInstance()->getWidth('outlet_banner')?> x <?php echo imageHelper::getInstance()->getHeight('outlet_banner')?>)</small></label>
            <?php echo $form['banner_hover'] ?>
        </div>
		
    	<div class="row">
    	    <?php echo $form['header']->renderError(); ?>
        	<label>Header<small>(<?php echo imageHelper::getInstance()->getWidth('outlet_header')?> x <?php echo imageHelper::getInstance()->getHeight('outlet_header')?>)</small></label>
        	<?php echo $form['header'] ?>
		</div>
		
		<h2>Estimación de envio</h2>
		
        <div class="campana_estimacion">
            <div>
                <label>Forma</label>
                <input type="radio" id="estimacion_fechas" name="estimacion_tipo" value="FECHAS" />
                <label class="label" for="estimacion_fechas">Fechas</label>
                <input type="radio" id="estimacion_horas" name="estimacion_tipo" value="HORAS" />
                <label class="label" for="estimacion_horas">Horas</label>        
            </div>
        </div>
		
    	<div class="row estimacion_envio_fecha">
    	    <?php echo $form['estimacion_envio_fecha']->renderError(); ?>
        	<?php echo $form['estimacion_envio_fecha']->renderLabel(); ?>
        	<?php echo $form['estimacion_envio_fecha'] ?>
		</div>
		
    	<div class="row estimacion_envio_horas">
    	    <?php echo $form['estimacion_envio_horas']->renderError(); ?>
        	<?php echo $form['estimacion_envio_horas']->renderLabel(); ?>
        	<?php echo $form['estimacion_envio_horas'] ?>
		</div>
		
        <input type="submit" value="Guardar" class="button" />        
    </form>
    
   
</div>