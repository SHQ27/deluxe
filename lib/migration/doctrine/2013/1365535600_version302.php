<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version302 extends Doctrine_Migration_Base
{
    public function up()
    {
        $permiso = sfGuardPermissionTable::getInstance()->findOneByName('prod_y_campanas_edicion_stock_oca');
    	$permiso->setName('prod_y_campanas_movimiento_stock_oca');
    	$permiso->setDescription('Prod. y Campañas / Movimientos de Stock OCA');
    	$permiso->save();
    }

    public function down()
    {

    }
}