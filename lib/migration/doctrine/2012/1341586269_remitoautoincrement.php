<?php

class Remitoautoincrement extends Doctrine_Migration_Base
{
  public function up()
  {
  	$q = Doctrine_Manager::getInstance()->getCurrentConnection();
  	$q->execute("ALTER TABLE remito AUTO_INCREMENT = 1000 ;");
  }

  public function down()
  {
  }
}
