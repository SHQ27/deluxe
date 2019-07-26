<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version91 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('devuelto_oca', 'devuelto_oca_id_pedido_pedido_id_pedido', array(
             'name' => 'devuelto_oca_id_pedido_pedido_id_pedido',
             'local' => 'id_pedido',
             'foreign' => 'id_pedido',
             'foreignTable' => 'pedido',
             ));
        $this->addIndex('devuelto_oca', 'devuelto_oca_id_pedido', array(
             'fields' => 
             array(
              0 => 'id_pedido',
             ),
             ));
    }

    public function down()
    {
        $this->dropForeignKey('devuelto_oca', 'devuelto_oca_id_pedido_pedido_id_pedido');
        $this->removeIndex('devuelto_oca', 'devuelto_oca_id_pedido', array(
             'fields' => 
             array(
              0 => 'id_pedido',
             ),
             ));
    }
}