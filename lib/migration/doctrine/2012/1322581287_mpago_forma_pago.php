<?php

class MpagoFormaPago extends Doctrine_Migration_Base
{
  public function up()
  {
  	$formaPago = new formaPago();
  	$formaPago->setIdFormaPago('MPAGO');
  	$formaPago->setDenominacion('Mercado Pago');
  	$formaPago->save();
  	
  	$q = Doctrine_Manager::getInstance()->getCurrentConnection();
	$q->execute("update pedido set id_forma_pago = 'MPAGO' WHERE id_forma_pago = 'MPAON'");
	
  	$q = Doctrine_Manager::getInstance()->getCurrentConnection();
	$q->execute("delete from forma_pago where id_forma_pago = 'MPAON'");
  }

  public function down()
  {
  }
}
