<?php

class Version298 extends Doctrine_Migration_Base
{
  public function up()
  {      
    $sto = new stockTipo();
    $sto->setIdStockTipo(stockTipo::SISTEMA_RETIRO_OCA);
    $sto->setDenominacion('Retiro de Stock del deposito de OCA');
    $sto->setEsDeSistema(true);
    $sto->save();
    
  }

  public function down()
  {
  }
}


