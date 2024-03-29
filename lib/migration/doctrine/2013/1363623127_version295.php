<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version295 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('pedido_yqv', 'pedido_yqv_id_pedido_pedido_id_pedido', array(
             'name' => 'pedido_yqv_id_pedido_pedido_id_pedido',
             'local' => 'id_pedido',
             'foreign' => 'id_pedido',
             'foreignTable' => 'pedido',
             ));
        $this->addIndex('pedido_yqv', 'pedido_yqv_id_pedido', array(
             'fields' => 
             array(
              0 => 'id_pedido',
             ),
             ));
    }

    public function down()
    {
        $this->dropForeignKey('pedido_yqv', 'pedido_yqv_id_pedido_pedido_id_pedido');
        $this->removeIndex('pedido_yqv', 'pedido_yqv_id_pedido', array(
             'fields' => 
             array(
              0 => 'id_pedido',
             ),
             ));
    }
}