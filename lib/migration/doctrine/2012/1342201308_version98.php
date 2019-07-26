<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version98 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('devolucion', array(
             'id_devolucion' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'autoincrement' => '1',
              'length' => '4',
             ),
             'fecha' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'id_bonificacion' => 
             array(
              'type' => 'integer',
              'length' => '4',
             ),
             'tipo_envio' => 
             array(
              'type' => 'string',
              'length' => '10',
             ),
             'tipo_credito' => 
             array(
              'type' => 'string',
              'length' => '10',
             ),
             'nombre' => 
             array(
              'type' => 'string',
              'length' => '45',
             ),
             'apellido' => 
             array(
              'type' => 'string',
              'length' => '45',
             ),
             'calle' => 
             array(
              'type' => 'string',
              'length' => '45',
             ),
             'numero' => 
             array(
              'type' => 'string',
              'length' => '45',
             ),
             'piso' => 
             array(
              'type' => 'string',
              'length' => '45',
             ),
             'dpto' => 
             array(
              'type' => 'string',
              'length' => '45',
             ),
             'codigo_postal' => 
             array(
              'type' => 'string',
              'length' => '45',
             ),
             'id_localidad' => 
             array(
              'type' => 'integer',
              'notnull' => '1',
              'length' => '4',
             ),
             ), array(
             'type' => 'InnoDB',
             'indexes' => 
             array(
              'fk_devolucion_bonificacion1' => 
              array(
              'fields' => 
              array(
               0 => 'id_bonificacion',
              ),
              ),
              'fk_devolucion_localidad1' => 
              array(
              'fields' => 
              array(
               0 => 'id_localidad',
              ),
              ),
             ),
             'primary' => 
             array(
              0 => 'id_devolucion',
             ),
             ));
        $this->createTable('devolucion_producto_item', array(
             'id_devolucion_producto_item' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'autoincrement' => '1',
              'length' => '4',
             ),
             'id_devolucion' => 
             array(
              'type' => 'integer',
              'notnull' => '1',
              'length' => '4',
             ),
             'id_pedido_producto_item' => 
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
              'fk_devolucion_producto_item_devolucion1' => 
              array(
              'fields' => 
              array(
               0 => 'id_devolucion',
              ),
              ),
              'fk_devolucion_producto_item_pedido_producto_item1' => 
              array(
              'fields' => 
              array(
               0 => 'id_pedido_producto_item',
              ),
              ),
             ),
             'primary' => 
             array(
              0 => 'id_devolucion_producto_item',
             ),
             ));
    }

    public function down()
    {
        $this->dropTable('devolucion');
        $this->dropTable('devolucion_producto_item');
    }
}