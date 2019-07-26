<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version185 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('fuera_de_plazo_baja', 'fuera_de_plazo_baja_id_pedido_pedido_id_pedido', array(
             'name' => 'fuera_de_plazo_baja_id_pedido_pedido_id_pedido',
             'local' => 'id_pedido',
             'foreign' => 'id_pedido',
             'foreignTable' => 'pedido',
             ));
        $this->createForeignKey('fuera_de_plazo_baja', 'fuera_de_plazo_baja_id_bonificacion_bonificacion_id_bonificacion', array(
             'name' => 'fuera_de_plazo_baja_id_bonificacion_bonificacion_id_bonificacion',
             'local' => 'id_bonificacion',
             'foreign' => 'id_bonificacion',
             'foreignTable' => 'bonificacion',
             ));
        $this->addIndex('fuera_de_plazo_baja', 'fuera_de_plazo_baja_id_pedido', array(
             'fields' => 
             array(
              0 => 'id_pedido',
             ),
             ));
        $this->addIndex('fuera_de_plazo_baja', 'fuera_de_plazo_baja_id_bonificacion', array(
             'fields' => 
             array(
              0 => 'id_bonificacion',
             ),
             ));
    }

    public function down()
    {
        $this->dropForeignKey('fuera_de_plazo_baja', 'fuera_de_plazo_baja_id_pedido_pedido_id_pedido');
        $this->dropForeignKey('fuera_de_plazo_baja', 'fuera_de_plazo_baja_id_bonificacion_bonificacion_id_bonificacion');
        $this->removeIndex('fuera_de_plazo_baja', 'fuera_de_plazo_baja_id_pedido', array(
             'fields' => 
             array(
              0 => 'id_pedido',
             ),
             ));
        $this->removeIndex('fuera_de_plazo_baja', 'fuera_de_plazo_baja_id_bonificacion', array(
             'fields' => 
             array(
              0 => 'id_bonificacion',
             ),
             ));
    }
}