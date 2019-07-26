<?php

class Version267 extends Doctrine_Migration_Base
{
  public function up()
  {
    $permiso = new sfGuardPermission();
    $permiso->setName('prod_y_campanas_outlet');
    $permiso->setDescription('Prod. y Campañas / Outlet');
    $permiso->save();
  }

  public function down()
  {
  }
}
