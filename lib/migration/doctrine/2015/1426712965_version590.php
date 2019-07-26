<?php

class Version590 extends Doctrine_Migration_Base
{
  public function up()
  {
    $eshop = eshopTable::getInstance()->findOneByIdEshop(5);
    $eshop->setMercadoPagoClientId( '3110239340730624' );
    $eshop->setMercadoPagoClientSecret( 'QKW7CXvVt6wEROsit0Ai35EMqxDTTQLy' );
    $eshop->save();
  }

  public function down()
  {
  }
}
