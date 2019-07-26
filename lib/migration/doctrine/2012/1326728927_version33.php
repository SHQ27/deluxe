<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version33 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('cupon', array(
             'id_cupon' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'autoincrement' => '1',
              'length' => '4',
             ),
             'fecha_desde' => 
             array(
              'type' => 'date',
              'length' => '25',
             ),
             'fecha_hasta' => 
             array(
              'type' => 'date',
              'length' => '25',
             ),
             ), array(
             'type' => 'InnoDB',
             'primary' => 
             array(
              0 => 'id_cupon',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'utf8',
             ));
        $this->createTable('cupon_producto', array(
             'id_cupon' => 
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
              'fk_cupon_has_producto_producto1' => 
              array(
              'fields' => 
              array(
               0 => 'id_producto',
              ),
              ),
              'fk_cupon_has_producto_cupon1' => 
              array(
              'fields' => 
              array(
               0 => 'id_cupon',
              ),
              ),
             ),
             'primary' => 
             array(
              0 => 'id_cupon',
              1 => 'id_producto',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'utf8',
             ));
    }

    public function down()
    {
        $this->dropTable('cupon');
        $this->dropTable('cupon_producto');
    }
}