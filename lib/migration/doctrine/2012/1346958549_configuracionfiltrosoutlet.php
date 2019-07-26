<?php

class Configuracionfiltrosoutlet extends Doctrine_Migration_Base
{
  public function up()
  {      
      $configuracion = new configuracion();
      $configuracion->setIdConfiguracion( configuracion::FILTROS_OUTLET );
      $configuracion->setDenominacion('Mostrar filtros en outlet');
      $configuracion->setValor(true);
      $configuracion->save();
  }

  public function down()
  {
  }
}
