<?php

class Version610 extends Doctrine_Migration_Base
{
  public function up()
  {
    $permiso = new sfGuardPermission();
    $permiso->setName('config_promociones_de_pago');
    $permiso->setDescription('Config. / Promociones de Pago');
    $permiso->save();
  }

  public function down()
  {
  }
}

