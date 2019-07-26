        <?php $slugCategoria = sfContext::getInstance()->getRequest()->getParameter('slugProductoCategoria'); ?>
            
        <nav id="nav" class="nav nav">
        	<div class="container">
        		<ul class="menu">        		  
                    <li class="li home"><a href="/">Home</a></li>
                    
                    <?php if ( count( $productoCategoriasPrendas ) ): ?>
                    <li class="li">
                            <span class="prendas"></span>
                            <ul class="submenu">
                              <?php foreach( $productoCategoriasPrendas as $productoCategoria ): ?>
                              <li><a href="<?php echo url_for('productos_listado_categoria', array('slugProductoCategoria' => $productoCategoria->getSlug() ) ); ?>"><?php echo $productoCategoria->getDenominacion();?></a></li>
                              <?php endforeach; ?>
                            </ul>
                    </li>
                    <?php endif; ?>

                    <?php if ( count( $productoCategoriasAccesorios ) ): ?>
                    <li class="li">
                            <span class="accesorios"></span>
                            <ul class="submenu">
                              <?php foreach( $productoCategoriasAccesorios as $productoCategoria ): ?>
                              <li><a href="<?php echo url_for('productos_listado_categoria', array('slugProductoCategoria' => $productoCategoria->getSlug() ) ); ?>"><?php echo $productoCategoria->getDenominacion();?></a></li>
                              <?php endforeach; ?>
                            </ul>
                    </li>
                    <?php endif; ?>

                    <?php if ( $outlet ): ?>
                    <li class="li"><a href="<?php echo url_for('productos_listado_categoria', array('slugProductoCategoria' => $outlet->getSlug() ) ); ?>"><?php echo $outlet->getDenominacion();?></a></a></li>
                    <?php endif; ?>

                    <?php if ( $eshop->getUsaCampaign() ): ?>
                    <li class="li"><a href="<?php echo url_for('campaign'); ?>"><?php echo $eshop->getCampaignTitulo(); ?></a></li>
                    <?php endif; ?>

                    <?php if ( $eshop->getUsaLookbook() ): ?>
                    <li class="li"><a href="<?php echo url_for('lookbook'); ?>"><?php echo $eshop->getLookbookTitulo(); ?></a></li>
                    <?php endif; ?>

                    <?php if ( $eshop->getUsaAcerca() ): ?>
                    <li class="li"><a href="<?php echo url_for('acerca'); ?>"><?php echo $eshop->getAcercaTitulo(); ?></a></li>
                    <?php endif; ?>
                    
                    <li class="li tiendas"><a href="<?php echo url_for('tiendas'); ?>"><?php echo $eshop->getTiendasTitulo(); ?></a></li>

                    <?php if ( $eshop->getFormularioTitulo() ): ?>
                        <li class="li"><a href="<?php echo url_for('formulario'); ?>"><?php echo $eshop->getFormularioTitulo(); ?></a></li>
                    <?php endif; ?>

                    <li class="li consultas"><a href="<?php echo url_for('consultas'); ?>"><?php echo $eshop->getTextoConsultas(); ?></a></li>
        		</ul>
        	</div>
        	<div class="shadow">
        	</div>
        </nav>