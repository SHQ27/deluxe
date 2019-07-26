<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version208 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('producto_log', 'producto_log_id_producto_producto_id_producto', array(
             'name' => 'producto_log_id_producto_producto_id_producto',
             'local' => 'id_producto',
             'foreign' => 'id_producto',
             'foreignTable' => 'producto',
             ));
        $this->addIndex('producto_log', 'producto_log_id_producto', array(
             'fields' => 
             array(
              0 => 'id_producto',
             ),
             ));
    }

    public function down()
    {
        $this->dropForeignKey('producto_log', 'producto_log_id_producto_producto_id_producto');
        $this->removeIndex('producto_log', 'producto_log_id_producto', array(
             'fields' => 
             array(
              0 => 'id_producto',
             ),
             ));
    }
}