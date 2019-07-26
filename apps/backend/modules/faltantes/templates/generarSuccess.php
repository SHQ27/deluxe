<div id="sf_admin_container" class="faltantes">
    
    <h1>Faltantes</h1>
    		
    <form method="post">
    	<?php echo $form['_csrf_token']; ?>
    	
    	<div class="row">
	    	<?php echo $form['id_eshop']->renderLabel(); ?>
			<?php echo $form['id_eshop']; ?>
		</div>
    	
    	<div class="row campana">
	    	<?php echo $form['campana']->renderLabel(); ?>
			<?php echo $form['campana']; ?>
		</div>

    	<div class="row marca">
	    	<?php echo $form['id_marca']->renderLabel(); ?>
			<?php echo $form['id_marca']; ?>
			<div class="procesando"></div>
		</div>
		
		<div class="row producto">	
	    	<?php echo $form['producto']->renderLabel(); ?>
			<?php echo $form['producto']; ?>
			<div class="procesando"></div>
		</div>
		
		<div class="row productoItem">	
	    	<?php echo $form['productoItem']->renderLabel(); ?>
			<?php echo $form['productoItem']; ?>
			<div class="procesando"></div>
		</div>
		
        <input type="submit" value="Buscar" />        
    </form>
    
	<div class="resultado"></div>    
    
</div>