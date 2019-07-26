<?php if ( $_SERVER["REQUEST_URI"] != '/backend/'): ?>

<h2 style="text-align: center">No tiene los permisos suficientes para visualizar esta pagina!</h2>

<p style="text-align: center">
	<br/>
	Haga <a href="<?php echo url_for('sf_guard_signout')?>">click aquí</a> para acceder con otro usuario.
</p>
<?php else:?>
    <p style="text-align: center">
    	<br/><br/><br/><br/><br/><br/>
    	Elija una opción en la barra superior.
    </p>    
<?php endif; ?>

<br/><br/><br/><br/><br/><br/>
<br/><br/><br/><br/><br/><br/>
<br/><br/><br/><br/><br/><br/>