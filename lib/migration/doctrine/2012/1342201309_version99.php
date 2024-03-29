<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version99 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('devolucion', 'devolucion_id_bonificacion_bonificacion_id_bonificacion', array(
             'name' => 'devolucion_id_bonificacion_bonificacion_id_bonificacion',
             'local' => 'id_bonificacion',
             'foreign' => 'id_bonificacion',
             'foreignTable' => 'bonificacion',
             ));
        $this->createForeignKey('devolucion', 'devolucion_id_localidad_localidad_id_localidad', array(
             'name' => 'devolucion_id_localidad_localidad_id_localidad',
             'local' => 'id_localidad',
             'foreign' => 'id_localidad',
             'foreignTable' => 'localidad',
             ));
        $this->createForeignKey('devolucion_producto_item', 'devolucion_producto_item_id_devolucion_devolucion_id_devolucion', array(
             'name' => 'devolucion_producto_item_id_devolucion_devolucion_id_devolucion',
             'local' => 'id_devolucion',
             'foreign' => 'id_devolucion',
             'foreignTable' => 'devolucion',
             ));
        $this->createForeignKey('devolucion_producto_item', 'dipi', array(
             'name' => 'dipi',
             'local' => 'id_pedido_producto_item',
             'foreign' => 'id_pedido_producto_item',
             'foreignTable' => 'pedido_producto_item',
             ));
        $this->addIndex('devolucion', 'devolucion_id_bonificacion', array(
             'fields' => 
             array(
              0 => 'id_bonificacion',
             ),
             ));
        $this->addIndex('devolucion', 'devolucion_id_localidad', array(
             'fields' => 
             array(
              0 => 'id_localidad',
             ),
             ));
        $this->addIndex('devolucion_producto_item', 'devolucion_producto_item_id_devolucion', array(
             'fields' => 
             array(
              0 => 'id_devolucion',
             ),
             ));
        $this->addIndex('devolucion_producto_item', 'devolucion_producto_item_id_pedido_producto_item', array(
             'fields' => 
             array(
              0 => 'id_pedido_producto_item',
             ),
             ));
    }

    public function down()
    {
        $this->dropForeignKey('devolucion', 'devolucion_id_bonificacion_bonificacion_id_bonificacion');
        $this->dropForeignKey('devolucion', 'devolucion_id_localidad_localidad_id_localidad');
        $this->dropForeignKey('devolucion_producto_item', 'devolucion_producto_item_id_devolucion_devolucion_id_devolucion');
        $this->dropForeignKey('devolucion_producto_item', 'dipi');
        $this->removeIndex('devolucion', 'devolucion_id_bonificacion', array(
             'fields' => 
             array(
              0 => 'id_bonificacion',
             ),
             ));
        $this->removeIndex('devolucion', 'devolucion_id_localidad', array(
             'fields' => 
             array(
              0 => 'id_localidad',
             ),
             ));
        $this->removeIndex('devolucion_producto_item', 'devolucion_producto_item_id_devolucion', array(
             'fields' => 
             array(
              0 => 'id_devolucion',
             ),
             ));
        $this->removeIndex('devolucion_producto_item', 'devolucion_producto_item_id_pedido_producto_item', array(
             'fields' => 
             array(
              0 => 'id_pedido_producto_item',
             ),
             ));
    }
}