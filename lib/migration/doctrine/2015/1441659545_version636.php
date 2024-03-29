<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version636 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('eshop_lookbook', array(
             'id_eshop_lookbook' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'autoincrement' => '1',
              'length' => '4',
             ),
             'denominacion' => 
             array(
              'type' => 'string',
              'length' => '255',
             ),
             'id_eshop_home' => 
             array(
              'type' => 'integer',
              'notnull' => '1',
              'length' => '4',
             ),
             ), array(
             'type' => 'InnoDB',
             'primary' => 
             array(
              0 => 'id_eshop_lookbook',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'utf8',
             ));
        $this->createTable('eshop_lookbook_producto', array(
             'id_eshop_lookbook_producto' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'autoincrement' => '1',
              'length' => '4',
             ),
             'id_producto' => 
             array(
              'type' => 'integer',
              'notnull' => '1',
              'length' => '4',
             ),
             ), array(
             'type' => 'InnoDB',
             'primary' => 
             array(
              0 => 'id_eshop_lookbook_producto',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'utf8',
             ));
    }

    public function down()
    {
        $this->dropTable('eshop_lookbook');
        $this->dropTable('eshop_lookbook_producto');
    }
}