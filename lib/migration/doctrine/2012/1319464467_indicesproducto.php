<?php

class Indicesproducto extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addIndex('producto', 'ix_producto_precio_deluxe', array(
             'fields' => 
             array(
              0 => 'precio_deluxe',
             ),
             ));
        $this->addIndex('producto', 'ix_producto_visitas', array(
             'fields' => 
             array(
              0 => 'visitas',
             ),
             ));
        $this->addIndex('producto', 'ix_producto_vendidos', array(
             'fields' => 
             array(
              0 => 'vendidos',
             ),
             ));
    }

    public function down()
    {
        $this->removeIndex('producto', 'ix_producto_precio_deluxe', array(
             'fields' => 
             array(
              0 => 'precio_deluxe',
             ),
             ));
        $this->removeIndex('producto', 'ix_producto_visitas', array(
             'fields' => 
             array(
              0 => 'visitas',
             ),
             ));
        $this->removeIndex('producto', 'ix_producto_vendidos', array(
             'fields' => 
             array(
              0 => 'vendidos',
             ),
             ));
    }
}
