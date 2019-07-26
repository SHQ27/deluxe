<?php

class migracionComerciales extends Doctrine_Migration_Base
{
  public function up()
  {
  	$comercial = new comercial();
  	$comercial->setNombre('Horacio');
  	$comercial->setApellido('Esteves');
  	$comercial->save();
  	
  	$q = Doctrine_Manager::getInstance()->getCurrentConnection();
  	$q->execute("UPDATE campana SET id_comercial = " . $comercial->getIdComercial() . ", comision_comercial = '0.05';");
  }

  public function down()
  {
  }
}
