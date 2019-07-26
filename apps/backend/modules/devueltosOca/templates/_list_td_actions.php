<td>
	<ul class="sf_admin_td_actions">
		<?php if ( !$devuelto_oca->getFechaRetirado() ): ?>
	    <li class="sf_admin_action_fueretirado">
	      <?php echo link_to(__('Marcar como Retirado', array(), 'messages'), 'devueltosOca/ListFueRetirado?id_devuelto_oca='.$devuelto_oca->getIdDevueltoOca(), array()) ?>
	    </li>
	    <li class="sf_admin_action_reenviarmail">
	      <?php echo link_to(__('Reenviar Mail', array(), 'messages'), 'devueltosOca/ListReenviarMail?id_devuelto_oca='.$devuelto_oca->getIdDevueltoOca(), array()) ?>
	    </li>
		<?php endif; ?>
	</ul>
</td>