<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version136 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('pedido', 'pibi', array(
             'name' => 'pibi',
             'local' => 'id_bonificacion_baja_fuera_plazo',
             'foreign' => 'id_bonificacion',
             'foreignTable' => 'bonificacion',
             ));
        $this->addIndex('pedido', 'pedido_id_bonificacion_baja_fuera_plazo', array(
             'fields' => 
             array(
              0 => 'id_bonificacion_baja_fuera_plazo',
             ),
             ));
    }

    public function down()
    {
        $this->dropForeignKey('pedido', 'pibi');
        $this->removeIndex('pedido', 'pedido_id_bonificacion_baja_fuera_plazo', array(
             'fields' => 
             array(
              0 => 'id_bonificacion_baja_fuera_plazo',
             ),
             ));
    }
}