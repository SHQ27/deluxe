<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version498 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('pedido', 'pedido_id_eshop_eshop_id_eshop', array(
             'name' => 'pedido_id_eshop_eshop_id_eshop',
             'local' => 'id_eshop',
             'foreign' => 'id_eshop',
             'foreignTable' => 'eshop',
             ));
        $this->addIndex('pedido', 'pedido_id_eshop', array(
             'fields' => 
             array(
              0 => 'id_eshop',
             ),
             ));
    }

    public function down()
    {
        $this->dropForeignKey('pedido', 'pedido_id_eshop_eshop_id_eshop');
        $this->removeIndex('pedido', 'pedido_id_eshop', array(
             'fields' => 
             array(
              0 => 'id_eshop',
             ),
             ));
    }
}