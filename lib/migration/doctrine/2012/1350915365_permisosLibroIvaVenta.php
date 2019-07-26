<?php

class PermisosLibroIvaVenta extends Doctrine_Migration_Base
{
  public function up()
  {
    $permiso = new sfGuardPermission();
    $permiso->setName('facturacion_libroIvaVenta');
    $permiso->setDescription('Facturación / Libro IVA Ventas');
    $permiso->save();
  }

  public function down()
  {
  }
}

