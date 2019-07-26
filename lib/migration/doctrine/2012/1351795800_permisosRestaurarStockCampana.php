<?php

class PermisosRestaurarStockCampanaMigration extends Doctrine_Migration_Base
{
  public function up()
  {
    $permiso = new sfGuardPermission();
    $permiso->setName('prod_y_campanas_restaurar_stock_campana');
    $permiso->setDescription('Prod. y Campañas / Restaurar stock desde Campaña');
    $permiso->save();
  }

  public function down()
  {
  }
}

