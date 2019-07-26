<?php

class Permisosventaonline extends Doctrine_Migration_Base
{
  public function up()
  {
  	$sfGuardPermission = new sfGuardPermission();
  	$sfGuardPermission->setName('Ver Venta Online');
  	$sfGuardPermission->setDescription('Puede ver el reporte de venta online de una campaña'); 
  	$sfGuardPermission->save();
  	
  	
  	$sfGuardGroup = new sfGuardGroup();
  	$sfGuardGroup->setName('Proveedores');
  	$sfGuardGroup->setDescription('Grupo que engloba a los usuarios de las marcas');
  	$sfGuardGroup->save();
  	
  	$sfGuardGroupPermission = new sfGuardGroupPermission();
  	$sfGuardGroupPermission->setGroupId( $sfGuardGroup->getId() );
  	$sfGuardGroupPermission->setPermissionId( $sfGuardPermission->getId() );
  	$sfGuardGroupPermission->save();
  	
  	$q = Doctrine_Manager::getInstance()->getCurrentConnection();
  	$q->execute("ALTER TABLE sf_guard_user DROP INDEX email_address;");
  }

  public function down()
  {
  }
}
