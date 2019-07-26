<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version194 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->dropTable('venta_outlet');
    }

    public function down()
    {
        $this->createTable('venta_outlet', array(
             'id_venta_outlet' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'autoincrement' => '1',
              'length' => '4',
             ),
             'id_producto_item' => 
             array(
              'type' => 'integer',
              'notnull' => '1',
              'length' => '4',
             ),
             'id_pedido' => 
             array(
              'type' => 'integer',
              'notnull' => '1',
              'length' => '4',
             ),
             'cantidad' => 
             array(
              'type' => 'integer',
              'length' => '4',
             ),
             ), array(
             'type' => 'InnoDB',
             'indexes' => 
             array(
              'fk_venta_devolucion_producto_item1' => 
              array(
              'fields' => 
              array(
               0 => 'id_producto_item',
              ),
              ),
              'fk_venta_devolucion_pedido1' => 
              array(
              'fields' => 
              array(
               0 => 'id_pedido',
              ),
              ),
             ),
             'primary' => 
             array(
              0 => 'id_venta_outlet',
             ),
             'collate' => '',
             'charset' => '',
             ));
    }
}