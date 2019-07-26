<?php $filtros = sfContext::getInstance()->getUser()->getAttribute('pedidos.filters', $configuration->getFilterDefaults(), 'admin_module'); ?>

<li class="sf_admin_batch_actions_choice">
  <select name="batch_action">
    <option value=""><?php echo __('Choose an action', array(), 'sf_admin') ?></option>
    <option value="batchFacturar"><?php echo __('Marcar como facturado', array(), 'sf_admin') ?></option>
    <option value="batchPrepararEnvio"><?php echo __('Preparar envio', array(), 'sf_admin') ?></option>

    <?php $idEShop = $filtros['id_eshop']; ?>
    <?php if ( $idEShop ): ?>
    <?php if ( $idEShop != eshop::ESHOP_DELUXE ): ?>
    <option value="batchRecepcionMercaderiaEshop"><?php echo __('Gestionar Recepcion de Mercaderia', array(), 'sf_admin') ?></option>
    <?php endif; ?>
    <option value="batchReimprimirRemitosHTML"><?php echo __('Imprimir remitos (HTML)', array(), 'sf_admin') ?></option>
    <option value="batchReimprimirRemitosXLS"><?php echo __('Imprimir remitos (XLS)', array(), 'sf_admin') ?></option>
    <?php endif; ?>
  </select>
  <?php $form = new BaseForm(); if ($form->isCSRFProtected()): ?>
    <input type="hidden" name="<?php echo $form->getCSRFFieldName() ?>" value="<?php echo $form->getCSRFToken() ?>" />
  <?php endif; ?>
  <input type="submit" value="<?php echo __('go', array(), 'sf_admin') ?>" />
</li>