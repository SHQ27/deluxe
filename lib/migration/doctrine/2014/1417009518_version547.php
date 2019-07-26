<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version547 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('recibo_eshop_pedido', 'recibo_eshop_pedido_id_recibo_eshop_recibo_eshop_id_recibo_eshop', array(
             'name' => 'recibo_eshop_pedido_id_recibo_eshop_recibo_eshop_id_recibo_eshop',
             'local' => 'id_recibo_eshop',
             'foreign' => 'id_recibo_eshop',
             'foreignTable' => 'recibo_eshop',
             ));
        $this->createForeignKey('recibo_eshop_pedido', 'recibo_eshop_pedido_id_pedido_pedido_id_pedido', array(
             'name' => 'recibo_eshop_pedido_id_pedido_pedido_id_pedido',
             'local' => 'id_pedido',
             'foreign' => 'id_pedido',
             'foreignTable' => 'pedido',
             ));
        $this->addIndex('recibo_eshop_pedido', 'recibo_eshop_pedido_id_recibo_eshop', array(
             'fields' => 
             array(
              0 => 'id_recibo_eshop',
             ),
             ));
        $this->addIndex('recibo_eshop_pedido', 'recibo_eshop_pedido_id_pedido', array(
             'fields' => 
             array(
              0 => 'id_pedido',
             ),
             ));
    }

    public function down()
    {
        $this->dropForeignKey('recibo_eshop_pedido', 'recibo_eshop_pedido_id_recibo_eshop_recibo_eshop_id_recibo_eshop');
        $this->dropForeignKey('recibo_eshop_pedido', 'recibo_eshop_pedido_id_pedido_pedido_id_pedido');
        $this->removeIndex('recibo_eshop_pedido', 'recibo_eshop_pedido_id_recibo_eshop', array(
             'fields' => 
             array(
              0 => 'id_recibo_eshop',
             ),
             ));
        $this->removeIndex('recibo_eshop_pedido', 'recibo_eshop_pedido_id_pedido', array(
             'fields' => 
             array(
              0 => 'id_pedido',
             ),
             ));
    }
}