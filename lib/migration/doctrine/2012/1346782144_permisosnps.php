<?php

class Permisosnps extends Doctrine_Migration_Base
{
  public function up()
  {
      
      $permiso = new sfGuardPermission();
      $permiso->setName('config_cuotas');
      $permiso->setDescription('Config. / Cuotas');
      $permiso->save();
      
  }

  public function down()
  {
  }
}
