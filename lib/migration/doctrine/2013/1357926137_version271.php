<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version271 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addIndex('producto', 'ix_producto_codigo', array(
             'fields' => 
             array(
              0 => 'codigo',
             ),
             ));
    }

    public function down()
    {
        $this->removeIndex('producto', 'ix_producto_codigo', array(
             'fields' => 
             array(
              0 => 'codigo',
             ),
             ));
    }
}