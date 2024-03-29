<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version196 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('descuento_restriccion', array(
             'id_descuento_restriccion' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'autoincrement' => '1',
              'length' => '4',
             ),
             'id_descuento' => 
             array(
              'type' => 'integer',
              'notnull' => '1',
              'length' => '4',
             ),
             'tipo' => 
             array(
              'type' => 'string',
              'fixed' => '1',
              'length' => '5',
             ),
             'valor' => 
             array(
              'type' => 'integer',
              'length' => '4',
             ),
             ), array(
             'type' => 'InnoDB',
             'indexes' => 
             array(
              'fk_descuento_restriccion_descuento1' => 
              array(
              'fields' => 
              array(
               0 => 'id_descuento',
              ),
              ),
             ),
             'primary' => 
             array(
              0 => 'id_descuento_restriccion',
             ),
             ));
    }

    public function down()
    {
        $this->dropTable('descuento_restriccion');

    }
}