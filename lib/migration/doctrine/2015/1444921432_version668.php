<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version668 extends Doctrine_Migration_Base
{
    public function up()
    {
	    $stockTipo = new stockTipo();
	    $stockTipo->setIdStockTipo(stockTipo::SISTEMA_RESETEO_REFUERZO);
	    $stockTipo->setDenominacion('Reseteo de Refuerzo');
	    $stockTipo->setEsDeSistema(true);
	    $stockTipo->save();    	
    }

    public function down()
    {
     
    }
}