<?php

class Permisosreportecronologico extends Doctrine_Migration_Base
{
  public function up()
  {
      $permiso = new sfGuardPermission();
      $permiso->setName('reportes_reporte_cronologico');
      $permiso->setDescription('Reportes / Reporte Cronológico');
      $permiso->save();
  }

  public function down()
  {
  }
}
