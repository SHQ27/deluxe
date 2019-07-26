<?php

class Version120 extends Doctrine_Migration_Base
{
  public function up()
  {
    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $q->execute("UPDATE descuento SET restriccion_productos = '' WHERE restriccion_productos <> 1;");
    $q->execute("UPDATE descuento SET restriccion_productos = 'PRODUC' WHERE restriccion_productos = 1;");
  }

  public function down()
  {
  }
}
