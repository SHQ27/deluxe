<?php

class removeOldCodigosPostalesMigration extends Doctrine_Migration_Base
{
  public function up()
  {      
      $q = Doctrine_Manager::getInstance()->getCurrentConnection();
      $q->execute("DELETE FROM direccion_envio WHERE codigo_postal not in (SELECT valor from codigo_postal);");
  }

  public function down()
  {
  }
}