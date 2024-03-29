<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version303 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('oca_pedido_anulado', array(
             'id_oca_pedido_anulado' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'autoincrement' => '1',
              'length' => '4',
             ),
             'id_pedido' => 
             array(
              'type' => 'integer',
              'notnull' => '1',
              'length' => '4',
             ),
             'fecha' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             ), array(
             'type' => 'InnoDB',
             'indexes' => 
             array(
              'fk_oca_pedido_anulado_pedido1' => 
              array(
              'fields' => 
              array(
               0 => 'id_pedido',
              ),
              ),
             ),
             'primary' => 
             array(
              0 => 'id_oca_pedido_anulado',
             ),
             ));
    }

    public function down()
    {
        $this->dropTable('oca_pedido_anulado');
    }
}