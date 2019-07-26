<?php

class Version13 extends Doctrine_Migration_Base
{
  public function up()
  {
  $this->addColumn('pedido', 'requiere_intervencion_manual', 'boolean', '25', array(
   'default' => '0',
   ));
  }

  public function down()
  {
  $this->removeColumn('pedido', 'requiere_intervencion_manual');
  }
}




