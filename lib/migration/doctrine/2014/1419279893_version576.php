<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version576 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('pedido', 'pedido_envio_id_locker_oca_locker_oca_id_locker_oca', array(
             'name' => 'pedido_envio_id_locker_oca_locker_oca_id_locker_oca',
             'local' => 'envio_id_locker_oca',
             'foreign' => 'id_locker_oca',
             'foreignTable' => 'locker_oca',
             ));
        $this->createForeignKey('pedido', 'pedido_envio_tamanio_locker_oca', array(
             'name' => 'pedido_envio_tamanio_locker_oca',
             'local' => 'envio_id_tamanio_locker_oca',
             'foreign' => 'id_tamanio_locker_oca',
             'foreignTable' => 'tamanio_locker_oca',
             ));
        $this->addIndex('pedido', 'pedido_envio_id_locker_oca', array(
             'fields' => 
             array(
              0 => 'envio_id_locker_oca',
             ),
             ));
        $this->addIndex('pedido', 'pedido_envio_id_tamanio_locker_oca', array(
             'fields' => 
             array(
              0 => 'envio_id_tamanio_locker_oca',
             ),
             ));
        $this->addIndex('pedido', 'fk_pedido_tamanio_locker_oca1', array(
             'fields' => 
             array(
              0 => 'envio_id_tamanio_locker_oca',
             ),
             ));
        $this->addIndex('pedido', 'fk_pedido_locker_oca1', array(
             'fields' => 
             array(
              0 => 'envio_id_locker_oca',
             ),
             ));
    }

    public function down()
    {
        $this->dropForeignKey('pedido', 'pedido_envio_id_locker_oca_locker_oca_id_locker_oca');
        $this->dropForeignKey('pedido', 'pedido_envio_tamanio_locker_oca');
        $this->removeIndex('pedido', 'pedido_envio_id_locker_oca', array(
             'fields' => 
             array(
              0 => 'envio_id_locker_oca',
             ),
             ));
        $this->removeIndex('pedido', 'pedido_envio_id_tamanio_locker_oca', array(
             'fields' => 
             array(
              0 => 'envio_id_tamanio_locker_oca',
             ),
             ));
        $this->removeIndex('pedido', 'fk_pedido_tamanio_locker_oca1', array(
             'fields' => 
             array(
              0 => 'envio_id_tamanio_locker_oca',
             ),
             ));
        $this->removeIndex('pedido', 'fk_pedido_locker_oca1', array(
             'fields' => 
             array(
              0 => 'envio_id_locker_oca',
             ),
             ));
    }
}