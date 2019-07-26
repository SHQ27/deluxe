<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version564 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('locker', 'locker_id_provincia_provincia_id_provincia', array(
             'name' => 'locker_id_provincia_provincia_id_provincia',
             'local' => 'id_provincia',
             'foreign' => 'id_provincia',
             'foreignTable' => 'provincia',
             ));
        $this->addIndex('locker', 'locker_id_provincia', array(
             'fields' => 
             array(
              0 => 'id_provincia',
             ),
             ));
    }

    public function down()
    {
        $this->dropForeignKey('locker', 'locker_id_provincia_provincia_id_provincia');
        $this->removeIndex('locker', 'locker_id_provincia', array(
             'fields' => 
             array(
              0 => 'id_provincia',
             ),
             ));
    }
}