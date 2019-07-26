<?php

class Updatecostoenviodeluxe extends Doctrine_Migration_Base
{
  public function up()
  {
      $q = Doctrine_Manager::getInstance()->getCurrentConnection();
      $q->execute("UPDATE costo_envio SET valor_estandar_deluxe = 0, valor_sucursal_deluxe = 0;");      
  }

  public function down()
  {
  }
}
