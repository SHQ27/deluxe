<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version430 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addIndex('pago_notificacion', 'fk_pago_notificacion_id', array(
             'fields' => 
             array(
              0 => 'id',
              1 => 'id_forma_pago',
             ),
             ));
    }

    public function down()
    {
        $this->removeIndex('pago_notificacion', 'fk_pago_notificacion_id', array(
             'fields' => 
             array(
              0 => 'id',
              1 => 'id_forma_pago',
             ),
             ));
    }
}