<div id="recomendarProducto">

    <h1>
        <span class="sprite icon-star-left"></span>
        <span class="Raleway">¡Recomendar Producto!</span>
        <span class="sprite icon-star-right"></span>
    </h1>
                        						                            
	<form method="post" >							
		<?php echo $recomendarProductoForm['_csrf_token']; ?>
		<?php echo $recomendarProductoForm['id_producto']; ?>
    	<?php echo $recomendarProductoForm['email']->render(array('placeholder' => 'Su E-mail')); ?>
    	<div class="alert"></div>            
        <input class="button" type="submit" value="Enviar">
        <a class="cerrar">Cerrar</a>
	</form>
</div>
