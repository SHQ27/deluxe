<?php

class IndicesCategorias extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addIndex('producto_categoria', 'ix_productoGenero_denominacion', array(
             'fields' => 
             array(
              0 => 'denominacion',
             ),
             ));
        $this->addIndex('producto_genero', 'ix_productoGenero_denominacion', array(
             'fields' => 
             array(
              0 => 'denominacion',
             ),
             ));
    }

    public function down()
    {
        $this->removeIndex('producto_categoria', 'ix_productoGenero_denominacion', array(
             'fields' => 
             array(
              0 => 'denominacion',
             ),
             ));
        $this->removeIndex('producto_genero', 'ix_productoGenero_denominacion', array(
             'fields' => 
             array(
              0 => 'denominacion',
             ),
             ));
    }
}
