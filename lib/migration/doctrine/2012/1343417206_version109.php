<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version109 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('devolucion_stock_programada', 'devolucion_stock_programada_id_pedido_pedido_id_pedido', array(
             'name' => 'devolucion_stock_programada_id_pedido_pedido_id_pedido',
             'local' => 'id_pedido',
             'foreign' => 'id_pedido',
             'foreignTable' => 'pedido',
             ));
        $this->createForeignKey('devolucion_stock_programada', 'didi_1', array(
             'name' => 'didi_1',
             'local' => 'id_devolucion_producto_item',
             'foreign' => 'id_devolucion_producto_item',
             'foreignTable' => 'devolucion_producto_item',
             ));
        $this->addIndex('devolucion_stock_programada', 'devolucion_stock_programada_id_pedido', array(
             'fields' => 
             array(
              0 => 'id_pedido',
             ),
             ));
        $this->addIndex('devolucion_stock_programada', 'devolucion_stock_programada_id_devolucion_producto_item', array(
             'fields' => 
             array(
              0 => 'id_devolucion_producto_item',
             ),
             ));
    }

    public function down()
    {
        $this->dropForeignKey('devolucion_stock_programada', 'devolucion_stock_programada_id_pedido_pedido_id_pedido');
        $this->dropForeignKey('devolucion_stock_programada', 'didi_1');
        $this->removeIndex('devolucion_stock_programada', 'devolucion_stock_programada_id_pedido', array(
             'fields' => 
             array(
              0 => 'id_pedido',
             ),
             ));
        $this->removeIndex('devolucion_stock_programada', 'devolucion_stock_programada_id_devolucion_producto_item', array(
             'fields' => 
             array(
              0 => 'id_devolucion_producto_item',
             ),
             ));
    }
}