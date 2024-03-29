<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version247 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('oca_envio_pedido_log', array(
             'id_oca_envio_pedido_log' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'length' => '4',
             ),
             'id_pedido' => 
             array(
              'type' => 'integer',
              'notnull' => '1',
              'length' => '4',
             ),
             'log' => 
             array(
              'type' => 'clob',
              'length' => '65535',
             ),
             'es_error' => 
             array(
              'type' => 'boolean',
              'length' => '25',
             ),
             ), array(
             'type' => 'InnoDB',
             'indexes' => 
             array(
              'fk_oca_envio_pedido_log_pedido1' => 
              array(
              'fields' => 
              array(
               0 => 'id_pedido',
              ),
              ),
             ),
             'primary' => 
             array(
              0 => 'id_oca_envio_pedido_log',
             ),
             ));
    }

    public function down()
    {
        $this->dropTable('oca_envio_pedido_log');
    }
}