<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version692 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('devuelto_marca', 'id_producto_item', 'integer', '4', array(
             'notnull' => '',
             ));
        $this->addColumn('fallado', 'id_producto_item', 'integer', '4', array(
             'notnull' => '',
             ));
    }

    public function down()
    {
        $this->removeColumn('devuelto_marca', 'id_producto_item');
        $this->removeColumn('fallado', 'id_producto_item');
    }
}