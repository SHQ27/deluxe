<?php

class Permisosreportecuponeras extends Doctrine_Migration_Base
{
  public function up()
  {
      $permiso = new sfGuardPermission();
      $permiso->setName('reportes_reporte_cuponeras');
      $permiso->setDescription('Reportes / Reporte de Cuponeras');
      $permiso->save();
  }

  public function down()
  {
  }
}
