<?php

class Permisosinfraestructura extends Doctrine_Migration_Base
{
  public function up()
  {
  	$sfGuardPermission = new sfGuardPermission();
  	$sfGuardPermission->setName('Infraestructura');
  	$sfGuardPermission->setDescription('Administra tema de infraestructura, instancias, etc.'); 
  	$sfGuardPermission->save();
  	
  	
  	$sfGuardGroup = new sfGuardGroup();
  	$sfGuardGroup->setName('Infraestructura');
  	$sfGuardGroup->setDescription('Grupo que engloba los usuarios con permiso de Infraestructura');
  	$sfGuardGroup->save();
  	
  	$sfGuardGroupPermission = new sfGuardGroupPermission();
  	$sfGuardGroupPermission->setGroupId( $sfGuardGroup->getId() );
  	$sfGuardGroupPermission->setPermissionId( $sfGuardPermission->getId() );
  	$sfGuardGroupPermission->save();
  }

  public function down()
  {
  }
}
