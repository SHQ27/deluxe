<?php

class Nuevomotivodevolucion extends Doctrine_Migration_Base
{
  public function up()
  {
      $devolucionMotivo = new devolucionMotivo();
      $devolucionMotivo->setIdDevolucionMotivo('NMGEP');
      $devolucionMotivo->setDenominacion('No me gusto el producto');
      $devolucionMotivo->save();
  }

  public function down()
  {
  }
}
