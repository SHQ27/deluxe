<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version384 extends Doctrine_Migration_Base
{
    public function up()
    {
    	$permiso = new sfGuardPermission();
    	$permiso->setName('gestion_fallados');
    	$permiso->setDescription('Gestión / Listado de Fallados');
    	$permiso->save();
    }

    public function down()
    {

    }
}