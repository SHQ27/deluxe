<div id="sf_admin_container">
    <h1>Wait List</h1>

    <div id="sf_admin_bar">
        <div class="sf_admin_filter">

            <form method="post" action="/backend/waitList">
                <table cellspacing="0">
                    <tfoot>
                        <tr>
                            <td colspan="2"><?php echo $form['_csrf_token']; ?>
                                <a href="/backend/waitList">Restablecer</a>
                                <input type="submit" value="Filtrar"></td>
                        </tr>
                    </tfoot>

                    <tbody>
                        <tr class="sf_admin_form_row sf_admin_text">
                            <td class="label"><?php echo $form['stock_campana']->renderLabel(); ?>
                            </td>
                            <td><?php echo $form['stock_campana']; ?></td>
                        </tr>

                        <tr class="sf_admin_form_row sf_admin_text">
                            <td class="label"><?php echo $form['marca']->renderLabel(); ?>
                            </td>
                            <td><?php echo $form['marca']; ?></td>
                        </tr>

                        <tr class="sf_admin_form_row sf_admin_text">
                            <td class="label" style="width: 150px;"><?php echo $form['productos_activos']->renderLabel(); ?>
                            </td>
                            <td><?php echo $form['productos_activos']; ?>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </form>

        </div>
    </div>



    <div id="sf_admin_content">


        <div class="sf_admin_list">
            <table>
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Id Producto</th>
                        <th>Categoria</th>
                        <th>Denominación</th>
                        <th>Marca</th>
                        <th>Cantidad</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pagerRange->getPager()->execute() as $i => $producto): $odd = fmod(++$i, 2) ? 'odd' : 'even' ?>
                    <tr class="sf_admin_row <?php echo $odd ;?>">
                        <td><?php if ( is_file( imageHelper::getInstance()->getPath('producto_detalle_chica', $producto ) ) ):?>
                            <img
                            src="<?php echo imageHelper::getInstance()->getUrl('producto_detalle_chica', $producto ); ?>" />
                            <?php endif; ?></td>
                        <td><?php echo $producto->getIdProducto(); ?></td>
                        <td><?php echo $producto->getProductoCategoria(); ?></td>
                        <td><?php echo $producto->getDenominacion(); ?></td>
                        <td><?php echo $producto->getMarca()->getNombre()?></td>
                        <td><?php echo $producto->getCantWaitingList(); ?></td>
                        <td><a class="verDetalle"
                            rel="<?php echo $producto->getIdProducto()?>">Ver
                                Detalle</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="15">
                        
                            <div class="sf_admin_pagination">
            					<?php if ($pagerRange->getPager()->haveToPaginate()): ?>
            						<?php if ( $pagerRange->getPager()->getPage() != 1 ): ?>
                                    <a href="<?php echo url_for('@waiting_list') ?>?page=1">
                                        <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/first.png', array('alt' => __('First page', array(), 'sf_admin'), 'title' => __('First page', array(), 'sf_admin'))) ?>
                                    </a>
                                    <a href="<?php echo url_for('@waiting_list') ?>?page=<?php echo $pagerRange->getPager()->getPreviousPage() ?>">
                                        <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/previous.png', array('alt' => __('Previous page', array(), 'sf_admin'), 'title' => __('Previous page', array(), 'sf_admin'))) ?>
                                    </a>
            				    	<?php endif; ?>
            		    	
            				    	<?php foreach ($pagerRange->rangeAroundPage() as $page): ?>	    	
            						<?php if ( $page == $pagerRange->getPager()->getPage() ): ?>
            						<?php echo $page ?>
            						<?php else: ?>
            	        			<a href="<?php echo url_for('@waiting_list') ?>?page=<?php echo $page ?>"><?php echo $page ?></a>
            	        			<?php endif; ?>
            				    	<?php endforeach; ?>
            						
            				    	<?php if ( $pagerRange->getPager()->getLastPage() != $pagerRange->getPager()->getPage() ): ?>
                                    <a href="<?php echo url_for('@waiting_list') ?>?page=<?php echo $pagerRange->getPager()->getNextPage() ?>">
                                        <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/next.png', array('alt' => __('Next page', array(), 'sf_admin'), 'title' => __('Next page', array(), 'sf_admin'))) ?>
                                    </a>
                                    <a href="<?php echo url_for('@waiting_list') ?>?page=<?php echo $pagerRange->getPager()->getLastPage() ?>">
                                        <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/last.png', array('alt' => __('Last page', array(), 'sf_admin'), 'title' => __('Last page', array(), 'sf_admin'))) ?>
                                    </a>
            				    	<?php endif; ?>
            					<?php endif; ?>
        					</div>
        					        					
                            <?php echo format_number_choice('[0] no result|[1] 1 result|(1,+Inf] %1% results', array('%1%' => $pagerRange->getPager()->getNumResults()), $pagerRange->getPager()->getNumResults(), 'sf_admin') ?>
                            <?php if ($pagerRange->getPager()->haveToPaginate()): ?>
                              <?php echo __('(page %%page%%/%%nb_pages%%)', array('%%page%%' => $pagerRange->getPager()->getPage(), '%%nb_pages%%' => $pagerRange->getPager()->getLastPage()), 'sf_admin') ?>
                            <?php endif; ?>
                        </th>
                    </tr>
                </tfoot>

            </table>
        </div>

        <div id="waitListDetail"></div>

    </div>

</div>
