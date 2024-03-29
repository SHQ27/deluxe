<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version143 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('cuota', 'cuota_id_banco_banco_id_banco', array(
             'name' => 'cuota_id_banco_banco_id_banco',
             'local' => 'id_banco',
             'foreign' => 'id_banco',
             'foreignTable' => 'banco',
             ));
        $this->createForeignKey('cuota', 'cuota_id_tarjeta_tarjeta_id_tarjeta', array(
             'name' => 'cuota_id_tarjeta_tarjeta_id_tarjeta',
             'local' => 'id_tarjeta',
             'foreign' => 'id_tarjeta',
             'foreignTable' => 'tarjeta',
             ));
        $this->addIndex('cuota', 'cuota_id_banco', array(
             'fields' => 
             array(
              0 => 'id_banco',
             ),
             ));
        $this->addIndex('cuota', 'cuota_id_tarjeta', array(
             'fields' => 
             array(
              0 => 'id_tarjeta',
             ),
             ));
    }

    public function down()
    {
        $this->dropForeignKey('cuota', 'cuota_id_banco_banco_id_banco');
        $this->dropForeignKey('cuota', 'cuota_id_tarjeta_tarjeta_id_tarjeta');
        $this->removeIndex('cuota', 'cuota_id_banco', array(
             'fields' => 
             array(
              0 => 'id_banco',
             ),
             ));
        $this->removeIndex('cuota', 'cuota_id_tarjeta', array(
             'fields' => 
             array(
              0 => 'id_tarjeta',
             ),
             ));
    }
}