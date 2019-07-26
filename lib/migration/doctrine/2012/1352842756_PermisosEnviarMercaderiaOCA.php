<?php

class PermisosEnviarMercaderiaOCAMigration extends Doctrine_Migration_Base
{
  public function up()
  {
    $permiso = new sfGuardPermission();
    $permiso->setName('gestion_enviar_mercaderia_oca');
    $permiso->setDescription('Gestión / Enviar Mercadería a OCA');
    $permiso->save();
  }

  public function down()
  {
  }
}

