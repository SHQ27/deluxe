<?php

class Updatedevolucionproductoitemcantidadstock extends Doctrine_Migration_Base
{
  public function up()
  {
      $q = Doctrine_Manager::getInstance()->getCurrentConnection();
      $q->execute("UPDATE devolucion_producto_item SET cantidad_stock = cantidad;");
  }

  public function down()
  {
  }
}
