<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version341 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('premio_log', 'premio_log_id_premio_premio_id_premio', array(
             'name' => 'premio_log_id_premio_premio_id_premio',
             'local' => 'id_premio',
             'foreign' => 'id_premio',
             'foreignTable' => 'premio',
             ));
        $this->createForeignKey('premio_log', 'premio_log_id_bonificacion_bonificacion_id_bonificacion', array(
             'name' => 'premio_log_id_bonificacion_bonificacion_id_bonificacion',
             'local' => 'id_bonificacion',
             'foreign' => 'id_bonificacion',
             'foreignTable' => 'bonificacion',
             ));
        $this->createForeignKey('premio_log', 'premio_log_id_pedido_pedido_id_pedido', array(
             'name' => 'premio_log_id_pedido_pedido_id_pedido',
             'local' => 'id_pedido',
             'foreign' => 'id_pedido',
             'foreignTable' => 'pedido',
             ));
        $this->addIndex('premio_log', 'premio_log_id_premio', array(
             'fields' => 
             array(
              0 => 'id_premio',
             ),
             ));
        $this->addIndex('premio_log', 'premio_log_id_bonificacion', array(
             'fields' => 
             array(
              0 => 'id_bonificacion',
             ),
             ));
        $this->addIndex('premio_log', 'premio_log_id_pedido', array(
             'fields' => 
             array(
              0 => 'id_pedido',
             ),
             ));
    }

    public function down()
    {
        $this->dropForeignKey('premio_log', 'premio_log_id_premio_premio_id_premio');
        $this->dropForeignKey('premio_log', 'premio_log_id_bonificacion_bonificacion_id_bonificacion');
        $this->dropForeignKey('premio_log', 'premio_log_id_pedido_pedido_id_pedido');
        $this->removeIndex('premio_log', 'premio_log_id_premio', array(
             'fields' => 
             array(
              0 => 'id_premio',
             ),
             ));
        $this->removeIndex('premio_log', 'premio_log_id_bonificacion', array(
             'fields' => 
             array(
              0 => 'id_bonificacion',
             ),
             ));
        $this->removeIndex('premio_log', 'premio_log_id_pedido', array(
             'fields' => 
             array(
              0 => 'id_pedido',
             ),
             ));
    }
}