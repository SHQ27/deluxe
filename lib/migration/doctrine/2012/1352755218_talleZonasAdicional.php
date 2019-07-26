<?php

class TalleZonasAdicionalMigration extends Doctrine_Migration_Base
{
  public function up()
  {      
      
    $talleZona = talleZonaTable::getInstance()->findOneByIdTalleZona(1);
    $talleZona->setDescripcion('Busto: Circunferencia de tu pecho en su punto mas ancho');
    $talleZona->save();
    
    $talleZona = talleZonaTable::getInstance()->findOneByIdTalleZona(2);
    $talleZona->setDescripcion('Cintura: Circunferencia de tu cintura en su punto mas estrecho');
    $talleZona->save();
    
    $talleZona = talleZonaTable::getInstance()->findOneByIdTalleZona(3);
    $talleZona->setDescripcion('Cadera: Circunferencia de tu cadera en su punto mas estrecho');
    $talleZona->save();
    
    $talleZona = talleZonaTable::getInstance()->findOneByIdTalleZona(4);
    $talleZona->setDescripcion('Busto: Circunferencia de tu pecho en su punto mas ancho');
    $talleZona->save();
    
    $talleZona = talleZonaTable::getInstance()->findOneByIdTalleZona(5);
    $talleZona->setDescripcion('Cintura: Circunferencia de tu cintura en su punto mas estrecho');
    $talleZona->save();
    
    $talleZona = talleZonaTable::getInstance()->findOneByIdTalleZona(6);
    $talleZona->setDescripcion('Cadera: Circunferencia de tu cadera en su punto mas estrecho');
    $talleZona->save();
  }

  public function down()
  {
  }
}

