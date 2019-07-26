<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version492 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('faq_categoria', 'faq_categoria_id_eshop_eshop_id_eshop', array(
             'name' => 'faq_categoria_id_eshop_eshop_id_eshop',
             'local' => 'id_eshop',
             'foreign' => 'id_eshop',
             'foreignTable' => 'eshop',
             ));
        $this->addIndex('faq_categoria', 'faq_categoria_id_eshop', array(
             'fields' => 
             array(
              0 => 'id_eshop',
             ),
             ));
    }

    public function down()
    {
        $this->dropForeignKey('faq_categoria', 'faq_categoria_id_eshop_eshop_id_eshop');
        $this->removeIndex('faq_categoria', 'faq_categoria_id_eshop', array(
             'fields' => 
             array(
              0 => 'id_eshop',
             ),
             ));
    }
}