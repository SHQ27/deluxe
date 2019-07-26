<?php use_helper('I18N', 'Date') ?>
<?php include_partial('campanas/assets') ?>

<div id="sf_admin_container" class="logistica">
  <h1>Logistica de Campañas</h1>

  <?php include_partial('campanas/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('campanas/list_header', array('pager' => $pager)) ?>
  </div>

  <div id="sf_admin_bar">
    <?php include_partial('campanas/filters', array('form' => $filters, 'configuration' => $configuration, 'esLogistica' => true)) ?>
  </div>

  <div id="sf_admin_content">
  
    <ul class="sf_admin_actions">
      <li><a href="/backend/campanas/logistica/descargarExcel" class="background-none">Descargar Excel</a></li>
      <li><a href="<?php echo url_for('campanas_logistica_hoja_de_ruta'); ?>" class="background-none">Descargar Hoja de Ruta</a></li>
    </ul>
         
    <div class="sf_admin_list">
      <?php if (!$pager->getNbResults()): ?>
        <p><?php echo __('No result', array(), 'sf_admin') ?></p>
      <?php else: ?>
        <table cellspacing="0">
          <thead>
            <tr>
            
                <th>
                  <?php if ('id_campana' == $sort[0]): ?>
                    <?php echo link_to(__('Id', array(), 'messages'), '@campanas_logistica', array('query_string' => 'sort=id_campana&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
                    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
                  <?php else: ?>
                    <?php echo link_to(__('Id', array(), 'messages'), '@campanas_logistica', array('query_string' => 'sort=id_campana&sort_type=asc')) ?>
                  <?php endif; ?>
                </th>
                
                <th>
                  <?php if ('denominacion' == $sort[0]): ?>
                    <?php echo link_to(__('Campaña', array(), 'messages'), '@campanas_logistica', array('query_string' => 'sort=denominacion&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
                    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
                  <?php else: ?>
                    <?php echo link_to(__('Campaña', array(), 'messages'), '@campanas_logistica', array('query_string' => 'sort=denominacion&sort_type=asc')) ?>
                  <?php endif; ?>
                </th>
                
                <th>
                  <?php if ('fecha_inicio' == $sort[0]): ?>
                    <?php echo link_to(__('Fch. Inicio', array(), 'messages'), '@campanas_logistica', array('query_string' => 'sort=fecha_inicio&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
                    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
                  <?php else: ?>
                    <?php echo link_to(__('Fch. Inicio', array(), 'messages'), '@campanas_logistica', array('query_string' => 'sort=fecha_inicio&sort_type=asc')) ?>
                  <?php endif; ?>
                </th>
                
                
                <th>
                  <?php if ('fecha_fin' == $sort[0]): ?>
                    <?php echo link_to(__('Fch. Fin', array(), 'messages'), '@campanas_logistica', array('query_string' => 'sort=fecha_fin&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
                    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
                  <?php else: ?>
                    <?php echo link_to(__('Fch. Fin', array(), 'messages'), '@campanas_logistica', array('query_string' => 'sort=fecha_fin&sort_type=asc')) ?>
                  <?php endif; ?>
                </th>
                
                <th>Dias desde fin.</th>
                <th>Desp.</th>
                <th>No Desp.</th>
                <th>Marca</th>
                <th>E-Mail</th>
                <th>Teléfono</th>
                <th>Uni. Ven.</th>
                <th>Mon. Fin. c/IVA</th>
                <th>Cant. Ped.</th>
                <th>Mail Env.</th>
                <th>Fch. Est. Ent.</th>
                <th>Pagada</th>
                <th>Usa Ref.</th>
                <th>Merc. Recib.</th>
                <th id="sf_admin_list_th_actions">Acciones</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th colspan="19">
                <?php if ($pager->haveToPaginate()): ?>
                  <?php include_partial('campanas/pagination', array('pager' => $pager, 'esLogistica' => true)) ?>
                <?php endif; ?>
    
                <?php echo format_number_choice('[0] no result|[1] 1 Campaña|(1,+Inf] %1% Campañas', array('%1%' => $pager->getNbResults()), $pager->getNbResults(), 'sf_admin') ?>
                <?php if ($pager->haveToPaginate()): ?>
                  <?php echo __('(page %%page%%/%%nb_pages%%)', array('%%page%%' => $pager->getPage(), '%%nb_pages%%' => $pager->getLastPage()), 'sf_admin') ?>
                <?php endif; ?>
              </th>
            </tr>
          </tfoot>
          <tbody>
            <?php $j = 0; ?>
            <?php foreach ($pager->getResults() as $i => $campana): ?>
            
            <?php $campanaMarcas = $campana->getCampanaMarca(); ?>
            <?php $first = true; ?>
            <?php $filtroPagada = $filters->getDefault('pagada'); ?>
            <?php $filtroEstado = $filters->getDefault('estado'); ?>
            <?php $filtroMarca = $filters->getDefault('marca'); ?>
            
            <?php foreach( $campanaMarcas as $campanaMarca ): ?>
            <?php if ( $filtroPagada !== null && $campanaMarca->getPagada() != $filtroPagada ) { continue; } ?>
            <?php if ( $filtroMarca !== null && $campanaMarca->getIdMarca() != $filtroMarca ) { continue; } ?>
            
            <?php $odd = fmod(++$j, 2) ? 'odd' : 'even'; ?>
            <?php $dataCantidades = $campanaMarca->getCantidades(); ?>
            
            <?php $diasFin = (int) ( ( time() - strtotime( $campana->getFechaFin() ) ) / 86400  ) ?>
            
            <?php $color = ''; ?>
            <?php if ( $campanaMarca->getEnviarAvisoOrdenCompra() ): ?>
                <?php if ( $diasFin <= 2 ): ?>
                <?php $color = 'verde'; ?>
                <?php elseif ( $diasFin <= 5 ): ?>
                <?php $color = 'amarillo'; ?>            
                <?php else: ?>
                <?php $color = 'rojo'; ?>
                <?php endif; ?>
            <?php endif; ?>
            
              <?php $marca = $campanaMarca->getMarca(); ?>            
              <?php $cantDespachados = $campana->getCantidadPedidosDespachados($marca->getIdMarca()); ?>
            
              <tr class="sf_admin_row <?php echo $odd ?> <?php echo $color?> <?php echo ( $first ) ? 'first' : ''; ?> <?php echo ( !$campana->estaFinalizada() && $filtroEstado != 'ENCURSO' ) ? 'nofinalizada' : ''; ?>">
                <td><?php echo $campana->getIdCampana(); ?></td>
                <td><a href="/backend/campanas/<?php echo $campana->getIdCampana(); ?>/edit"><?php echo $campana->getDenominacion(); ?></a></td>
                <td><?php echo date('d/m/Y', strtotime($campana->getFechaInicio())); ?></td>
                <td><?php echo date('d/m/Y', strtotime($campana->getFechaFin())); ?></td>
                <td><?php echo $diasFin; ?></td>
                <td><?php echo $cantDespachados; ?></td>
                <td><?php echo $dataCantidades['cantidad_pedidos'] - $cantDespachados; ?></td>
                <td><?php echo $marca->getNombre(); ?></td>
                <td title="<?php echo $campanaMarca->getEmailOrdenCompra(); ?>"><?php echo truncate_text($campanaMarca->getEmailOrdenCompra(), 15); ?></td>
                <td><?php echo ( $campanaMarca->getTelefonoOrdenCompra() ) ? $campanaMarca->getTelefonoOrdenCompra() : '-'; ?></td>
                <td><?php echo $dataCantidades['unidades']; ?></td>
                <td>$<?php echo formatHelper::getInstance()->decimalNumber( $dataCantidades['costo_total'] );?></td>
                <td><?php echo $dataCantidades['cantidad_pedidos']; ?></td>
                <td><?php echo ( $campanaMarca->getUltimoEnvio() ) ? 'Si' : 'No'; ?></td>
                <td>
                    <?php if ( $campanaMarca->getFechaEstimadaEntrega() ) : ?>
                    <?php echo date('d/m/Y', strtotime($campanaMarca->getFechaEstimadaEntrega())); ?>
                    <?php else: ?>
                    -
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ( $campanaMarca->getPagada() ) : ?>
                    Pagada
                    <?php else: ?>
                    No<br/>Pagada
                    <?php endif; ?>
                </td>                
                <td>
                    <?php if ( $campanaMarca->vendioStockRefuerzo() ) : ?>
                    Usa<br/>Stk. Ref.
                    <?php else: ?>
                    No Usa<br/>Stk. Ref.
                    <?php endif; ?>
                </td>                
                <td><?php echo ( $campanaMarca->recibioMercaderia() ) ? 'Si' : 'No'; ?></td>
                <td>
                    <ul class="sf_admin_td_actions">                    
                        <li><a href="/backend/campana/<?php echo $campanaMarca->getIdCampana(); ?>/marca/<?php echo $campanaMarca->getIdMarca(); ?>/comentarios">Comentarios</a></li>                
                        <?php if ( $campanaMarca->getEnviarAvisoOrdenCompra() ): ?>
                        <li class="desactivar"><a href="/backend/campana/<?php echo $campanaMarca->getIdCampana(); ?>/marca/<?php echo $campanaMarca->getIdMarca(); ?>/desactivarRecordatorio">Desactivar Recordatorio</a></li>
                        <?php else: ?>                        
                        <li class="activar"><a href="/backend/campana/<?php echo $campanaMarca->getIdCampana(); ?>/marca/<?php echo $campanaMarca->getIdMarca(); ?>/activarRecordatorio">Activar Recordatorio</a></li>
                        <?php endif; ?>
                        <li class="faltantes"><a href="/backend/faltantes" rel="<?php echo $campanaMarca->getIdCampana(); ?>-<?php echo $campanaMarca->getIdMarca(); ?>">Ver Faltantes</a></li>                        
                        <li class="verOC"><a href="<?php echo url_for('pedido_orden_compra'); ?>?id_marca=<?php echo $campanaMarca->getIdMarca(); ?>&id_campana=<?php echo $campanaMarca->getIdCampana(); ?>">Ver OC Online</a></li>
                        <li class="descargarOC"><a href="<?php echo url_for('pedido_orden_compra'); ?>?id_marca=<?php echo $campanaMarca->getIdMarca(); ?>&id_campana=<?php echo $campanaMarca->getIdCampana(); ?>&descargar=true">Descargar OC</a></li>
                        
                        <?php if ( $campanaMarca->getPagada() ) : ?>
                        <li class="noPagada"><a href="/backend/campana/<?php echo $campanaMarca->getIdCampana(); ?>/marca/<?php echo $campanaMarca->getIdMarca(); ?>/no-pagada">Marcar como No Pagada</a></li>
                        <?php else: ?>          
                        <li class="pagada"><a href="/backend/campana/<?php echo $campanaMarca->getIdCampana(); ?>/marca/<?php echo $campanaMarca->getIdMarca(); ?>/pagada">Marcar como Pagada</a></li>
                        <?php endif; ?>

                        <?php if ( $campanaMarca->recibioMercaderia() ) : ?>
                        <li class="checkBlue"><a href="<?php echo url_for('campanas_recepcionMercaderia', array('idCampana' => $campanaMarca->getIdCampana(), 'idMarca' => $campanaMarca->getIdMarca() ) ); ?>">Recibir mas Mercaderia</li>
                        <?php else: ?>          
                        <li class="verOC"><a href="<?php echo url_for('campanas_recepcionMercaderia', array('idCampana' => $campanaMarca->getIdCampana(), 'idMarca' => $campanaMarca->getIdMarca() ) ); ?>">Recepción de Mercaderia</li>
                        <?php endif; ?>
                        
                    </ul>
                </td>
              </tr>
              <?php $first = false; ?>
            <?php endforeach; ?>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('campanas/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
