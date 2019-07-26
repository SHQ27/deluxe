<?php

class Permisosgestionverificarfacturaoca extends Doctrine_Migration_Base
{
  public function up()
  {
      $permiso = new sfGuardPermission();
      $permiso->setName('gestion_verificar_factura_oca');
      $permiso->setDescription('Gestión / Verificar Factura OCA');
      $permiso->save();
  }

  public function down()
  {
  }
}
