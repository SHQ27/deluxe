<?php

class Transpasobajapedido extends Doctrine_Migration_Base
{
  public function up()
  {
      $q = Doctrine_Manager::getInstance()->getCurrentConnection();
      $q->execute("INSERT INTO fuera_de_plazo_baja SELECT null, id_pedido, 'DELUXE' ,id_bonificacion_baja_fuera_plazo FROM pedido where id_bonificacion_baja_fuera_plazo is not null;");
      $q->execute("UPDATE pedido SET id_bonificacion_baja_fuera_plazo = NULL;");
  }

  public function down()
  {
  }
}
