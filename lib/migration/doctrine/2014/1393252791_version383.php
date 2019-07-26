<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version383 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('fallado', 'fipi', array(
             'name' => 'fipi',
             'local' => 'id_pedido_producto_item',
             'foreign' => 'id_pedido_producto_item',
             'foreignTable' => 'pedido_producto_item',
             ));
        $this->addIndex('fallado', 'fallado_id_pedido_producto_item', array(
             'fields' => 
             array(
              0 => 'id_pedido_producto_item',
             ),
             ));
    }

    public function down()
    {
        $this->dropForeignKey('fallado', 'fipi');
        $this->removeIndex('fallado', 'fallado_id_pedido_producto_item', array(
             'fields' => 
             array(
              0 => 'id_pedido_producto_item',
             ),
             ));
    }
}