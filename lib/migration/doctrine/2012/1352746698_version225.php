<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version225 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('producto_color', 'producto_color_id_familia_color_familia_color_id_familia_color', array(
             'name' => 'producto_color_id_familia_color_familia_color_id_familia_color',
             'local' => 'id_familia_color',
             'foreign' => 'id_familia_color',
             'foreignTable' => 'familia_color',
             ));
        $this->createForeignKey('producto_talle', 'producto_talle_id_familia_talle_familia_talle_id_familia_talle', array(
             'name' => 'producto_talle_id_familia_talle_familia_talle_id_familia_talle',
             'local' => 'id_familia_talle',
             'foreign' => 'id_familia_talle',
             'foreignTable' => 'familia_talle',
             ));
        $this->addIndex('producto_color', 'producto_color_id_familia_color', array(
             'fields' => 
             array(
              0 => 'id_familia_color',
             ),
             ));
        $this->addIndex('producto_color', 'fk_producto_color_familia_color1', array(
             'fields' => 
             array(
              0 => 'id_familia_color',
             ),
             ));
        $this->addIndex('producto_talle', 'producto_talle_id_familia_talle', array(
             'fields' => 
             array(
              0 => 'id_familia_talle',
             ),
             ));
        $this->addIndex('producto_talle', 'fk_producto_talle_familia_talle1', array(
             'fields' => 
             array(
              0 => 'id_familia_talle',
             ),
             ));
    }

    public function down()
    {
        $this->dropForeignKey('producto_color', 'producto_color_id_familia_color_familia_color_id_familia_color');
        $this->dropForeignKey('producto_talle', 'producto_talle_id_familia_talle_familia_talle_id_familia_talle');
        $this->removeIndex('producto_color', 'producto_color_id_familia_color', array(
             'fields' => 
             array(
              0 => 'id_familia_color',
             ),
             ));
        $this->removeIndex('producto_color', 'fk_producto_color_familia_color1', array(
             'fields' => 
             array(
              0 => 'id_familia_color',
             ),
             ));
        $this->removeIndex('producto_talle', 'producto_talle_id_familia_talle', array(
             'fields' => 
             array(
              0 => 'id_familia_talle',
             ),
             ));
        $this->removeIndex('producto_talle', 'fk_producto_talle_familia_talle1', array(
             'fields' => 
             array(
              0 => 'id_familia_talle',
             ),
             ));
    }
}