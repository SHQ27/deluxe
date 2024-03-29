<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version395 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('producto_sticker', array(
             'id_producto_sticker' => 
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
             ), array(
             'type' => 'InnoDB',
             'primary' => 
             array(
              0 => 'id_producto_sticker',
             ),
             ));
        $this->addColumn('producto', 'id_producto_sticker', 'integer', '4', array(
             ));
    }

    public function down()
    {
        $this->dropTable('producto_sticker');
        $this->removeColumn('producto', 'id_producto_sticker');
    }
}