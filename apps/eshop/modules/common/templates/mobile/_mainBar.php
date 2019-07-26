<?php $slugCategoria = sfContext::getInstance()->getRequest()->getParameter('slugProductoCategoria'); ?>
    
<nav class="navMenu">
	<ul>        		  
        <li class="li home"><a class="blockLink" href="/"><span>Home</span></a><div class="arrow"></div></li>
        
        <?php if ( count( $productoCategoriasPrendas ) ): ?>
        <li class="lisubmenu">
            <div class="titsubmenu prendas"><div class="arrow"></div></div>
            <ul class="submenu">
                <?php foreach( $productoCategoriasPrendas as $productoCategoria ): ?>
                <li class="li"><a class="blockLink" href="<?php echo url_for('productos_listado_categoria', array('slugProductoCategoria' => $productoCategoria->getSlug() ) ); ?>"><span><?php echo truncate_text($productoCategoria->getDenominacion(), 40);?></span></a><div class="arrow"></div></li>
                <?php endforeach; ?>
            </ul>
        </li>
        <?php endif; ?>

        <?php if ( count( $productoCategoriasAccesorios ) ): ?>
        <li class="lisubmenu">
            <div class="titsubmenu accesorios"><div class="arrow"></div></div>
            <ul class="submenu">
                <?php foreach( $productoCategoriasAccesorios as $productoCategoria ): ?>
                <li class="li"><a class="blockLink" href="<?php echo url_for('productos_listado_categoria', array('slugProductoCategoria' => $productoCategoria->getSlug() ) ); ?>"><span><?php echo truncate_text($productoCategoria->getDenominacion(), 40);?></span></a><div class="arrow"></div></li>
                <?php endforeach; ?>
            </ul>
        </li>
        <?php endif; ?>

        <?php if ( $outlet ): ?>
        <li class="li"><a class="blockLink" href="<?php echo url_for('productos_listado_categoria', array('slugProductoCategoria' => $outlet->getSlug() ) ); ?>"><span><?php echo truncate_text($outlet->getDenominacion(), 40);?></span></a><div class="arrow"></div></li>
        <?php endif; ?>

        <?php if ( $eshop->getUsaCampaign() ): ?>
        <li class="li"><a class="blockLink" href="<?php echo url_for('campaign'); ?>"><span><?php echo $eshop->getCampaignTitulo(); ?></span></a><div class="arrow"></div></li>
        <?php endif; ?>

        <?php if ( $eshop->getUsaLookbook() ): ?>
        <li class="li"><a class="blockLink" href="<?php echo url_for('lookbook'); ?>"><span><?php echo $eshop->getLookbookTitulo(); ?></span></a><div class="arrow"></div></li>
        <?php endif; ?>

        <?php if ( $eshop->getUsaAcerca() ): ?>
        <li class="li"><a class="blockLink" href="<?php echo url_for('acerca'); ?>"><span><?php echo $eshop->getAcercaTitulo(); ?></span></a><div class="arrow"></div></li>
        <?php endif; ?>
        
        <li class="li tiendas"><a class="blockLink" href="<?php echo url_for('tiendas'); ?>"><span><?php echo $eshop->getTiendasTitulo(); ?></span></a><div class="arrow"></div></li>

        <?php if ( $eshop->getFormularioTitulo() ): ?>
        <li class="li"><a class="blockLink" href="<?php echo url_for('formulario'); ?>"><span><?php echo $eshop->getFormularioTitulo(); ?></span></a><div class="arrow"></div></li>
        <?php endif; ?>

        <li class="li consultas"><a class="blockLink" href="<?php echo url_for('consultas'); ?>"><span><?php echo $eshop->getTextoConsultas(); ?></span></a><div class="arrow"></div></li>
	</ul>
</nav>