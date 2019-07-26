<?php

class TipoAvisoPago extends Doctrine_Migration_Base
{
  public function up()
  {
  	$tipoAvisoPedido = new tipoAvisoPedido();
  	$tipoAvisoPedido->setIdTipoAvisoPedido( tipoAvisoPedido::RECORDATORIO_OFF );
  	$tipoAvisoPedido->setDenominacion( 'Recordatorio de pago por medio OFF' );
  	$tipoAvisoPedido->save();
  }

  public function down()
  {
  	$tipoAvisoPedido = tipoAvisoPedidoTable::getInstance()->findOneByIdTipoAvisoPedido( tipoAvisoPedido::RECORDATORIO_OFF );
  	$tipoAvisoPedido->delete();
  }
}
