<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version151 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('source', array(
             'id_source' => 
             array(
              'type' => 'string',
              'fixed' => '1',
              'primary' => '1',
              'length' => '3',
             ),
             'denominacion' => 
             array(
              'type' => 'string',
              'length' => '255',
             ),
             ), array(
             'type' => 'InnoDB',
             'primary' => 
             array(
              0 => 'id_source',
             ),
             ));
    }

    public function down()
    {
        $this->dropTable('source');
    }
}