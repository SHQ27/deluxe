<?php

class PermisosfueraDePlazoBaja extends Doctrine_Migration_Base
{
  public function up()
  {
    $permiso = new sfGuardPermission();
    $permiso->setName('gestion_bajas_por_fuera_de_plazo');
    $permiso->setDescription('Gestión / Bajas por Fuera de Plazo');
    $permiso->save();
  }

  public function down()
  {
  }
}

