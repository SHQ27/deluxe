<?php

class Removecampanaifoutlet extends Doctrine_Migration_Base
{
  public function up()
  {
  	$q = Doctrine_Manager::getInstance()->getCurrentConnection();
  	$q->execute("delete from producto_campana where id_producto in ( SELECT id_producto FROM producto where es_outlet);");  	
  }

  public function down()
  {
  }
}
