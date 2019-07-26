<?php

class Limpiarcodigoenvio extends Doctrine_Migration_Base
{
  public function up()
  {
      $conn = Doctrine_Manager::connection();
      $conn->getDbh()->exec('update pedido set codigo_envio = TRIM(BOTH \'"\' FROM codigo_envio);');
  }

}
