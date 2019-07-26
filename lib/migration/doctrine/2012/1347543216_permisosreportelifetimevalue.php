<?php

class Permisosreportelifetimevalue extends Doctrine_Migration_Base
{
  public function up()
  {
      $permiso = new sfGuardPermission();
      $permiso->setName('reportes_reporte_life_time_value');
      $permiso->setDescription('Reportes / Reporte Life Time Value');
      $permiso->save();
  }

  public function down()
  {
  }
}
