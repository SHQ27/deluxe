<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version396 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('producto', 'pipi_14', array(
             'name' => 'pipi_14',
             'local' => 'id_producto_sticker',
             'foreign' => 'id_producto_sticker',
             'foreignTable' => 'producto_sticker',
             ));
        $this->addIndex('producto', 'producto_id_producto_sticker', array(
             'fields' => 
             array(
              0 => 'id_producto_sticker',
             ),
             ));
    }

    public function down()
    {
        $this->dropForeignKey('producto', 'pipi_14');
        $this->removeIndex('producto', 'producto_id_producto_sticker', array(
             'fields' => 
             array(
              0 => 'id_producto_sticker',
             ),
             ));
    }
}