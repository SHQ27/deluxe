<?php

class TipificacionMovStockTask extends Doctrine_Migration_Base
{
  public function up()
  {      
    $sto = new stockTipo();
    $sto->setIdStockTipo(stockTipo::MANUAL_CARGA_INICIAL);
    $sto->setDenominacion('Carga inicial (Manual)');
    $sto->setEsDeSistema(false);
    $sto->save();
    
    $sto = new stockTipo();
    $sto->setIdStockTipo(stockTipo::MANUAL_REAJUSTE);
    $sto->setDenominacion('Reajuste de stock');
    $sto->setEsDeSistema(false);
    $sto->save();
    
    $sto = new stockTipo();
    $sto->setIdStockTipo(stockTipo::MANUAL_RESETEO);
    $sto->setDenominacion('Reseteo manual');
    $sto->setEsDeSistema(false);
    $sto->save();
    
    $sto = new stockTipo();
    $sto->setIdStockTipo(stockTipo::MANUAL_REPOSICION);
    $sto->setDenominacion('Reposición');
    $sto->setEsDeSistema(false);
    $sto->save();
    
    $sto = new stockTipo();
    $sto->setIdStockTipo(stockTipo::MANUAL_OTRO);
    $sto->setDenominacion('Otro');
    $sto->setEsDeSistema(false);
    $sto->save();
    
    $sto = new stockTipo();
    $sto->setIdStockTipo(stockTipo::SISTEMA_CARGA_MASIVA);
    $sto->setDenominacion('Carga Masiva');
    $sto->setEsDeSistema(true);
    $sto->save();

    $sto = new stockTipo();
    $sto->setIdStockTipo(stockTipo::SISTEMA_IMPORTACION_INICIAL);
    $sto->setDenominacion('Importacion Inicial (CSV)');
    $sto->setEsDeSistema(true);
    $sto->save();
    
    $sto = new stockTipo();
    $sto->setIdStockTipo(stockTipo::SISTEMA_DEVOLUCION);
    $sto->setDenominacion('Devolucion');
    $sto->setEsDeSistema(true);
    $sto->save();
    
    $sto = new stockTipo();
    $sto->setIdStockTipo(stockTipo::SISTEMA_BAJA_PEDIDO);
    $sto->setDenominacion('Baja de Pedido');
    $sto->setEsDeSistema(true);
    $sto->save();
    
    $sto = new stockTipo();
    $sto->setIdStockTipo(stockTipo::SISTEMA_VENTA);
    $sto->setDenominacion('Venta');
    $sto->setEsDeSistema(true);
    $sto->save();
    
    $sto = new stockTipo();
    $sto->setIdStockTipo(stockTipo::SISTEMA_FALTANTE);
    $sto->setDenominacion('Faltante');
    $sto->setEsDeSistema(true);
    $sto->save();
    
    $sto = new stockTipo();
    $sto->setIdStockTipo(stockTipo::SISTEMA_RESETEO_CAMPANA);
    $sto->setDenominacion('Reseteo de Campaña');
    $sto->setEsDeSistema(true);
    $sto->save();
       
    $sto = new stockTipo();
    $sto->setIdStockTipo(stockTipo::SISTEMA_REACTIVACION_PEDIDO);
    $sto->setDenominacion('Reactivacion de Pedido');
    $sto->setEsDeSistema(true);
    $sto->save();
    
    $sto = new stockTipo();
    $sto->setIdStockTipo(stockTipo::SISTEMA_EMPAQUETADO);
    $sto->setDenominacion('Empaquetado');
    $sto->setEsDeSistema(true);
    $sto->save();
    
    $sto = new stockTipo();
    $sto->setIdStockTipo(stockTipo::SISTEMA_RESTAURACION_CAMPANA);
    $sto->setDenominacion('Restauracion de Campaña');
    $sto->setEsDeSistema(true);
    $sto->save();
    
    

    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $q->execute("UPDATE stock SET id_stock_tipo = " . stockTipo::MANUAL_OTRO . ';');
    
  }

  public function down()
  {
  }
}


