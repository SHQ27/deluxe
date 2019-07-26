<nav class="navUserLogged">
	<ul>        		  
        <li class="li"><a class="blockLink" href="<?php echo url_for('mi_cuenta'); ?>"><span>MI CUENTA</span></a><div class="arrow"></div></li>
        <li class="li"><a class="blockLink" href="<?php echo url_for('carrito'); ?>"><span><?php echo strtoupper( $eshop->getMiCarroTitulo() ); ?></span></a><div class="arrow"></div></li>
        <li class="li"><a class="blockLink" href="<?php echo url_for('logout'); ?>"><span>CERRAR SESION</span></a><div class="arrow"></div></li>
	</ul>
</nav>

<nav class="navUserNotLogged">
    <ul> 
        <li class="li"><a class="blockLink" href="<?php echo url_for('usuario_login'); ?>"><span><?php echo $eshop->getTextoIniciarSesion(); ?></span></a><div class="arrow"></div></li>
        <li class="li"><a class="blockLink" href="<?php echo url_for('usuario_registro'); ?>"><span>REGISTRARME</span></a><div class="arrow"></div></li>
    </ul>
</nav>