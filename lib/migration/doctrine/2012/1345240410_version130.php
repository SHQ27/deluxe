<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version130 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('pedido_producto_item_campana', 'id_marca', 'integer', '4', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('pedido_producto_item_campana', 'id_marca');
    }
}