<?php

class ProvinciasIdOCAMigration extends Doctrine_Migration_Base
{
  public function up()
  {      
      
    $provincia = provinciaTable::getInstance()->findOneByIdProvincia(1);
    $provincia->setIdOca(1);
    $provincia->save();
    
    $provincia = provinciaTable::getInstance()->findOneByIdProvincia(2);
    $provincia->setIdOca(2);
    $provincia->save();
    
    $provincia = provinciaTable::getInstance()->findOneByIdProvincia(3);
    $provincia->setIdOca(2);
    $provincia->save();
    
    $provincia = provinciaTable::getInstance()->findOneByIdProvincia(4);
    $provincia->setIdOca(10);
    $provincia->save();
    
    $provincia = provinciaTable::getInstance()->findOneByIdProvincia(5);
    $provincia->setIdOca(19);
    $provincia->save();
    
    $provincia = provinciaTable::getInstance()->findOneByIdProvincia(6);
    $provincia->setIdOca(9);
    $provincia->save();
    
    $provincia = provinciaTable::getInstance()->findOneByIdProvincia(7);
    $provincia->setIdOca(4);
    $provincia->save();
    
    $provincia = provinciaTable::getInstance()->findOneByIdProvincia(8);
    $provincia->setIdOca(5);
    $provincia->save();
    
    $provincia = provinciaTable::getInstance()->findOneByIdProvincia(9);
    $provincia->setIdOca(8);
    $provincia->save();
    
    $provincia = provinciaTable::getInstance()->findOneByIdProvincia(10);
    $provincia->setIdOca(12);
    $provincia->save();
        
    $provincia = provinciaTable::getInstance()->findOneByIdProvincia(11);
    $provincia->setIdOca(15);
    $provincia->save();
    
    $provincia = provinciaTable::getInstance()->findOneByIdProvincia(12);
    $provincia->setIdOca(13);
    $provincia->save();
    
    $provincia = provinciaTable::getInstance()->findOneByIdProvincia(13);
    $provincia->setIdOca(14);
    $provincia->save();
    
    $provincia = provinciaTable::getInstance()->findOneByIdProvincia(14);
    $provincia->setIdOca(3);
    $provincia->save();
    
    $provincia = provinciaTable::getInstance()->findOneByIdProvincia(15);
    $provincia->setIdOca(11);
    $provincia->save();
    
    $provincia = provinciaTable::getInstance()->findOneByIdProvincia(16);
    $provincia->setIdOca(6);
    $provincia->save();
    
    $provincia = provinciaTable::getInstance()->findOneByIdProvincia(17);
    $provincia->setIdOca(7);
    $provincia->save();
    
    $provincia = provinciaTable::getInstance()->findOneByIdProvincia(18);
    $provincia->setIdOca(18);
    $provincia->save();
    
    $provincia = provinciaTable::getInstance()->findOneByIdProvincia(19);
    $provincia->setIdOca(24);
    $provincia->save();
    
    $provincia = provinciaTable::getInstance()->findOneByIdProvincia(20);
    $provincia->setIdOca(16);
    $provincia->save();
    
    $provincia = provinciaTable::getInstance()->findOneByIdProvincia(21);
    $provincia->setIdOca(21);
    $provincia->save();
    
    $provincia = provinciaTable::getInstance()->findOneByIdProvincia(22);
    $provincia->setIdOca(17);
    $provincia->save();
    
    $provincia = provinciaTable::getInstance()->findOneByIdProvincia(23);
    $provincia->setIdOca(22);
    $provincia->save();
    
    $provincia = provinciaTable::getInstance()->findOneByIdProvincia(24);
    $provincia->setIdOca(20);
    $provincia->save();
    
    $provincia = provinciaTable::getInstance()->findOneByIdProvincia(25);
    $provincia->setIdOca(23);
    $provincia->save();
    
  }

  public function down()
  {
  }
}

