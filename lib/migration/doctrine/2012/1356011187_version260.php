<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version260 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->removeColumn('pedido_producto_item', 'es_outlet');
        $this->removeColumn('pedido_producto_item', 'venta_outlet');
        $this->removeColumn('stock', 'es_outlet');
    }

    public function down()
    {
        $this->addColumn('pedido_producto_item', 'es_outlet', 'boolean', '25', array(
             ));
        $this->addColumn('pedido_producto_item', 'venta_outlet', 'integer', '4', array(
             ));
        $this->addColumn('stock', 'es_outlet', 'boolean', '25', array(
             ));
    }
}