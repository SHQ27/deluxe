<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version248 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('oca_envio_pedido_log', 'oca_envio_pedido_log_id_pedido_pedido_id_pedido', array(
             'name' => 'oca_envio_pedido_log_id_pedido_pedido_id_pedido',
             'local' => 'id_pedido',
             'foreign' => 'id_pedido',
             'foreignTable' => 'pedido',
             ));
        $this->addIndex('oca_envio_pedido_log', 'oca_envio_pedido_log_id_pedido', array(
             'fields' => 
             array(
              0 => 'id_pedido',
             ),
             ));
    }

    public function down()
    {
        $this->dropForeignKey('oca_envio_pedido_log', 'oca_envio_pedido_log_id_pedido_pedido_id_pedido');
        $this->removeIndex('oca_envio_pedido_log', 'oca_envio_pedido_log_id_pedido', array(
             'fields' => 
             array(
              0 => 'id_pedido',
             ),
             ));
    }
}