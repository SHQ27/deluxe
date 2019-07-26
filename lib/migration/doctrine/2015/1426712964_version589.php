<?php

class Version589 extends Doctrine_Migration_Base
{
  public function up()
  {
  	$formaPago = new formaPago();
  	$formaPago->setIdFormaPago('DECID');
  	$formaPago->setDenominacion('Decidir');
  	$formaPago->save();
  }

  public function down()
  {
  }
}
