<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version549 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('recibo_eshop', 'recibo_eshop_id_eshop_eshop_id_eshop', array(
             'name' => 'recibo_eshop_id_eshop_eshop_id_eshop',
             'local' => 'id_eshop',
             'foreign' => 'id_eshop',
             'foreignTable' => 'eshop',
             ));
        $this->addIndex('recibo_eshop', 'recibo_eshop_id_eshop', array(
             'fields' => 
             array(
              0 => 'id_eshop',
             ),
             ));
    }

    public function down()
    {
        $this->dropForeignKey('recibo_eshop', 'recibo_eshop_id_eshop_eshop_id_eshop');
        $this->removeIndex('recibo_eshop', 'recibo_eshop_id_eshop', array(
             'fields' => 
             array(
              0 => 'id_eshop',
             ),
             ));
    }
}