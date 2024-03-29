<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version635 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('eshop_imagen_campaign', 'eshop_imagen_campaign_id_eshop_home_eshop_home_id_eshop_home', array(
             'name' => 'eshop_imagen_campaign_id_eshop_home_eshop_home_id_eshop_home',
             'local' => 'id_eshop_home',
             'foreign' => 'id_eshop_home',
             'foreignTable' => 'eshop_home',
             ));
        $this->addIndex('eshop_imagen_campaign', 'eshop_imagen_campaign_id_eshop_home', array(
             'fields' => 
             array(
              0 => 'id_eshop_home',
             ),
             ));
    }

    public function down()
    {
        $this->dropForeignKey('eshop_imagen_campaign', 'eshop_imagen_campaign_id_eshop_home_eshop_home_id_eshop_home');
        $this->removeIndex('eshop_imagen_campaign', 'eshop_imagen_campaign_id_eshop_home', array(
             'fields' => 
             array(
              0 => 'id_eshop_home',
             ),
             ));
    }
}