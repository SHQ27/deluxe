<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version567 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('locker_oca', 'locker_oca_id_provincia_provincia_id_provincia', array(
             'name' => 'locker_oca_id_provincia_provincia_id_provincia',
             'local' => 'id_provincia',
             'foreign' => 'id_provincia',
             'foreignTable' => 'provincia',
             ));
        $this->addIndex('locker_oca', 'locker_oca_id_provincia', array(
             'fields' => 
             array(
              0 => 'id_provincia',
             ),
             ));
    }

    public function down()
    {
        $this->dropForeignKey('locker_oca', 'locker_oca_id_provincia_provincia_id_provincia');
        $this->removeIndex('locker_oca', 'locker_oca_id_provincia', array(
             'fields' => 
             array(
              0 => 'id_provincia',
             ),
             ));
    }
}