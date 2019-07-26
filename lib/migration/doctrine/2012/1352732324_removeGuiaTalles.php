<?php

class RemoveGuiaTallesMigration extends Doctrine_Migration_Base
{
  public function up()
  {      
      $config = configuracionTable::getInstance()->findOneByIdConfiguracion('GUITA');
      $config->delete();
  }

  public function down()
  {
  }
}

