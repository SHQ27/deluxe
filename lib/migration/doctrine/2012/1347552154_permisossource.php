<?php

class Permisossource extends Doctrine_Migration_Base
{
  public function up()
  {
      $permiso = new sfGuardPermission();
      $permiso->setName('config_sources');
      $permiso->setDescription('Sources (Marketing)');
      $permiso->save();
      
  }

  public function down()
  {
  }
}
