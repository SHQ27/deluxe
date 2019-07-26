<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version197 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('descuento_restriccion', 'descuento_restriccion_id_descuento_descuento_id_descuento', array(
             'name' => 'descuento_restriccion_id_descuento_descuento_id_descuento',
             'local' => 'id_descuento',
             'foreign' => 'id_descuento',
             'foreignTable' => 'descuento',
             ));
        $this->addIndex('descuento_restriccion', 'descuento_restriccion_id_descuento', array(
             'fields' => 
             array(
              0 => 'id_descuento',
             ),
             ));
    }

    public function down()
    {
        $this->dropForeignKey('descuento_restriccion', 'descuento_restriccion_id_descuento_descuento_id_descuento');
        $this->removeIndex('descuento_restriccion', 'descuento_restriccion_id_descuento', array(
             'fields' => 
             array(
              0 => 'id_descuento',
             ),
             ));
    }
}