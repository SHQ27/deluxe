<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version316 extends Doctrine_Migration_Base
{
    public function up()
    {
      $configuracion = new configuracion();
      $configuracion->setIdConfiguracion( configuracion::MOSTRAR_CHAT );
      $configuracion->setDenominacion('Mostrar Chat');
      $configuracion->setValor(true);
      $configuracion->save();
    }

    public function down()
    {
    }
}