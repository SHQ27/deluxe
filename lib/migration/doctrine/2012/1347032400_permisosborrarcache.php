<?php

class Permisosborrarcache extends Doctrine_Migration_Base
{
  public function up()
  {
      
      $permiso = new sfGuardPermission();
      $permiso->setName('gestion_borrar_cache');
      $permiso->setDescription('Gestion / Borrar Cache');
      $permiso->save();
  }

  public function down()
  {
  }
}
