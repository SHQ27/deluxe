<?php

class PermisosProbadorTallesMigration extends Doctrine_Migration_Base
{
  public function up()
  {
    $permiso = new sfGuardPermission();
    $permiso->setName('config_set_talles');
    $permiso->setDescription('Config. / Probador de Talles');
    $permiso->save();
  }

  public function down()
  {
  }
}

