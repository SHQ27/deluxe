<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version93 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('remito', array(
             'id_remito' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'autoincrement' => '1',
              'length' => '4',
             ),
             ), array(
             'type' => 'InnoDB',
             'primary' => 
             array(
              0 => 'id_remito',
             ),
             ));
        $this->createTable('remito_pedido', array(
             'id_remito' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'length' => '4',
             ),
             'id_pedido' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'length' => '4',
             ),
             ), array(
             'type' => 'InnoDB',
             'indexes' => 
             array(
              'fk_remito_has_pedido_pedido1' => 
              array(
              'fields' => 
              array(
               0 => 'id_pedido',
              ),
              ),
              'fk_remito_has_pedido_remito1' => 
              array(
              'fields' => 
              array(
               0 => 'id_remito',
              ),
              ),
             ),
             'primary' => 
             array(
              0 => 'id_remito',
              1 => 'id_pedido',
             ),
             ));
    }

    public function down()
    {
        $this->dropTable('remito');
        $this->dropTable('remito_pedido');
    }
}