<?php

class PermisosFamiliaTalleColorMigration extends Doctrine_Migration_Base
{
  public function up()
  {
    $permiso = new sfGuardPermission();
    $permiso->setName('prod_y_campanas_familia_talles');
    $permiso->setDescription('Config. / Familia de Talles');
    $permiso->save();
    
    $permiso = new sfGuardPermission();
    $permiso->setName('prod_y_campanas_familia_colores');
    $permiso->setDescription('Config. / Familia de Colores');
    $permiso->save();
  }

  public function down()
  {
  }
}

