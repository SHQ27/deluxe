<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version309 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('faq', 'faq_id_faq_categoria_faq_categoria_id_faq_categoria', array(
             'name' => 'faq_id_faq_categoria_faq_categoria_id_faq_categoria',
             'local' => 'id_faq_categoria',
             'foreign' => 'id_faq_categoria',
             'foreignTable' => 'faq_categoria',
             ));
        $this->addIndex('faq', 'faq_id_faq_categoria', array(
             'fields' => 
             array(
              0 => 'id_faq_categoria',
             ),
             ));
    }

    public function down()
    {
        $this->dropForeignKey('faq', 'faq_id_faq_categoria_faq_categoria_id_faq_categoria');
        $this->removeIndex('faq', 'faq_id_faq_categoria', array(
             'fields' => 
             array(
              0 => 'id_faq_categoria',
             ),
             ));
    }
}