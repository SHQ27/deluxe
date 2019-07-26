<div id="sf_admin_container" class="devueltosMarcas">
  <h1>Devoluciones Pendientes a Marcas</h1>

<?php if ($sf_user->hasFlash('notice')): ?>
  <div class="notice"><?php echo $sf_user->getFlash('notice', ESC_RAW) ?></div>
<?php endif; ?>

  <div id="sf_admin_bar">
  
      <div class="sf_admin_filter">
      
          <form method="post" action="<?php echo url_for('devueltosMarcas') ?>">
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
                              <?php echo $form['fecha']->renderLabel(); ?>
                          </td>
                          <td>
                              <?php echo $form['fecha']; ?>
                          </td>
                          <td class="label">
                              <?php echo $form['devuelto']->renderLabel(); ?>
                          </td>
                          <td>
                              <?php echo $form['devuelto']; ?>
                          </td>
                      </tr>
                  </tbody>
              </table>
          </form>
      </div>
  </div>
  
  <ul class="sf_admin_actions">
    <li class="sf_admin_action_new">
        <a href="<?php echo url_for('devueltosMarcas_new'); ?>">Generar nuevas devoluciones pendientes a una marca</a>
        &nbsp;|&nbsp;
        <a class="background-none" href="<?php echo url_for("devueltosMarcas_descargar_excel", array('id_marca' => $idMarca, 'fecha_from' => $fecha['from'], 'fecha_to' => $fecha['to'], 'devuelto' => $devuelto) ); ?>">Descargar en formato Excel</a>
    </li>
  </ul>

  <div id="sf_admin_content">       
    <div class="sf_admin_list">
        <table cellspacing="0">
          <thead>
            <tr>
                <?php if ( !$devuelto ): ?>
                <th>
                    <input type="checkbox" id="sf_admin_list_batch_checkbox">
                </th>
                <?php endif; ?>
                <th>Imagen</th>
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
                  <th colspan="<?php echo ( $devuelto ) ? '8' : '9'; ?>">
                      <?php if ($pager->haveToPaginate()): ?>
                      <div class="sf_admin_pagination">
                          <a href="<?php echo url_for('devueltosMarcas') ?>?page=<?php echo $pager->getFirstPage(); ?>"><img src="/backend/sfDoctrinePlugin/images/first.png" title="Primera página" alt="Primera página"></a>
                          <a href="<?php echo url_for('devueltosMarcas') ?>?page=<?php echo $pager->getPreviousPage(); ?>"><img src="/backend/sfDoctrinePlugin/images/previous.png" title="Página anterior" alt="Página anterior"></a>
                          
    					  <?php foreach ($pagerRange->rangeAroundPage() as $page): ?>
    					      					  	
    						<?php if ($pager->getPage() == $page): ?>	
    							<?php echo $pager->getPage() ?>
    						<?php else: ?>	
    							<a href="<?php echo url_for('devueltosMarcas') ?>?page=<?php echo $page ?>"><?php echo $page ?></a>
    						<?php endif ?>	
    			
    					  <?php endforeach; ?>  
                          <a href="<?php echo url_for('devueltosMarcas') ?>?page=<?php echo $pager->getNextPage(); ?>"><img src="/backend/sfDoctrinePlugin/images/next.png" title="Página siguiente" alt="Página siguiente"></a>
                          <a href="<?php echo url_for('devueltosMarcas') ?>?page=<?php echo $pager->getLastPage(); ?>"><img src="/backend/sfDoctrinePlugin/images/last.png" title="Última página" alt="Última página"></a>
                      </div>
                              
                      Página <?php echo $pager->getPage() ?>/<?php echo $pager->getLastPage() ?>
                      <?php endif; ?>
                  </th>
              </tr>
          </tfoot>
          <tbody>
            <?php if ( count( $devueltosMarcas ) ):?>
            <?php $i = 0; ?>
            <?php foreach ($devueltosMarcas as $devueltoMarca): ?>            
              <?php $odd = fmod(++$i, 2) ? 'odd' : 'even'; ?>
              <tr class="sf_admin_row <?php echo $odd ?>">
                <?php if ( !$devuelto ): ?>
                <td>
                  <input type="checkbox" class="sf_admin_batch_checkbox" value="<?php echo $devueltoMarca['id_devueltos_marcas']; ?>" name="ids[]">
                </td>
                <?php endif; ?>                
                
                <td><img src="<?php echo sfConfig::get('app_upload_url'); ?>/producto/detalle/chica/<?php echo $devueltoMarca['id_producto_imagen']; ?>.jpg"/></td>
                <td><?php echo $devueltoMarca['marca']; ?></td>
                <td><?php echo $devueltoMarca['codigo']; ?></td>
                <td><a href="/backend/productos/<?php echo $devueltoMarca['id_producto']; ?>/edit"><?php echo $devueltoMarca['denominacion']; ?></a></td>
                <td><?php echo $devueltoMarca['talle']; ?></td>
                <td><?php echo $devueltoMarca['color']; ?></td>
                <td><?php echo $devueltoMarca['costo']; ?></td>
                <td><?php echo $devueltoMarca['cantidad']; ?></td>
              </tr>
            <?php endforeach; ?>
            <?php else: ?>
              <tr class="sf_admin_row">
                <td class="center" colspan="<?php echo ( $devuelto ) ? '8' : '9'; ?>">
                    No hay devoluciones pendientes para los parametros elegidos.
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
    </div>
    
    <?php if ( !$devuelto ): ?>
    <ul class="sf_admin_actions">
        <li class="sf_admin_batch_actions_choice">
            <select class="batch_action" name="batch_action">
                <option value="">Selecciona una acción</option>
                <option value="DEVOLVER">Marcar devueltos</option>
            </select>
            <input class="submit" type="submit" value="ok">
        </li>
    </ul>
    <?php endif; ?>      

        
  </div>
</div>
