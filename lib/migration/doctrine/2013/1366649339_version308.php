<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version308 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('faq', array(
             'id_faq' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'autoincrement' => '1',
              'length' => '4',
             ),
             'id_faq_categoria' => 
             array(
              'type' => 'integer',
              'zerofill' => '1',
              'notnull' => '1',
              'length' => '4',
             ),
             'pregunta' => 
             array(
              'type' => 'string',
              'length' => '255',
             ),
             'texto' => 
             array(
              'type' => 'clob',
              'length' => '65535',
             ),
             ), array(
             'type' => 'InnoDB',
             'indexes' => 
             array(
              'fk_faq_faq_categoria1' => 
              array(
              'fields' => 
              array(
               0 => 'id_faq_categoria',
              ),
              ),
             ),
             'primary' => 
             array(
              0 => 'id_faq',
             ),
             ));
        $this->createTable('faq_categoria', array(
             'id_faq_categoria' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'zerofill' => '1',
              'autoincrement' => '1',
              'length' => '4',
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
              0 => 'id_faq_categoria',
             ),
             ));
    }

    public function down()
    {
        $this->dropTable('faq');
        $this->dropTable('faq_categoria');
    }
}