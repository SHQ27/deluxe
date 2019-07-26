<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version256 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('codigo_postal', 'codigo_postal_id_provincia_provincia_id_provincia', array(
             'name' => 'codigo_postal_id_provincia_provincia_id_provincia',
             'local' => 'id_provincia',
             'foreign' => 'id_provincia',
             'foreignTable' => 'provincia',
             ));
        $this->addIndex('codigo_postal', 'codigo_postal_id_provincia', array(
             'fields' => 
             array(
              0 => 'id_provincia',
             ),
             ));
    }

    public function down()
    {
        $this->dropForeignKey('codigo_postal', 'codigo_postal_id_provincia_provincia_id_provincia');
        $this->removeIndex('codigo_postal', 'codigo_postal_id_provincia', array(
             'fields' => 
             array(
              0 => 'id_provincia',
             ),
             ));
    }
}