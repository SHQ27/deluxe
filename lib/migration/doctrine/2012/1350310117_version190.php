<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version190 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->dropTable('carrito_look_producto_item');
        $this->dropTable('carrito_look');
        $this->dropTable('look_imagen');
        $this->dropTable('look_producto');
        $this->dropTable('look_tag');
        $this->dropTable('look');
    }
    
    public function down()
    {
        $this->createTable('carrito_look', array(
             'id_carrito_look' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'autoincrement' => '1',
              'length' => '4',
             ),
             'id_look' => 
             array(
              'type' => 'integer',
              'notnull' => '1',
              'length' => '4',
             ),
             'id_session' => 
             array(
              'type' => 'string',
              'notnull' => '1',
              'length' => '100',
             ),
             ), array(
             'type' => 'InnoDB',
             'indexes' => 
             array(
              'fk_carrito_look_look1' => 
              array(
              'fields' => 
              array(
               0 => 'id_look',
              ),
              ),
              'fk_carrito_look_session1' => 
              array(
              'fields' => 
              array(
               0 => 'id_session',
              ),
              ),
             ),
             'primary' => 
             array(
              0 => 'id_carrito_look',
             ),
             ));
        $this->createTable('carrito_look_producto_item', array(
             'id_carrito_look' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'length' => '4',
             ),
             'id_producto_item' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'length' => '4',
             ),
             ), array(
             'type' => 'InnoDB',
             'indexes' => 
             array(
              'fk_look_producto_item_carrito_look1' => 
              array(
              'fields' => 
              array(
               0 => 'id_carrito_look',
              ),
              ),
              'fk_look_producto_item_producto_item1' => 
              array(
              'fields' => 
              array(
               0 => 'id_producto_item',
              ),
              ),
             ),
             'primary' => 
             array(
              0 => 'id_carrito_look',
              1 => 'id_producto_item',
             ),
             ));
        $this->createTable('look', array(
             'id_look' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'autoincrement' => '1',
              'length' => '4',
             ),
             'denominacion' => 
             array(
              'type' => 'string',
              'length' => '255',
             ),
             'precio' => 
             array(
              'type' => 'decimal',
              'scale' => '2',
              'length' => '12',
             ),
             'activo' => 
             array(
              'type' => 'boolean',
              'length' => '25',
             ),
             'slug' => 
             array(
              'type' => 'string',
              'length' => '255',
             ),
             ), array(
             'type' => 'InnoDB',
             'indexes' => 
             array(
              'ix_look_slug' => 
              array(
              'fields' => 
              array(
               0 => 'slug',
              ),
              ),
              'look_sluggable' => 
              array(
              'fields' => 
              array(
               0 => 'slug',
              ),
              'type' => 'unique',
              ),
             ),
             'primary' => 
             array(
              0 => 'id_look',
             ),
             ));
        $this->createTable('look_imagen', array(
             'id_look_imagen' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'autoincrement' => '1',
              'length' => '4',
             ),
             'id_look' => 
             array(
              'type' => 'integer',
              'notnull' => '1',
              'length' => '4',
             ),
             'orden' => 
             array(
              'type' => 'integer',
              'length' => '2',
             ),
             ), array(
             'type' => 'InnoDB',
             'indexes' => 
             array(
              'fk_look_imagen_look1' => 
              array(
              'fields' => 
              array(
               0 => 'id_look',
              ),
              ),
             ),
             'primary' => 
             array(
              0 => 'id_look_imagen',
             ),
             ));
        $this->createTable('look_producto', array(
             'id_look' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'length' => '4',
             ),
             'id_producto' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'length' => '4',
             ),
             ), array(
             'type' => 'InnoDB',
             'indexes' => 
             array(
              'fk_look_has_producto_look1' => 
              array(
              'fields' => 
              array(
               0 => 'id_look',
              ),
              ),
              'fk_look_has_producto_producto1' => 
              array(
              'fields' => 
              array(
               0 => 'id_producto',
              ),
              ),
             ),
             'primary' => 
             array(
              0 => 'id_look',
              1 => 'id_producto',
             ),
             ));
        $this->createTable('look_tag', array(
             'id_look' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'length' => '4',
             ),
             'id_tag' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'length' => '4',
             ),
             ), array(
             'type' => 'InnoDB',
             'indexes' => 
             array(
              'fk_look_has_tag_tag1' => 
              array(
              'fields' => 
              array(
               0 => 'id_tag',
              ),
              ),
              'fk_look_has_tag_look1' => 
              array(
              'fields' => 
              array(
               0 => 'id_look',
              ),
              ),
             ),
             'primary' => 
             array(
              0 => 'id_look',
              1 => 'id_tag',
             ),
             ));
    }
    
}