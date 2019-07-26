<?php $class = ( $factura->getComprobante() ) ? '' : 'facturacionPending'; ?>

<td class="sf_admin_text sf_admin_list_td_id_pedido <?php echo $class; ?>">
  <a href="/backend/pedidos/<?php echo $factura->getIdPedido() ?>/ListView"><?php echo $factura->getIdPedido() ?></a>
</td><!DOCTYPE td PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<?php if ( $factura->getComprobante() ): ?>

    <td class="sf_admin_text sf_admin_list_td_comprobante <?php echo $class; ?>">
      <?php echo $factura->getComprobante(); ?>  
    </td>
    
    <td class="sf_admin_text sf_admin_list_td_cae <?php echo $class; ?>">
      <?php echo $factura->getCAE() ?>
    </td>
    
    <td class="sf_admin_text sf_admin_list_td_cae_vencimiento <?php echo $class; ?>">
      <?php echo $factura->getCAEVencimiento() ?>
    </td>
    
    <td class="sf_admin_text sf_admin_list_td_resultado <?php echo $class; ?>">
      <?php echo $factura->getResultado(); ?>
    </td>
    
    <td class="sf_admin_text center sf_admin_list_td_mail_enviado <?php echo $class; ?>">
      <?php if ($factura->getMailEnviado()): ?>
      <img src="/backend/sfDoctrinePlugin/images/tick.png" title="Checked" alt="Checked">
      <?php endif; ?>
    </td>

<?php else: ?>
    <td class="sf_admin_text <?php echo $class; ?>" colspan="5">
      Pendiente de envío a AFIP - El envío se realizara en la proxima ejecución del proceso de facturacion.
    </td>
<?php endif; ?>

<td class="sf_admin_text sf_admin_list_td_monto_facturacion <?php echo $class; ?>">
  <?php echo "$ " . $factura->getPedido()->getMontoFacturacion() ?>
</td>

<td class="sf_admin_text sf_admin_list_td_entorno <?php echo $class; ?>">
  <?php echo $factura->getEntorno() ?>
</td>

<td class="sf_admin_text sf_admin_list_td_entorno <?php echo $class; ?>">
  <?php if ( $factura->getComprobante() ): ?>
  <a href="<?php echo url_for('facturacion_descargar_factura', array('idPedido' => $factura->getIdPedido() )); ?>"><img src="/backend/images/icons/small/backup.png" alt="Descargar" title="Descargar"/></a>
  <?php endif; ?>