<?php

class TalleZonasMigration extends Doctrine_Migration_Base
{
  public function up()
  {      
    $talleZona = new talleZona();
    $talleZona->setDenominacion('Busto');
    $talleZona->setOrden(1);
    $talleZona->save();
    
    $talleZona = new talleZona();
    $talleZona->setDenominacion('Cintura');
    $talleZona->setOrden(2);
    $talleZona->save();
    
    $talleZona = new talleZona();
    $talleZona->setDenominacion('Cadera');
    $talleZona->setOrden(3);
    $talleZona->save();
    
    $talleZona = new talleZona();
    $talleZona->setDenominacion('Contorno de Pecho');
    $talleZona->setOrden(1);
    $talleZona->save();
    
    $talleZona = new talleZona();
    $talleZona->setDenominacion('Contorno de Cintura');
    $talleZona->setOrden(2);
    $talleZona->save();
    
    $talleZona = new talleZona();
    $talleZona->setDenominacion('Contorno de Cadera');
    $talleZona->setOrden(3);
    $talleZona->save();
  }

  public function down()
  {
  }
}

