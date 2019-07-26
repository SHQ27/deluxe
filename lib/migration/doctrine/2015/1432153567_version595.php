<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version595 extends Doctrine_Migration_Base
{
    public function up()
    {        
        $this->createTable('recepcion_mercaderia_campana', array(
             'id_recepcion_mercaderia_campana' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'autoincrement' => '1',
              'length' => '4',
             ),
             'id_campana' => 
             array(
              'type' => 'integer',
              'notnull' => '1',
              'length' => '4',
             ),
             'id_producto_item' => 
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
             'cantidad' => 
             array(
              'type' => 'integer',
              'length' => '4',
             ),
             ), array(
             'type' => 'InnoDB',
             'primary' => 
             array(
              0 => 'id_recepcion_mercaderia_campana',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'utf8',
             ));
    }

    public function down()
    {
        $this->dropTable('recepcion_mercaderia_campana');
    }
}