<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Reporteyqv extends Doctrine_Migration_Base
{
    public function up()
    {
    	$permiso = new sfGuardPermission();
    	$permiso->setName('reportes_reporte_venta_yqv');
    	$permiso->setDescription('Reportes / Reporte de Ventas YQV');
    	$permiso->save();
    }

    public function down()
    {

    }
}