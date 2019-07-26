<?php

class Updatecostooutlet extends Doctrine_Migration_Base
{
  public function up()
  {
      $q = Doctrine_Manager::getInstance()->getCurrentConnection();
      $q->execute("UPDATE pedido_producto_item SET costo = 0 WHERE es_outlet = true;");
  }

  public function down()
  {
  }
}
