<div id="sf_admin_container" class="fallados">
  <h1>Listado de Fallados</h1>

  <div id="sf_admin_bar">
  
      <div class="sf_admin_filter">
      
          <form method="post" action="<?php echo url_for('fallados') ?>">
              <table cellspacing="0">
                  <tfoot>
                      <tr>
                          <td colspan="2">
                              <?php echo $form['_csrf_token']; ?>
                              <a class="restablecer">Restablecer</a>
                              <input class="filtrar" type="submit" value="Filtrar">
                          </td>
                      </tr>
                  </tfoot>
                  <tbody>
                      <tr class="sf_admin_form_row sf_admin_text sf_admin_filter_field_buscador">
                          <td class="label">
                              <?php echo $form['id_marca']->renderLabel(); ?>
                          </td>
                          <td>
                              <?php echo $form['id_marca']; ?>
                          </td>
                          <td class="label">
                              <?php echo $form['id_eshop']->renderLabel(); ?>
                          </td>
                          <td>
                              <?php echo $form['id_eshop']; ?>
                          </td>
                          <td class="label">
                              <?php echo $form['fecha']->renderLabel(); ?>
                          </td>
                          <td>
                              <?php echo $form['fecha']; ?>
                          </td>                                                    
                      </tr>
                  </tbody>
              </table>
          </form>
      </div>
  </div>
  
  <p>
      <a href="<?php echo url_for("fallados_descargar_excel", array('id_marca' => $idMarca, 'id_eshop' => $idEshop, 'fecha_from' => $fecha['from'], 'fecha_to' => $fecha['to']) ); ?>">Descargar en formato Excel</a>
  </p>

  <div id="sf_admin_content">       
    <div class="sf_admin_list">
        <table cellspacing="0">
          <thead>
            <tr>
                <th>
                    <input type="checkbox" id="sf_admin_list_batch_checkbox">
                </th>
                <th>Imagen</th>
                <th>eShop</th>
                <th>Marca</th>
                <th>Codigo</th>
                <th>Denominación</th>
                <th>Talle</th>
                <th>Color</th>
                <th>Costo</th>
                <th>Cantidad</th>
            </tr>
          </thead>
                      
          <tfoot>
              <tr>
                  <th colspan="10">
                      <?php if ($pager->haveToPaginate()): ?>
                      <div class="sf_admin_pagination">
                          <a href="<?php echo url_for('fallados') ?>?page=<?php echo $pager->getFirstPage(); ?>"><img src="/backend/sfDoctrinePlugin/images/first.png" title="Primera página" alt="Primera página"></a>
                          <a href="<?php echo url_for('fallados') ?>?page=<?php echo $pager->getPreviousPage(); ?>"><img src="/backend/sfDoctrinePlugin/images/previous.png" title="Página anterior" alt="Página anterior"></a>
                          
    					  <?php foreach ($pagerRange->rangeAroundPage() as $page): ?>
    					      					  	
    						<?php if ($pager->getPage() == $page): ?>	
    							<?php echo $pager->getPage() ?>
    						<?php else: ?>	
    							<a href="<?php echo url_for('fallados') ?>?page=<?php echo $page ?>"><?php echo $page ?></a>
    						<?php endif ?>	
    			
    					  <?php endforeach; ?>  
                          <a href="<?php echo url_for('fallados') ?>?page=<?php echo $pager->getNextPage(); ?>"><img src="/backend/sfDoctrinePlugin/images/next.png" title="Página siguiente" alt="Página siguiente"></a>
                          <a href="<?php echo url_for('fallados') ?>?page=<?php echo $pager->getLastPage(); ?>"><img src="/backend/sfDoctrinePlugin/images/last.png" title="Última página" alt="Última página"></a>
                      </div>
                              
                      Página <?php echo $pager->getPage() ?>/<?php echo $pager->getLastPage() ?>
                      <?php endif; ?>
                  </th>
              </tr>
          </tfoot>
          <tbody>
            <?php if ( count( $fallados ) ):?>
            <?php $i = 0; ?>
            <?php foreach ($fallados as $fallado): ?>            
              <?php $odd = fmod(++$i, 2) ? 'odd' : 'even'; ?>
              <tr class="sf_admin_row <?php echo $odd ?>">
                <td>
                  <input type="checkbox" class="sf_admin_batch_checkbox" value="<?php echo $fallado['ids_fallados']; ?>" name="ids[]">
                </td>
                
                <td><img src="<?php echo sfConfig::get('app_upload_url'); ?>/producto/detalle/chica/<?php echo $fallado['id_producto_imagen']; ?>.jpg"/></td>
                <td><?php echo $fallado['eshop']; ?></td>
                <td><?php echo $fallado['marca']; ?></td>
                <td><?php echo $fallado['codigo']; ?></td>
                <td><a href="/backend/productos/<?php echo $fallado['id_producto']; ?>/edit"><?php echo $fallado['denominacion']; ?></a></td>
                <td><?php echo $fallado['talle']; ?></td>
                <td><?php echo $fallado['color']; ?></td>
                <td><?php echo $fallado['costo']; ?></td>
                <td><?php echo $fallado['cantidad']; ?></td>
              </tr>
            <?php endforeach; ?>
            <?php else: ?>
              <tr class="sf_admin_row">
                <td class="center" colspan="9">
                    No hay fallados para los parametros elegidos.
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
    </div>
    
    <ul class="sf_admin_actions">
        <li class="sf_admin_batch_actions_choice">
            <select class="batch_action" name="batch_action">
                <option value="">Selecciona una acción</option>
                <option value="RECUPERAR">Marcar recuperados</option>
            </select>
            <input class="submit" type="submit" value="ok">
        </li>
    </ul>
        
  </div>
</div>
