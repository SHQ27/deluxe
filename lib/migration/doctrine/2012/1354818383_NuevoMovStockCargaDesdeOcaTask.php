<?php

class NuevoMovStockCargaDesdeOcaTask extends Doctrine_Migration_Base
{
  public function up()
  {      
    $sto = new stockTipo();
    $sto->setIdStockTipo(stockTipo::SISTEMA_CARGA_DESDE_OCA);
    $sto->setDenominacion('Carga desde OCA por ingreso de Mercaderia');
    $sto->setEsDeSistema(false);
    $sto->save();
    
  }

  public function down()
  {
  }
}


