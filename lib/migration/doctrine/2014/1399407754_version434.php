<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version434 extends Doctrine_Migration_Base
{
    public function up()
    {
    	$permiso = new sfGuardPermission();
    	$permiso->setName('reportes_reporte_mensual');
    	$permiso->setDescription('Reportes / Reporte Mensual');
    	$permiso->save();
    }

    public function down()
    {

    }
}