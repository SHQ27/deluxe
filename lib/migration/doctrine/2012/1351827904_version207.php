<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version207 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('producto_log', array(
             'id_producto_log' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'autoincrement' => '1',
              'length' => '4',
             ),
             'id_producto' => 
             array(
              'type' => 'integer',
              'notnull' => '1',
              'length' => '4',
             ),
             'observacion' => 
             array(
              'type' => 'string',
              'length' => '255',
             ),
             ), array(
             'type' => 'InnoDB',
             'indexes' => 
             array(
              'fk_producto_log_producto1' => 
              array(
              'fields' => 
              array(
               0 => 'id_producto',
              ),
              ),
             ),
             'primary' => 
             array(
              0 => 'id_producto_log',
             ),
             ));
    }

    public function down()
    {
        $this->dropTable('producto_log');
    }
}