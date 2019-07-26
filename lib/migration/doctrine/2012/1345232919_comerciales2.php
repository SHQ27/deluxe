<?php

class migracionComerciales2 extends Doctrine_Migration_Base
{
  public function up()
  {
      $q = Doctrine_Manager::getInstance()->getCurrentConnection();
      $q->execute("UPDATE campana_marca SET id_comercial = 1, comision_comercial = '0.05';");
  }

  public function down()
  {
  }
}
