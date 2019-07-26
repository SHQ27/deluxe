<?php $class = ( $ncredito->getComprobante() ) ? '' : 'facturacionPending'; ?>

<td class="sf_admin_text sf_admin_list_td_id_pedido <?php echo $class; ?>">
  <?php $i = 0; ?>
  <?php $ncreditoFacturas = $ncredito->getNcreditoFactura(); ?>
  <?php  foreach ( $ncreditoFacturas as $nCreditoFactura ): ?>
    <?php $i++; ?> 
    <a href="/backend/pedidos/<?php echo $nCreditoFactura->getFactura()->getIdPedido() ?>/ListView"><?php echo $nCreditoFactura->getFactura()->getIdPedido() ?></a>
    <?php echo ( count($ncreditoFacturas) != $i )? ', ' : ''; ?>
  <?php endforeach; ?>
</td>

<?php if ( $ncredito->getComprobante() ): ?>

    <td class="sf_admin_text sf_admin_list_td_comprobante <?php echo $class; ?>">
      <?php echo $ncredito->getComprobante() ?>
    </td>
    
    <td class="sf_admin_text sf_admin_list_td_cae <?php echo $class; ?>">
      <?php echo $ncredito->getCAE() ?>
    </td>
    <td class="sf_admin_text sf_admin_list_td_cae_vencimiento <?php echo $class; ?>">
      <?php echo $ncredito->getCAEVencimiento() ?>
    </td>
    <td class="sf_admin_text sf_admin_list_td_resultado <?php echo $class; ?>">
      <?php echo $ncredito->getResultado() ?>
    </td>

<?php else: ?>
    <td class="sf_admin_text <?php echo $class; ?>" colspan="4" <?php echo $class; ?>">
      Pendiente de envío a AFIP - El envío se realizara en la proxima ejecución del proceso de facturacion.
    </td>
<?php endif; ?>


<td class="sf_admin_text sf_admin_list_td_importe <?php echo $class; ?>">
  <?php echo $ncredito->getImporte() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_entorno <?php echo $class; ?>">
  <?php echo ucfirst($ncredito->getEntorno()) ?>
</td>

<td class="sf_admin_text sf_admin_list_td_entorno <?php echo $class; ?>">
  <?php if ( $ncredito->getComprobante() ): ?>
  <a href="<?php echo url_for('facturacion_descargar_ncredito', array('idNCredito' => $ncredito->getIdNcredito() )); ?>"><img src="/backend/images/icons/small/backup.png" alt="Descargar" title="Descargar"/></a>
  <?php endif; ?>
</td>